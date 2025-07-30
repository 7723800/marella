<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home-women');
})->name('home');

Route::get('/home-women', 'HomeController@index')->name('home-women');

Route::group(['prefix' => 'catalog'], function () {
    Route::get('/', 'CategoryController@index')->name('category');
    Route::get('/sets/{slug}', 'SetsController@index')->name('sets');
    Route::get('/office', 'OfficeController@index')->name('office');
    // Route::get('/perfume', 'PerfumeController@index')->name('perfume');
    // Route::get('/perfume/{id}', 'PerfumeController@item');
    Route::get('/giftcard', 'GiftcardController@index')->name('giftcard');
    Route::get('/giftcard/{id}', 'GiftcardController@item');
    Route::get('{categorySlug}/{subcategorySlug}/{itemID}', 'ItemController@index');
    Route::get('kaspi', 'KaspiStore@create');
    Route::get('women/facebook', 'FacebookStore@women');
    // Route::get('men/facebook', 'FacebookStore@men');
    Route::get('women/doublegis', 'DoubleGisController@women');
});

Route::group(['prefix' => 'my'], function () {
    Auth::routes(['verify' => true]);
    Route::get('/index', 'UserController@index')->name('index');
});

Route::get('about', function () {
    return view('about');
})->name('about');

Route::get('address', function () {
    return view('address');
})->name('address');

Route::get('blog', 'BlogController@index')->name('blog');

Route::get('checkout', 'CartController@index')->name('cart');
Route::get('checkout/confirm', 'CartController@confirm')->name('confirm');
Route::get('search', 'SearchController@index')->name('search');

Route::group(['prefix' => 'info'], function () {
    Route::get('/delivery', function () {
        return view('info.delivery');
    })->name('info-delivery');
    Route::get('/return', function () {
        return view('info.return');
    })->name('info-return');
    Route::get('/oferta', function () {
        return view('info.oferta');
    })->name('info-oferta');
    Route::get('/payment', function () {
        return view('info.payment');
    })->name('payment');
    Route::get('/payment-guide', function () {
        return view('info.guide');
    })->name('payment-guide');
    Route::get('/kaspi-red', function () {
        return view('info.kaspi-red');
    })->name('kaspi-red');
    Route::get('/extra-sale', function () {
        return view('info.extra-sale');
    })->name('extra-sale');
});
