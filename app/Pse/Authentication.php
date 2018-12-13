<?php

namespace App\Pse;

class Authentication
{
	protected $login;
	protected $tranKey;
	protected $seed;
	protected $additional;
	
	public function __construct($additional)
	{
		$this->login = config('app.login');
		$this->tranKey = config('app.tranKey');
		$this->seed = date('c');
		$this->tranKey = sha1($this->seed.$this->tranKey,false);
		$this->additional = $additional;
	}
	
	public function getLogin()
	{
		return $this->login;
	}	
	
	public function getTranKey()
	{
		return $this->tranKey;
	}	
	
	public function getSeed()
	{
		return $this->seed;
	}	
	
	public function getAdditional()
	{
		return $this->additional;
	}
}
