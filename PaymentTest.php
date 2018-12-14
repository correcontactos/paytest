<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Pse\Authentication as PseAuthentication;
use App\Pse\Attribute as PseAttribute;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Cache;

class PaymentTest extends TestCase
{
    /**
     * Test to payment.
     *
     * @return void
     */
    public function testPayment1()
    {
		$additional1 = new PseAttribute('date', date('Y-m-d'));
		$additional2 = new PseAttribute('time', date('H:i:s'));
		$additional = ['item'=>[$additional1, $additional2]];
		$auth = new PseAuthentication($additional);
		$tranKey = sha1(date('c').'024h1IlD',false);
		$this->assertEquals($tranKey, $auth->getTranKey());
    }
	
	public function testPayment2()
	{
		$payment = new PaymentController();
		$this->assertTrue(is_array($payment->getBanks()));
	}
	
	public function testPayment3()
	{
		$this->assertEmpty(Cache::has('banks'));
	}
}
