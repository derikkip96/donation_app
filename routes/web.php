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


Route::post('/login_user','Auth\LoginController@authenticate');
Route::post('/iframe-pay','DonationController@iframePay')->name('iframe_pay');
Route::get('/payment-complete','DonationController@responsePage');
Route::get('/landing','DonationController@donorFormPage');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// PESAPAL_KEY=k/m9rU23VXzbVFK7AVBS8bPkpbTFnP/k 
// PESAPAL_SECRET=jzPZFJW8eZGkWhA5rBfVvboVVEA= 

