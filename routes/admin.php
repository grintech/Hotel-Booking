<?php
// Admin Route
Route::group(['prefix'=>'admin','middleware' => ['auth','dashboard']], function() {
    Route::match(['get','post'],'/', 'AdminController@datatype');
    Route::match(['get','post'],'/module/{module}/{controller?}/{action?}/{param1?}/{param2?}/{param3?}', 'AdminController@parametric');
});