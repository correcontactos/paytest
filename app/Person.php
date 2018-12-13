<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //
	protected $table = 'person';
	protected $fillable = 
							[
								'document','documentType','firstName','lastName','company'
								,'emailAddress', 'address', 'city', 'province', 'country'
								,'phone', 'mobile'
							];
}
