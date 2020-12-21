<?php
use Illuminate\Support\Facades\Route;
Route::get('confirmGPGCheckout','GPGCheckoutController@handleCheckout')->middleware('auth');
