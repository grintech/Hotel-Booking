<?php
use Illuminate\Support\Facades\Route;

Route::get('/','HikeController@index')->name('hike.admin.index');

Route::match(['get'],'/create','HikeController@create')->name('hike.admin.create');
Route::match(['get'],'/edit/{id}','HikeController@edit')->name('hike.admin.edit');

Route::post('/store/{id}','HikeController@store')->name('hike.admin.store');

Route::get('/getForSelect2','HikeController@getForSelect2')->name('hike.admin.getForSelect2');
Route::post('/bulkEdit','HikeController@bulkEdit')->name('hike.admin.bulkEdit');

Route::match(['get'],'/category','CategoryController@index')->name('hike.admin.category.index');
Route::match(['get'],'/category/edit/{id}','CategoryController@edit')->name('hike.admin.category.edit');
Route::post('/category/store/{id}','CategoryController@store')->name('hike.admin.category.store');

Route::match(['get'],'/attribute','AttributeController@index')->name('hike.admin.attribute.index');
Route::match(['get'],'/attribute/edit/{id}','AttributeController@edit')->name('hike.admin.attribute.edit');
Route::post('/attribute/store/{id}','AttributeController@store')->name('hike.admin.attribute.store');

Route::match(['get'],'/attribute/term_edit','AttributeController@terms')->name('hike.admin.attribute.term.index');
Route::match(['get'],'/attribute/term_edit/edit/{id}','AttributeController@term_edit')->name('hike.admin.attribute.term.edit');
Route::post('/attribute/term_store/{id}','AttributeController@term_store')->name('hike.admin.attribute.term.store');


Route::group(['prefix'=>'availability'],function(){
    Route::get('/','AvailabilityController@index')->name('hike.admin.availability.index');
    Route::get('/loadDates','AvailabilityController@loadDates')->name('hike.admin.availability.loadDates');
    Route::get('/store','AvailabilityController@store')->name('hike.admin.availability.store');
});
