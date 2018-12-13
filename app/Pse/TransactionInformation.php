<?php

namespace App\Pse;

class TransactionInformation
{
	protected $transactionID;
	protected $sessionID;
	protected $reference;
	protected $requestDate;
	protected $bankProcessDate;
	protected $onTest;
	protected $returnCode;
	protected $trazabilityCode;
	protected $transactionCycle;
	protected $transactionState;
	protected $responseCode;
	protected $responseReasonCode;
	protected $responseReasonText;
	

	public function __construct($info)
	{
		$this->transactionID = $info->getTransactionInformationResult->transactionID;
		$this->sessionID = $info->getTransactionInformationResult->sessionID;
		$this->reference = $info->getTransactionInformationResult->reference;
		$this->requestDate = $info->getTransactionInformationResult->requestDate;
		$this->bankProcessDate = $info->getTransactionInformationResult->bankProcessDate;
		$this->onTest = $info->getTransactionInformationResult->onTest;
		$this->returnCode = $info->getTransactionInformationResult->returnCode;
		$this->trazabilityCode = $info->getTransactionInformationResult->trazabilityCode;
		$this->transactionCycle = $info->getTransactionInformationResult->transactionCycle;
		$this->transactionState = $info->getTransactionInformationResult->transactionState;
		$this->responseCode = $info->getTransactionInformationResult->responseCode;
		$this->responseReasonCode = $info->getTransactionInformationResult->responseReasonCode;
		$this->responseReasonText = $info->getTransactionInformationResult->responseReasonText;
		
	}
	
	public function gettransactionID()
	{
		return $this->transactionID;
	}
	
	public function getsessionID()
	{
		return $this->sessionID;
	}
	
	public function getreference()
	{
		return $this->reference;
	}
	
	public function getrequestDate()
	{
		return $this->requestDate;
	}	
	
	public function getbankProcessDate()
	{
		return $this->bankProcessDate;
	}
	
	public function getonTest()
	{
		return $this->onTest;
	}
		
	public function getreturnCode()
	{
		return $this->returnCode;
	}

	public function gettrazabilityCode()
	{
		return $this->trazabilityCode;
	}
	
	public function gettransactionCycle()
	{
		return $this->transactionCycle;
	}
	
	public function gettransactionState()
	{
		return $this->transactionState;
	}
		
	public function getresponseCode()
	{
		return $this->responseCode;
	}
	
	public function getresponseReasonCode()
	{
		return $this->responseReasonCode;
	}
	
	public function getresponseReasonText()
	{
		return $this->responseReasonText;
	}		
}
