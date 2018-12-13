<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $table = 'transaction';
	protected $fillable = 
							[
								'transactionID', 'sessionID', 'returnCode', 
								'trazabilityCode', 'transactionCycle', 'bankCurrency',
								'bankFactor', 'bankURL', 'responseCode',
								'responseReasonCode', 'responseReasonText'
							];
}
