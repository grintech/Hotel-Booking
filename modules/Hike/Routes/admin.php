<?php
use Illuminate\Support\Facades\Route;

Route::get('/','HikeController@index')->name('hike.admin.index');

Route::get('/create','HikeController@create')->name('hike.admin.create');
Route::get('/edit/{id}','HikeController@edit')->name('hike.admin.edit');

Route::post('/store/{id}','HikeController@store')->name('hike.admin.store');

Route::get('/getForSelect2','HikeController@getForSelect2')->name('hike.admin.getForSelect2');
Route::post('/bulkEdit','HikeController@bulkEdit')->name('hike.admin.bulkEdit');

Route::get('/category','CategoryController@index')->name('hike.admin.category.index');
Route::get('/category/edit/{id}','CategoryController@edit')->name('hike.admin.category.edit');
Route::post('/category/store/{id}','CategoryController@store')->name('hike.admin.category.store');

Route::group(['prefix'=>'attribute'],function(){
    Route::get('/','AttributeController@index')->name('hike.admin.attribute.index');
    Route::get('/edit/{id}','AttributeController@edit')->name('hike.admin.attribute.edit');
    Route::post('/store/{id}','AttributeController@store')->name('hike.admin.attribute.store');
    Route::post('/editAttrBulk','AttributeController@editAttrBulk')->name('hike.admin.attribute.editAttrBulk');

    Route::get('/terms/{attr_id}','AttributeController@terms')->name('hike.admin.attribute.term.index');
    Route::get('/term_edit/{id}','AttributeController@term_edit')->name('hike.admin.attribute.term.edit');
    Route::post('/term_store/{id}','AttributeController@term_store')->name('hike.admin.attribute.term.store');
    Route::post('/editTermBulk','AttributeController@editTermBulk')->name('hike.admin.attribute.term.editTermBulk');
});
//TODO cross check in old module, is this route segment is disabled?
//Route::group(['prefix'=>'availability'],function(){
//    Route::get('/','AvailabilityController@index')->name('hike.admin.availability.index');
//    Route::get('/loadDates','AvailabilityController@loadDates')->name('hike.admin.availability.loadDates');
//    Route::get('/store','AvailabilityController@store')->name('hike.admin.availability.store');
//});
