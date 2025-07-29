<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::group(['prefix' => 'catalog',  'middleware' => 'cors'], function () {
    Route::get('/', 'CategoryController@getDataAPI');
    Route::get('/sets/{slug}', 'SetsController@getDataAPI');
    Route::get('/office', 'OfficeController@getDataAPI');
});

Route::group(['prefix' => 'user',  'middleware' => 'cors'], function () {
    Route::post('/index', 'API\UserController@index');
    Route::post('/update', 'API\UserController@update');
    Route::post('/password', 'API\UserController@password');
});

Route::get('/search', 'SearchController@getItems');
Route::get('/search-keywords', 'SearchController@getKeywords');
Route::post('/email-subscription', 'API\EmailSubscriptionController@store');
Route::post('/login', 'API\UserController@login');
Route::post('/order', 'API\OrderController@store');
Route::post('/promocode', 'PromocodeController@check');
Route::post('/return', 'API\ReturnedProductController@store');

// api v2
Route::group(['prefix' => 'v2', 'middleware' => 'cors', 'namespace' => 'API\V2'], function () {
    Route::group(['prefix' => 'catalog'], function () {
        Route::get('/product/{id}', 'CategoryController@product');
        Route::get('/{category}/sale', 'CategoryController@saleItems');
        Route::get('/{category}/new', 'CategoryController@newItems');
        Route::get('/{category}/popular', 'CategoryController@popularItems');
        Route::get('/{category}/{slug?}', 'CategoryController@items');
    });
    Route::get('/wishlist', 'ItemController@wishlist');
    Route::get('/basket', 'ItemController@basket');
});
