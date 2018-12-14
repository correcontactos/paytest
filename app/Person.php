<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    
	//table
	protected $table = 'person';
	//fields to use
	protected $fillable = ['document','documentType','firstName','lastName','company'
							,'emailAddress', 'address', 'city', 'province', 'country'
							,'phone', 'mobile'];
}
