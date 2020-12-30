<?php
use Illuminate\Support\Facades\Route;
Route::get('confirmGPGCheckout','GPGCheckoutController@handleCheckout')->middleware('auth');
Route::post('gpgcheckout/gateway_callback/process','GPGCheckoutController@handleCallback');
