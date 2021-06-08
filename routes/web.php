<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::group(['prefix' => LaravelLocalization::setLocale()], function(){

    Route::get('/', 'ShopController@main')->name('shop.main');

    Route::get('/list/{category}/{id}', 'ShopController@single')->name('shop.single');
    Route::get('/list/{category}', 'ShopController@list')->name('shop.list');
    
    //BASKET
    Route::get('/basket', 'BasketController@index')->name('basket');

    //Route::view('/about', 'about')->name('about');
    Route::post('/order-form', 'OrderController@form')->name('order.form');
    Route::post('/order-check', 'OrderController@check')->name('order.check');

    Route::get('/home', function(){ return redirect('/'); });
    
    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::post('/admin', 'AdminController@store')->name('admin.store');
    Route::get('/admin/{id}', 'AdminController@delete')->name('admin.delete');

});    

Route::post('/basket', 'BasketController@store')->name('basket.store');
Route::delete('/basket', 'BasketController@delete')->name('basket.delete');

Route::get('/home', function(){ return redirect('/'); });
