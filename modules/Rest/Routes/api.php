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
    Route::get('{service}/featured', ['uses' => 'FeaturedController@index', 'as' => 'featured']);
    Route::get('{service}/related/{location_id}', ['uses' => 'FeaturedController@related', 'as' => 'related']);
    Route::get('{type}/search', ['uses' => 'SearchController@search', 'as' => 'search']);
    Route::get('{type}/filters', ['uses' => 'SearchController@getFilters', 'as' => 'filters']);
});
