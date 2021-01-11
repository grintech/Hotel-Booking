<?php

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([], function(){

    Route::group(['prefix' => 'location', 'as' => 'location.'], function(){
        Route::get('list', ['uses' => 'LocationController@list', 'as' => 'list']);
        Route::get('locations',['uses' => 'LocationController@search', 'as' => 'search']);
        Route::get('detail/{id}', ['uses' => 'LocationController@detail', 'as' => 'detail']);
    });

    Route::get('gpx/{file}', ['uses' => 'LocationController@gpx', 'as' => 'gpx']);

    Route::group(['prefix' => '{service}'] , function(){

        Route::get('category', ['uses' => 'ContentController@category', 'as' => 'category']);
        Route::get('featured', ['uses' => 'ContentController@featured', 'as' => 'featured']);
        Route::get('related/{location_id}', ['uses' => 'ContentController@related', 'as' => 'related']);
        Route::get('detail/{id}', ['uses' => 'ContentController@detail', 'as' => 'detail']);
        Route::get('search', ['uses' => 'SearchController@search', 'as' => 'search']);
        Route::get('filters', ['uses' => 'SearchController@getFilters', 'as' => 'filters']);
    });
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::post('me', 'AuthController@updateUser');
    Route::post('change-password', 'AuthController@changePassword');
});
