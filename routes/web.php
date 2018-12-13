<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
    // return view('welcome');
// });

Route::get('/', function () {
    return view('index');
});

Route::post('/savePersons', 'PaymentController@savePersons');
Route::get('/step1/{payer}/{buyer}', 'PaymentController@step1');
Route::post('/step2', 'PaymentController@step2');
Route::get('/step3/{reference}', 'PaymentController@step3');
Route::get('/pendingTransactions', 'PaymentController@pendingTransactions');
