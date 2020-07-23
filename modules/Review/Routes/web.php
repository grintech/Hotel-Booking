<?php
use Illuminate\Support\Facades\Route;

//Review
Route::group(['middleware' => ['auth']],function(){
    Route::get('/review','ReviewController@index');
    Route::post('/review','ReviewController@addReview')->name('review.store');
});
