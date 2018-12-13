<?php

namespace App\Pse;

class TransactionRequest
{
	protected $bankCode;
	protected $bankInterface;
	protected $returnURL;
	protected $reference;
	protected $description;
	protected $language;
	protected $currency;
	protected $totalAmount;
	protected $taxAmount;
	protected $devolutionBase;
	protected $tipAmount;
	protected $payer;
	protected $buyer;
	protected $shipping;
	protected $ipAddress;
	protected $userAgent;
	protected $additionalData;
	
	public function __construct($info)
	{
		$this->bankCode = $info['bankCode'];
		$this->bankInterface = $info['bankInterface'];
		$this->returnURL = $info['returnURL'];
		$this->reference = $info['reference'];
		$this->description = $info['description'];
		$this->language = $info['language'];
		$this->currency = $info['currency'];
		$this->totalAmount = $info['totalAmount'];
		$this->taxAmount = $info['taxAmount'];
		$this->devolutionBase = $info['devolutionBase'];
		$this->tipAmount = $info['tipAmount'];
		$this->payer = $info['payer'];
		$this->buyer = $info['buyer'];
		$this->shipping = $info['shipping'];
		$this->ipAddress = $info['ipAddress'];
		$this->userAgent = $info['userAgent'];
		$this->additionalData = $info['additionalData'];
	}
	
	public function getBankCode()
	{
		return $this->bankCode;
	}
	
	public function getBankInterface()
	{
		return $this->bankInterface;
	}
	
	public function getReturnUrl()
	{
		return $this->returnURL;
	}
	
	public function getReference()
	{
		return $this->reference;
	}
		
	public function getDescription()
	{
		return $this->description;
	}
	
	public function getLanguage()
	{
		return $this->language;
	}
	
	public function getCurrency()
	{
		return $this->currency;
	}
	
	public function getTotalAmount()
	{
		return $this->totalAmount;
	}
		
	public function getTaxAmount()
	{
		return $this->taxAmount;
	}
	
	public function getDevolutionBase()
	{
		return $this->devolutionBase;
	}
	
	public function getTipAmount()
	{
		return $this->tipAmount;
	}
	
	public function getPayer()
	{
		return $this->payer;
	}
	
	public function getBuyer()
	{
		return $this->buyer;
	}
	
	public function getShipping()
	{
		return $this->shipping;
	}
	
	public function getIpAddress()
	{
		return $this->ipAddress;
	}
	
	public function getUserAgent()
	{
		return $this->userAgent;
	}
	
	public function getAdditionalData()
	{
		return $this->additionalData;
	}
}
