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
use Illuminate\Support\Facades\Route;
// Vendor Manage Hike
Route::group(['prefix'=>'user/'.config('hike.hike_route_prefix'),'middleware' => ['auth','verified']],function(){
    Route::match(['get',],'/','ManageHikeController@manageHike')->name('hike.vendor.index');
    Route::match(['get',],'/create','ManageHikeController@createHike')->name('hike.vendor.create');
    Route::match(['get',],'/edit/{slug}','ManageHikeController@editHike')->name('hike.vendor.edit');
    Route::match(['get','post'],'/del/{slug}','ManageHikeController@deleteHike')->name('hike.vendor.delete');
    Route::match(['post'],'/store/{slug}','ManageHikeController@store')->name('hike.vendor.store');
    Route::get('bulkEdit/{id}','ManageHikeController@bulkEditHike')->name("hike.vendor.bulk_edit");
    Route::get('clone/{id}','ManageHikeController@cloneHike')->name("hike.vendor.clone");
    Route::get('/booking-report','ManageHikeController@bookingReport')->name("hike.vendor.booking_report");
    Route::get('/booking-report/bulkEdit/{id}','ManageHikeController@bookingReportBulkEdit')->name("hike.vendor.booking_report.bulk_edit");
});
Route::group(['prefix'=>'user/'.config('hike.hike_route_prefix')],function(){
    Route::group(['prefix'=>'availability'],function(){
        Route::get('/','AvailabilityController@index')->name('hike.vendor.availability.index');
        Route::get('/loadDates','AvailabilityController@loadDates')->name('hike.vendor.availability.loadDates');
        Route::match(['get','post'],'/store','AvailabilityController@store')->name('hike.vendor.availability.store');
    });
});
// Hike
Route::group(['prefix' => config('hike.hike_route_prefix')],function(){
    Route::get('/','\Modules\Hike\Controllers\HikeController@index')->name('hike.search'); // Search
    Route::get('/{slug}','\Modules\Hike\Controllers\HikeController@detail')->name('hike.detail');// Detail
});
