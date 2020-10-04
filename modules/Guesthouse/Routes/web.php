<?php
use \Illuminate\Support\Facades\Route;

Route::group(['prefix'=>config('guesthouse.guesthouse_route_prefix')],function(){
    Route::get('/','GuesthouseController@index')->name('guesthouse.search'); // Search
    Route::get('/{slug}','GuesthouseController@detail')->name('guesthouse.detail');// Detail
});

Route::group(['prefix'=>'user/'.config('guesthouse.guesthouse_route_prefix'),'middleware' => ['auth','verified']],function(){
    Route::match(['get','post'],'/','VendorController@index')->name('guesthouse.vendor.index');
    Route::match(['get','post'],'/create','VendorController@create')->name('guesthouse.vendor.create');
    Route::match(['get','post'],'/edit/{slug}','VendorController@edit')->name('guesthouse.vendor.edit');
    Route::match(['get','post'],'/del/{slug}','VendorController@delete')->name('guesthouse.vendor.delete');
    Route::match(['post'],'/store/{slug}','VendorController@store')->name('guesthouse.vendor.store');
    Route::get('bulkEdit/{id}','VendorController@bulkEditguesthouse')->name("guesthouse.vendor.bulk_edit");
    Route::get('/booking-report','VendorController@bookingReport')->name("guesthouse.vendor.booking_report");
    Route::get('/booking-report/bulkEdit/{id}','VendorController@bookingReportBulkEdit')->name("guesthouse.vendor.booking_report.bulk_edit");
    Route::group(['prefix'=>'availability'],function(){
        Route::get('/','AvailabilityController@index')->name('guesthouse.vendor.availability.index');
        Route::get('/loadDates','AvailabilityController@loadDates')->name('guesthouse.vendor.availability.loadDates');
        Route::match(['get','post'],'/store','AvailabilityController@store')->name('guesthouse.vendor.availability.store');
    });
    Route::group(['prefix'=>'room'],function (){
        Route::get('{guesthouse_id}/index','VendorRoomController@index')->name('guesthouse.vendor.room.index');
        Route::get('{guesthouse_id}/create','VendorRoomController@create')->name('guesthouse.vendor.room.create');
        Route::get('{guesthouse_id}/edit/{id}','VendorRoomController@edit')->name('guesthouse.vendor.room.edit');
        Route::post('{guesthouse_id}/store/{id}','VendorRoomController@store')->name('guesthouse.vendor.room.store');
        Route::get('{guesthouse_id}/del/{id}','VendorRoomController@delete')->name('guesthouse.vendor.room.delete');
        Route::get('{guesthouse_id}/bulkEdit/{id}','VendorRoomController@bulkEdit')->name('guesthouse.vendor.room.bulk_edit');
    });
});

Route::group(['prefix'=>'user/'.config('guesthouse.guesthouse_route_prefix')],function(){
    Route::group(['prefix'=>'{guesthouse_id}/availability'],function(){
        Route::get('/','AvailabilityController@index')->name('guesthouse.vendor.room.availability.index');
        Route::get('/loadDates','AvailabilityController@loadDates')->name('guesthouse.vendor.room.availability.loadDates');
        Route::match(['get','post'],'/store','AvailabilityController@store')->name('guesthouse.vendor.room.availability.store');
    });
});

Route::post(config('guesthouse.guesthouse_route_prefix').'/checkAvailability','GuesthouseController@checkAvailability')->name('guesthouse.checkAvailability');
