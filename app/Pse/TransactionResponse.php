<?php

namespace App\Pse;

class TransactionResponse
{
	protected $transactionID;
	protected $sessionID;
	protected $returnCode;
	protected $trazabilityCode;
	protected $transactionCycle;
	protected $bankCurrency;
	protected $bankFactor;
	protected $bankURL;
	protected $responseCode;
	protected $responseReasonCode;
	protected $responseReasonText;

	public function __construct($info)
	{
		$this->transactionID = $info->createTransactionResult->transactionID;
		$this->sessionID = $info->createTransactionResult->sessionID;
		$this->returnCode = $info->createTransactionResult->returnCode;
		$this->trazabilityCode = $info->createTransactionResult->trazabilityCode;
		$this->transactionCycle = $info->createTransactionResult->transactionCycle;
		$this->bankCurrency = $info->createTransactionResult->bankCurrency;
		$this->bankFactor = $info->createTransactionResult->bankFactor;
		$this->bankURL = $info->createTransactionResult->bankURL;
		$this->responseCode = $info->createTransactionResult->responseCode;
		$this->responseReasonCode = $info->createTransactionResult->responseReasonCode;
		$this->responseReasonText = $info->createTransactionResult->responseReasonText;
	}
	
	public function gettransactionID()
	{
		return $this->transactionID;
	}
	
	public function getsessionID()
	{
		return $this->sessionID;
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
	
	public function getbankCurrency()
	{
		return $this->bankCurrency;
	}
	
	public function getbankFactor()
	{
		return $this->bankFactor;
	}
	
	public function getbankURL()
	{
		return $this->bankURL;
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
