<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\PaymentController;

class PendingTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pse:transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check pending transactions and update records with response';
	
	/**
     * Controller to use.
     *
     * @var PaymentController
     */
    protected $paymentController;
	
	/**
     * Transactions to check.
     *
     * @var Transactions
     */
    protected $transactions;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$this->paymentController = new PaymentController();
		$this->transactions = $this->paymentController->pendingTransactions();
    }
}
