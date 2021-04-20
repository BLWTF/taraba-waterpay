<?php
use App\Http\Controllers\LanguageController;
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
// dashboard Routes
Route::get('/','PaymentController@index')->name('payment.index');

Route::get('/customer/check','CustomerController@customerCheck')->name('customer.check');

Route::post('/payment/prepare','PaymentController@preparePayment')->name('payment.prepare');

Route::get('/payment/webpay/redirect','PaymentController@webpayRedirect')->name('payment.webpay.redirect');

Route::post('/payment/webpay/redirect','PaymentController@webpayRedirect')->name('payment.webpay.redirect');

Route::get('/dashboard','StarterKitController@index')->name('dashboard');
Route::get('/sk-layout-1-column','StarterKitController@column_1Sk')->name('1-column');
Route::get('/sk-layout-2-columns','StarterKitController@columns_2Sk')->name('2-columns');
Route::get('/fixed-navbar','StarterKitController@fix_navbar')->name('fixed-navbar');
Route::get('/sk-layout-fixed','StarterKitController@fix_layout')->name('fixed-layout');
Route::get('/sk-layout-static','StarterKitController@static_layout')->name('static-layout');

// locale Route
Route::get('lang/{locale}',[LanguageController::class,'swap'])->name('language');

Auth::routes(['verify' => true]);
