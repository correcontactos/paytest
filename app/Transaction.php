<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	//table
	protected $table = 'transaction';
	//fields to use
	protected $fillable = ['transactionID', 'sessionID', 'returnCode',
							'trazabilityCode', 'transactionCycle', 'bankCurrency',
							'bankFactor', 'bankURL', 'responseCode',
							'responseReasonCode', 'responseReasonText'];
}
