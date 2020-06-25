<?php
use \Illuminate\Support\Facades\Route;
Route::get('/','GuesthouseController@index')->name('guesthouse.admin.index');
Route::get('/create','GuesthouseController@create')->name('guesthouse.admin.create');
Route::get('/edit/{id}','GuesthouseController@edit')->name('guesthouse.admin.edit');
Route::post('/store/{id}','GuesthouseController@store')->name('guesthouse.admin.store');
Route::post('/bulkEdit','GuesthouseController@bulkEdit')->name('guesthouse.admin.bulkEdit');

Route::group(['prefix'=>'attribute'],function (){
    Route::get('/','AttributeController@index')->name('guesthouse.admin.attribute.index');
    Route::get('edit/{id}','AttributeController@edit')->name('guesthouse.admin.attribute.edit');
    Route::post('store/{id}','AttributeController@store')->name('guesthouse.admin.attribute.store');

    Route::get('terms/{id}','AttributeController@terms')->name('guesthouse.admin.attribute.term.index');
    Route::get('term_edit/{id}','AttributeController@term_edit')->name('guesthouse.admin.attribute.term.edit');
    Route::get('term_store','AttributeController@term_store')->name('guesthouse.admin.attribute.term.store');

    Route::get('getForSelect2','AttributeController@getForSelect2')->name('guesthouse.admin.attribute.term.getForSelect2');
    Route::get('getAttributeForSelect2','AttributeController@getAttributeForSelect2')->name('guesthouse.admin.attribute.getForSelect2');
});
Route::group(['prefix'=>'room'],function (){

    Route::group(['prefix'=>'attribute'],function (){
        Route::get('/','RoomAttributeController@index')->name('guesthouse.admin.room.attribute.index');
        Route::get('edit/{id}','RoomAttributeController@edit')->name('guesthouse.admin.room.attribute.edit');
        Route::post('store/{id}','RoomAttributeController@store')->name('guesthouse.admin.room.attribute.store');
        Route::post('editAttrBulk','RoomAttributeController@editAttrBulk')->name('guesthouse.admin.room.attribute.editAttrBulk');

        Route::get('terms/{id}','RoomAttributeController@terms')->name('guesthouse.admin.room.attribute.term.index');
        Route::get('term_edit/{id}','RoomAttributeController@term_edit')->name('guesthouse.admin.room.attribute.term.edit');
        Route::get('term_store','RoomAttributeController@term_store')->name('guesthouse.admin.room.attribute.term.store');

        Route::get('getForSelect2','RoomAttributeController@getForSelect2')->name('guesthouse.admin.room.attribute.term.getForSelect2');
    });

    Route::get('{guesthouse_id}/index','RoomController@index')->name('guesthouse.admin.room.index');
    Route::get('{guesthouse_id}/create','RoomController@create')->name('guesthouse.admin.room.create');
    Route::get('{guesthouse_id}/edit/{id}','RoomController@edit')->name('guesthouse.admin.room.edit');
    Route::post('{guesthouse_id}/store/{id}','RoomController@store')->name('guesthouse.admin.room.store');


    Route::post('/bulkEdit','RoomController@bulkEdit')->name('guesthouse.admin.room.bulkEdit');

});

Route::group(['prefix'=>'{guesthouse_id}/availability'],function(){
    Route::get('/','AvailabilityController@index')->name('guesthouse.admin.room.availability.index');
    Route::get('/loadDates','AvailabilityController@loadDates')->name('guesthouse.admin.room.availability.loadDates');
    Route::match(['get','post'],'/store','AvailabilityController@store')->name('guesthouse.admin.room.availability.store');
});

