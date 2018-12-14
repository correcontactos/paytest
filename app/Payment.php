<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	//table
	protected $table = 'payment';
	//fields to use
	protected $fillable = ['transactionID', 'bankCode', 'bankInterface',
							'reference', 'description', 'totalAmount',
							'payer_id', 'buyer_id', 'ipAddress', 'userAgent'];
}