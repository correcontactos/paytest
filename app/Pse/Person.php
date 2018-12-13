<?php

namespace App\Pse;

class Person
{
	
	protected $document;
	protected $documentType;
	protected $firstName;
	protected $lastName;
	protected $company;
	protected $emailAddress;
	protected $address;
	protected $city;
	protected $province;
	protected $country;
	protected $phone;
	protected $mobile;
	
	public function __construct($info)
	{
		$this->document = $info['document'];
		$this->documentType = $info['documentType'];
		$this->firstName = $info['firstName'];
		$this->lastName = $info['lastName'];
		$this->company = $info['company'];
		$this->emailAddress = $info['emailAddress'];
		$this->address = $info['address'];
		$this->city = $info['city'];
		$this->province = $info['province'];
		$this->country = $info['country'];
		$this->phone = $info['phone'];
		$this->mobile = $info['mobile'];
	}
	
	public function getDocument()
	{
		return $this->document;
	}
	
	public function getDocumentType()
	{
		return $this->documentType;
	}
	
	public function getFirstName()
	{
		return $this->firstName;
	}
	
	public function getLastName()
	{
		return $this->lastName;
	}
	
	public function getCompany()
	{
		return $this->company;
	}
	
	public function getEmailAddress()
	{
		return $this->emailAddress;
	}
	
	public function getAddress()
	{
		return $this->address;
	}
	
	public function getCity()
	{
		return $this->city;
	}
	
	public function getProvince()
	{
		return $this->province;
	}
	
	public function getCountry()
	{
		return $this->country;
	}
	
	public function getPhone()
	{
		return $this->phone;
	}
	
	public function getMobile()
	{
		return $this->mobile;
	}
}
