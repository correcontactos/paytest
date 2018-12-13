<?php

namespace App\Pse;

class Bank
{
	protected $bankCode;
	protected $bankName;
	
	public function __construct($info)
	{
		$this->bankCode = $info->bankCode;
		$this->bankName = $info->bankName;
	}
	
	public function getBankCode()
	{
		return $this->bankCode;
	}
	
	public function getBankName()
	{
		return $this->bankName;
	}
}
