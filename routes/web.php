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

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/personal/{id}', 'ShopController@personal')->name('personal');
});

Route::get('/', 'ShopController@main')->name('shop.main');
Route::get('/home', function(){
    return redirect('/');
});

Route::get('/list', 'ShopController@list')->name('shop.list');

/* Route::get('/test', function(){
    return view('test');
}); */

Route::get('/list/{id}', 'ShopController@single')->name('shop.single');

Route::get('/admin', 'AdminController@index')->name('admin');
Route::post('/admin', 'AdminController@store')->name('admin.store');
Route::get('/admin/{id}', 'AdminController@delete')->name('admin.delete');

//BASKET
Route::get('/basket', 'BasketController@index')->name('basket');
Route::post('/basket', 'BasketController@store')->name('basket.store');
Route::delete('/basket', 'BasketController@delete')->name('basket.delete');

Route::view('/about', 'about')->name('about');