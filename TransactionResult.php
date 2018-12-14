<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionResult extends Model
{
	//table
	protected $table = 'transaction_result';
	//fields to use
	protected $fillable = ['transaction_id', 'transactionID', 'sessionID',
							'reference', 'requestDate', 'bankProcessDate',
							'onTest', 'returnCode', 'trazabilityCode', 
							'transactionCycle', 'transactionState',
							'responseCode', 'responseReasonCode', 
							'responseReasonText'];
}
