<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePersons;
use App\Payment;
use App\Person;
use App\Transaction;
use App\TransactionResult;
use App\Pse\Authentication as PseAuthentication;
use App\Pse\Attribute as PseAttribute;
use App\Pse\Bank as PseBank;
use App\Pse\Person as PsePerson;
use App\Pse\TransactionInformation as PseTransactionInformation;
use App\Pse\TransactionRequest as PseTransactionRequest;
use App\Pse\TransactionResponse as PseTransactionResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Validator;

class PaymentController extends Controller
{
	private $wsClient;
	private $wsError;
	private $wsMesssage;
	
	public function __construct()
	{
		date_default_timezone_set('America/Bogota');		
	}
	
	/*
	* Obtain the ws client
	* @return void
	*/
	public function getWsClient()
	{
		try
		{
			$this->wsClient = new \SoapClient(config('app.urlws'));
			$this->wsClient->__setLocation(config('app.urlendpointws'));
			$this->wsError = 0;
		}
		catch( \Exception $e )
		{
			$this->wsError = 1;
			$this->ws_message = 'Error al crear cliente: '.$e->getMessage();
		}
	}
	
	/*
	* Obtain the bank list
	* @return array
	*/
	public function getBanks()
	{
		$this->getWsClient();
			
		if($this->wsError == 0)
		{
			//create additional params and send this to the authentication object
			$additional1 = new PseAttribute('date', date('Y-m-d'));
			$additional2 = new PseAttribute('time', date('H:i:s'));
			$additional = ['item'=>[$additional1, $additional2]];
			$auth = new PseAuthentication($additional);
			
			try
			{
				$banksList = $this->wsClient->getBankList(['auth'=>$auth]);
				$banks = [];
				
				foreach( $banksList->getBankListResult as $item ):
					foreach( $item as $value ):
						$bank = new PseBank($value);
						$banks[] = $bank;
					endforeach;
				endforeach;
				
				return $banks;
			}
			catch( \Exception $e )
			{
				$this->wsError = 2;
				$this->wsMessage = 'Error al obtener lista de bancos,';
				$this->wsMessage .= '<br>Code: '.$e->getCode();
				$this->wsMessage .= '<br>Message: '.$e->getMessage();
			}
		}
	}
	
	/*
	* Save the data of payer and buyer in database and return to the next page
	* @return redirection
	*/
	public function savePersons(SavePersons $request)
	{
		$validated = $request->validated();	
		
		$payer = 
				[
					'document'=>$request->input('documentPayer')
					,'documentType'=>$request->input('documentTypePayer')
					,'firstName'=>$request->input('firstNamePayer')
					,'lastName'=>$request->input('lastNamePayer')
					,'company'=>$request->input('companyPayer')
					,'emailAddress'=>$request->input('emailAddressPayer')
					,'address'=>$request->input('addressPayer')
					,'city'=>$request->input('cityPayer')
					,'province'=>$request->input('provincePayer')
					,'country'=>$request->input('countryPayer')
					,'phone'=>$request->input('phonePayer')
					,'mobile'=>$request->input('mobilePayer')
				];
				
		$payer = Person::create($payer);
		
		$buyer = 
				[
					'document'=>$request->input('documentBuyer')
					,'documentType'=>$request->input('documentTypeBuyer')
					,'firstName'=>$request->input('firstNameBuyer')
					,'lastName'=>$request->input('lastNameBuyer')
					,'company'=>$request->input('companyBuyer')
					,'emailAddress'=>$request->input('emailAddressBuyer')
					,'address'=>$request->input('addressBuyer')
					,'city'=>$request->input('cityBuyer')
					,'province'=>$request->input('provinceBuyer')
					,'country'=>$request->input('countryBuyer')
					,'phone'=>$request->input('phoneBuyer')
					,'mobile'=>$request->input('mobileBuyer')
				];
				
		$buyer = Person::create($buyer);
		
		return redirect()->action('PaymentController@step1', ['payer'=>$payer->id,'buyer'=>$buyer->id]);
	}
	
	/*
	* Obtain data of payer, buyer, banks and webservice response
	* @return view
	*/
	public function step1($payer, $buyer, Request $request)
	{
		// Cache::forget('banks');
		
		if( !Cache::has('banks') )
		{
			$time = 1440;
			Cache::put('banks', $this->getBanks(), $time);
		}
		
		$info['payer'] = Person::find($payer);
		$info['buyer'] = Person::find($buyer);
		$info['banks'] = Cache::get('banks');
		$info['wserror'] = $this->wsError;
		return view('step1', ['info'=>$info]);
	}
	
	/*
	* Get data of payer and buyer in database, and create Payment
	* @return ajax response array
	*/
	public function step2(Request $request)
	{
		$payer = Person::find($request->input('payer'));
		$buyer = Person::find($request->input('buyer'));
		$wspayer = new PsePerson($payer);
		$wsbuyer = new PsePerson($buyer);
		
		$persons = [$payer, $buyer];
		$result = '';
		
		foreach($persons as $idperson=>$person)
		{
			if($idperson == 0)
				$color = '707070';
			else if($idperson == 1)
				$color = 'D7D7D7';
			
			$result.= '<div class="col" style="background-color:#'.$color.';">';
			$fields = 
						[
							'document','documentType','firstName','lastName'
							,'company','emailAddress','address','city'
							,'province','country','phone','mobile'
						];
			$i = 0;
			$j = 1;
			for($k = 1; $k <= 6; $k++)
			{
				$result.= '<div class="form-group row" >
							<div class="form-group col-md-6">
								'.$fields[$i].': <b>'.$person[$fields[$i]].'</b>
							</div>
							<div class="form-group col-md-6">
								'.$fields[$j].': <b>'.$person[$fields[$j]].'</b>
							</div>
						</div>';
				$i = $i + 2; 
				$j = $j + 2; 
			}
					
			$result.= '</div>';
		}
			
		if( $request->input('reference') == 'P' )
			$description = 'Pago';
		else if( $request->input('reference') == 'F' )
			$description = 'Factura';
		
		$info = 
				[
					'bankCode' => $request->input('bankCode'),
					'bankInterface' => $request->input('bankInterface') - 1,
					'reference' => $request->input('reference').'-'.rand(365,365 * 4),
					'description' => $description,
					'totalAmount' => $request->input('totalAmount'),
					'payer_id' => $request->input('payer'),
					'buyer_id' => $request->input('buyer'),
					'ipAddress' => $request->server('REMOTE_ADDR'),
					'userAgent' => $request->header('USER_AGENT')
				];
		$payment = Payment::create($info);
		$reference = $payment->reference.'-'.$payment->id;
		
		DB::table('payment')
			->where('id', $payment->id)
			->update(['reference' => $reference]);
			
		$additional1 		 = new PseAttribute('date', date('Y-m-d'));
		$additional2 		 = new PseAttribute('time', date('H:i:s'));
		$additional  		 = ['item'=>[$additional1, $additional2]];
			
		$info = 
				[
					'bankCode' => $request->input('bankCode'),
					'bankInterface' => $request->input('bankInterface') - 1,
					'returnURL' => config('app.url').'/paytest/public/step3/'.$reference,
					'reference' => $reference,
					'description' => 'Transacción paytest',
					'language' => 'ES',
					'currency' => 'COP',
					'totalAmount' => $request->input('totalAmount'),
					'taxAmount' => 0,
					'devolutionBase' => 0,
					'tipAmount' => 0,
					'payer' => $wspayer,
					'buyer' => $wsbuyer,
					'shipping' => [],
					'ipAddress' => $request->server('REMOTE_ADDR'),
					'userAgent' => $request->header('USER_AGENT'),
					'additionalData' => $additional
				];
		
		$result.= "<div class='col' style='background-color:#B0B0B0;'>";
			$result.= " <div class='form-group row' >
							<div class='form-group col-md-6'>
								bankCode: <b>".$info['bankCode']."</b>
							</div>
							<div class='form-group col-md-6'>
								bankInterface: <b>".$info['bankInterface']."</b>
							</div>
						</div>";
			$result.= " <div class='form-group row' >
							<div class='form-group col-md-6'>
								returnURL: <b>".$info['returnURL']."</b>
							</div>
							<div class='form-group col-md-6'>
								reference: <b>".$info['reference']."</b>
							</div>
						</div>";
			$result.= " <div class='form-group row' >
							<div class='form-group col-md-6'>
								description: <b>".$info['description']."</b>
							</div>
							<div class='form-group col-md-6'>
								language: <b>".$info['language']."</b>
							</div>
						</div>";
			$result.= " <div class='form-group row' >
							<div class='form-group col-md-6'>
								currency: <b>".$info['currency']."</b>
							</div>
							<div class='form-group col-md-6'>
								totalAmount: <b>".$info['totalAmount']."</b>
							</div>
						</div>";
			$result.= " <div class='form-group row' >
							<div class='form-group col-md-6'>
								taxAmount: <b>".$info['taxAmount']."</b>
							</div>
							<div class='form-group col-md-6'>
								devolutionBase: <b>".$info['devolutionBase']."</b>
							</div>
						</div>";
			$result.= " <div class='form-group row' >
							<div class='form-group col-md-6'>
								tipAmount: <b>".$info['tipAmount']."</b>
							</div>
							<div class='form-group col-md-6'>
								payer: <b>Ver Pagador</b>
							</div>
						</div>";
			$result.= " <div class='form-group row' >
							<div class='form-group col-md-6'>
								buyer: <b>Ver Comprador</b>
							</div>
							<div class='form-group col-md-6'>
								shipping: <b>Array</b>
							</div>
						</div>";
			$result.= " <div class='form-group row' >
							<div class='form-group col-md-6'>
								ipAddress: <b>".$info['ipAddress']."</b>
							</div>
							<div class='form-group col-md-6'>
								userAgent: <b>".$info['userAgent']."</b>
							</div>
						</div>";
			$result.= " <div class='form-group row' >
							<div class='form-group col-md-6'>
								additionalData: <b>Object</b>
							</div>
						</div>";
		$result.= '</div>';
		
		$auth 		 		 = new PseAuthentication($additional);
		$transactionRequest  = new PseTransactionRequest($info);
			
		$info = ['auth'=>$auth, 'transaction'=>$transactionRequest];
		
		try
		{
			$this->getWsClient();
			$transactionResponse = new PseTransactionResponse($this->wsClient->createTransaction($info));
			$info = 
					[
						'transactionID' =>  $transactionResponse->gettransactionID(),
						'sessionID' =>  $transactionResponse->getsessionID(),
						'returnCode' =>  $transactionResponse->getreturnCode(),
						'trazabilityCode' =>  $transactionResponse->gettrazabilityCode(),
						'transactionCycle' =>  $transactionResponse->gettransactionCycle(),
						'bankCurrency' =>  $transactionResponse->getbankCurrency(),
						'bankFactor' =>  $transactionResponse->getbankFactor(),
						'bankURL' =>  $transactionResponse->getbankURL(),
						'responseCode' =>  $transactionResponse->getresponseCode(),
						'responseReasonCode' =>  $transactionResponse->getresponseReasonCode(),
						'responseReasonText' =>  $transactionResponse->getresponseReasonText()
					];
			$transaction = Transaction::create($info);
			
			DB::table('payment')
			->where('id', $payment->id)
			->update(['transaction_id' => $transaction->id]);
			
			$result2 = "
			<div class='col' style='background-color:#707070;'>
				<div class='form-group row' >
					<div class='form-group col-md-6'>
						returnCode: ".$transactionResponse->getreturnCode()."
					</div>
					<div class='form-group col-md-6'>
						bankURL: ".$transactionResponse->getbankURL()."
					</div>
				</div>
				<div class='form-group row' >
					<div class='form-group col-md-6'>
						bankCurrency: ".$transactionResponse->getbankCurrency()."
					</div>
					<div class='form-group col-md-6'>
						bankFactor: ".$transactionResponse->getbankFactor()."
					</div>
				</div>
			</div>
			<div class='col' style='background-color:#D7D7D7;'>
				<div class='form-group row' >
					<div class='form-group col-md-6'>
						trazabilityCode: ".$transactionResponse->gettrazabilityCode()."
					</div>
					<div class='form-group col-md-6'>
						transactionCycle: ".$transactionResponse->gettransactionCycle()."
					</div>
				</div>
				<div class='form-group row' >
					<div class='form-group col-md-6'>
						responseCode: ".$transactionResponse->getresponseCode()."
					</div>
					<div class='form-group col-md-6'>
						responseReasonCode: ".$transactionResponse->getresponseReasonCode()."
					</div>
				</div>
			</div>
			<div class='col' style='background-color:#B0B0B0;'>
				<div class='form-group row' >
					<div class='form-group col-md-6'>
						transactionID: ".$transactionResponse->gettransactionID()."
					</div>
					<div class='form-group col-md-6'>
						sessionID: ".$transactionResponse->getsessionID()."
					</div>
				</div>
				<div class='form-group row' >
					<div class='form-group col-md-6'>
						responseReasonText: ".$transactionResponse->getresponseReasonText()."
					</div>
				</div>
			</div>";
			$result3 = 
						[
							'returnCode'=>$transactionResponse->getreturnCode(), 
							'bankURL'=>$transactionResponse->getbankURL() 
						];
			
		}
		catch(\Exception $e)
		{
			$this->wsError = 3;
			$this->ws_message = 'Error al crear transacción: '.$e->getCode().' - '.$e->getMessage();
			$result2 = "
			<div class='col alert alert-danger' role='alert'>
				<div class='form-group row' >
					<div class='form-group col-md-12'>
						Error: ".$this->ws_message."
					</div>
				</div>
			</div>
			";
			$result3 = 
						[
							'returnCode'=>$e->getCode(), 
							'bankURL'=>$e->getMessage() 
						];
		}
			
		if( $request->ajax() )			
			return response()->json(['result'=>$result, 'result2'=>$result2, 'result3'=>$result3]);
		else
			return ['result'=>$result, 'result2'=>$result2, 'result3'=>$result3];
	}
	
	/*
	* Get data of transaction
	* @return ajax response array
	*/
	public function step3($reference, Request $request)
	{
		$additional1  = new PseAttribute('date', date('Y-m-d'));
		$additional2  = new PseAttribute('time', date('H:i:s'));
		$additional   = ['item'=>[$additional1, $additional2]];
		$this->wsAuth = new PseAuthentication($additional);
		$transaction  = DB::table('payment')
			->join('transaction','payment.transaction_id','=','transaction.id')
			->select(
						'payment.id AS payment_id', 'transaction.id AS transaction_id', 
						'transaction.transactionID', 'transaction.state'
					)
			->where('reference', $reference)
			->get();
		$text = '';
		
		if( !sizeof($transaction) )
			$text = 'Referencia '.$reference.' no encontrada';
		else if ( $transaction[0]->state == 'PROCESSED' )
			$text = 'La referencia '.$reference.' ya fue procesada';
			
		if( !empty($text) )
		{
			$result = "
			<div class='col alert alert-danger' role='alert'>
				<div class='form-group row' >
					<div class='form-group col-md-12'>
						".$text." 
					</div>
				</div>
			</div>
			";
		}
		else if( $transaction[0]->state == 'CREATED' )
		{
			try
			{
				$this->getWsClient();
				$info = ['auth'=>$this->wsAuth, 'transactionID'=>$transaction[0]->transactionID];
				$transactionInformation = new PseTransactionInformation($this->wsClient->getTransactionInformation($info));
				$info = 
						[
							'transaction_id' =>  $transaction[0]->transaction_id,
							'transactionID' =>  $transactionInformation->gettransactionID(),
							'sessionID' =>  $transactionInformation->getsessionID(),
							'reference' =>  $transactionInformation->getreference(),
							'requestDate' =>  $transactionInformation->getrequestDate(),
							'bankProcessDate' =>  $transactionInformation->getbankProcessDate(),
							'onTest' =>  $transactionInformation->getonTest(),
							'returnCode' =>  $transactionInformation->getreturnCode(),
							'trazabilityCode' =>  $transactionInformation->gettrazabilityCode(),
							'transactionCycle' =>  $transactionInformation->gettransactionCycle(),
							'transactionState' =>  $transactionInformation->gettransactionState(),
							'responseCode' =>  $transactionInformation->getresponseCode(),
							'responseReasonCode' =>  $transactionInformation->getresponseReasonCode(),
							'responseReasonText' =>  $transactionInformation->getresponseReasonText(),
						];
				$transactionResult = TransactionResult::create($info);
				
				if( $transactionResult->transactionState != 'PENDING' )
					DB::table('transaction')
					->where('id', $transaction[0]->transaction_id)
					->update(['state'=>'PROCESSED']);
				
				$payment = DB::table('payment AS p')
					->join('transaction AS t', 'p.transaction_id', '=', 't.id')
					->join('transaction_result AS r', 't.id', '=', 'r.transaction_id')
					->select(
								'p.reference', 'p.description',
								'p.totalAmount', 't.state',
								't.transactionID', 't.trazabilityCode',
								'r.transactionState', 'r.responseReasonText'
							)
					->where('p.reference', $reference)
					->get();
				
				$result = "
				<div class='col' style='background-color:#707070;'>
					<div class='form-group row' >
						<div class='form-group col-md-6'>
							Referencia: ".$payment[0]->reference."
						</div>
						<div class='form-group col-md-6'>
							Descripción: ".$payment[0]->description."
						</div>
					</div>
					<div class='form-group row' >
						<div class='form-group col-md-6'>
							Total: ".$payment[0]->totalAmount."
						</div>
					</div>
				</div>
				<div class='col' style='background-color:#D7D7D7;'>
					<div class='form-group row' >
						<div class='form-group col-md-6'>
							Transacción PSE: ".$payment[0]->transactionID."
						</div>
						<div class='form-group col-md-6'>
							Código Trazabilidad PSE: ".$payment[0]->trazabilityCode."
						</div>
					</div>
				</div>
				<div class='col' style='background-color:#B0B0B0;'>
					<div class='form-group row' >
						<div class='form-group col-md-6'>
							Respuesta: ".$payment[0]->transactionState.' - '.$payment[0]->responseReasonText."
						</div>						
					</div>
				</div>";
				
			}
			catch(\Exception $e)
			{
				$this->wsError = 3;
				$this->ws_message = 'Error al obtener información de la transacción: '.$e->getCode().' - '.$e->getMessage();
				$result = "
				<div class='col alert alert-danger' role='alert'>
					<div class='form-group row' >
						<div class='form-group col-md-12'>
							".$this->ws_message."
						</div>
					</div>
				</div>
				";
			}
		}
		
		return view('step3', ['result'=>$result]);				
	}
	
	/*
	* Get data of pending transactions
	* @return ajax response array
	*/
	public function pendingTransactions()
	{
		$transactions = DB::table('transaction')
			->select('transaction.id', 'transaction.transactionID')
			->where('state', 'CREATED')
			->offset(0)
			->limit(20)
			->get();
		$result = '';

		if( !sizeof($transactions) )
		{
			$result .= "
					<div class='col alert alert-danger' role='alert'>
						<div class='form-group row' >
							<div class='form-group col-md-12'>
								No hay transacciones pendientes
							</div>
						</div>
					</div>
					";
		}
		else
		{
			foreach($transactions as $id=>$transaction):
				try
				{
					$additional1  = new PseAttribute('date', date('Y-m-d'));
					$additional2  = new PseAttribute('time', date('H:i:s'));
					$additional   = ['item'=>[$additional1, $additional2]];
					$auth 		  = new PseAuthentication($additional);
					$info 		  = ['auth'=>$auth, 'transactionID'=>$transaction->transactionID];
					
					$this->getWsClient();
					$transactionInformation = new PseTransactionInformation($this->wsClient->getTransactionInformation($info));
					$info = 
							[
								'transaction_id' =>  $transaction->id,
								'transactionID' =>  $transactionInformation->gettransactionID(),
								'sessionID' =>  $transactionInformation->getsessionID(),
								'reference' =>  $transactionInformation->getreference(),
								'requestDate' =>  $transactionInformation->getrequestDate(),
								'bankProcessDate' =>  $transactionInformation->getbankProcessDate(),
								'onTest' =>  $transactionInformation->getonTest(),
								'returnCode' =>  $transactionInformation->getreturnCode(),
								'trazabilityCode' =>  $transactionInformation->gettrazabilityCode(),
								'transactionCycle' =>  $transactionInformation->gettransactionCycle(),
								'transactionState' =>  $transactionInformation->gettransactionState(),
								'responseCode' =>  $transactionInformation->getresponseCode(),
								'responseReasonCode' =>  $transactionInformation->getresponseReasonCode(),
								'responseReasonText' =>  $transactionInformation->getresponseReasonText(),
							];
					$transactionresult = TransactionResult::create($info);
					DB::table('transaction')->where('id',$transaction->id)->update(['state' => 'PROCESSED']);
					
					$result .= "
					<div class='col' style='background-color:#707070;'>
						<b>Id ".($id + 1)."</b>
						<div class='form-group row' >
							<div class='form-group col-md-6'>
								transactionID: ".$transactionInformation->gettransactionID()."
							</div>
							<div class='form-group col-md-6'>
								reference: ".$transactionInformation->getreference()."
							</div>
						</div>
						<div class='form-group row' >
							<div class='form-group col-md-6'>
								returnCode: ".$transactionInformation->getreturnCode()."
							</div>
							<div class='form-group col-md-6'>
								transactionState: ".$transactionInformation->gettransactionState()."
							</div>
						</div>
					</div>
					<div class='col' style='background-color:#D7D7D7;'>
						<div class='form-group row' >
							<div class='form-group col-md-6'>
								responseCode: ".$transactionInformation->getresponseCode()."
							</div>
							<div class='form-group col-md-6'>
								responseReasonCode: ".$transactionInformation->getresponseReasonCode()."
							</div>
						</div>
						<div class='form-group row' >
							<div class='form-group col-md-6'>
								responseCode: ".$transactionInformation->getresponseCode()."
							</div>
							<div class='form-group col-md-6'>
								responseReasonCode: ".$transactionInformation->getresponseReasonCode()."
							</div>
						</div>
					</div>
					<div class='col' style='background-color:#B0B0B0;'>
						<div class='form-group row' >
							<div class='form-group col-md-6'>
								transactionID: ".$transactionInformation->gettransactionID()."
							</div>
							<div class='form-group col-md-6'>
								sessionID: ".$transactionInformation->getsessionID()."
							</div>
						</div>
						<div class='form-group row' >
							<div class='form-group col-md-6'>
								responseReasonText: ".$transactionInformation->getresponseReasonText()."
							</div>
						</div>
					</div>";
					
				}
				catch(\Exception $e)
				{
					$this->ws_message = 'Error al obtener información de la transacción: '.$e->getCode().' - '.$e->getMessage();
					$result .= "
					<div class='col alert alert-danger' role='alert'>
						<b>Id ".($id + 1)."</b>
						<div class='form-group row' >
							<div class='form-group col-md-12'>
								".$this->ws_message."
							</div>
						</div>
					</div>
					";
				}
			endforeach;
		}
		echo $result;
	}
}
