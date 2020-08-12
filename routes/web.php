<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::post('/iframe-pay','DonationController@iframePay')->name('iframe_pay');
Route::get('/payment-complete','DonationController@responsePage');
Route::get('/donor','DonationController@donorFormPage');
