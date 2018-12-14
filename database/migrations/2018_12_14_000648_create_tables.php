<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person', function (Blueprint $table) {
            $table->increments('id');
			$table->string('document', 12);
			$table->string('documentType', 3);
			$table->string('firstName', 60);
			$table->string('lastName', 60);
			$table->string('company', 60)->nullable();
			$table->string('emailAddress', 60)->nullable();
			$table->string('address', 100)->nullable();
			$table->string('city', 50)->nullable();
			$table->string('province', 50)->nullable();
			$table->string('country', 2)->nullable();
			$table->string('phone', 30)->nullable();
			$table->string('mobile', 30)->nullable();
            $table->timestamps();
        });

		Schema::create('payment', function (Blueprint $table) {
            $table->increments('id');
			$table->bigInteger('transaction_id');
			$table->string('bankCode', 4);
			$table->string('bankInterface', 1);
			$table->string('reference', 32);
			$table->string('description', 255);
			$table->double('totalAmount', 8,2);
			$table->unsignedInteger('payer_id');
			$table->unsignedInteger('buyer_id');
			$table->string('ipAddress', 15);
			$table->string('userAgent', 255);
			$table->timestamps();
			$table->foreign('payer_id')->references('id')->on('person');
			$table->foreign('buyer_id')->references('id')->on('person');
        });

		Schema::create('transaction', function (Blueprint $table) {
            $table->increments('id');
			$table->string('state', 10)->default('CREATED');
			$table->integer('transactionID');
			$table->string('sessionID', 32);
			$table->string('returnCode', 30);
			$table->string('trazabilityCode', 40);
			$table->smallinteger('transactionCycle');
			$table->string('bankCurrency', 3);
			$table->smallinteger('bankFactor');
			$table->string('bankURL', 255);
			$table->smallinteger('responseCode');
			$table->string('responseReasonCode', 3);
			$table->string('responseReasonText', 255);
			$table->timestamps();
        });		

		Schema::create('transaction_result', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('transaction_id');
			$table->integer('transactionID');
			$table->string('sessionID', 32);
			$table->string('reference', 32);
			$table->string('requestDate', 30);
			$table->string('bankProcessDate', 30);
			$table->string('onTest', 1);
			$table->string('returnCode', 30);
			$table->string('trazabilityCode', 40);
			$table->smallinteger('transactionCycle');
			$table->string('transactionState', 20);
			$table->smallinteger('responseCode');
			$table->string('responseReasonCode', 3);
			$table->string('responseReasonText', 255);
			$table->timestamps();
			$table->foreign('transaction_id')->references('id')->on('transaction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_result');
        Schema::dropIfExists('transaction');
        Schema::dropIfExists('payment');
        Schema::dropIfExists('person');
    }
}
