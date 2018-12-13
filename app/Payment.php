<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $table = 'payment';
	protected $fillable = 
							[
								'transactionID', 'bankCode', 'bankInterface', 
								'reference', 'description', 'totalAmount',
								'payer_id', 'buyer_id', 'ipAddress', 'userAgent'
							];
}