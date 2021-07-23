<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AfterOrderMiddleware;
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

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    
    Route::get('/', 'ShopController@main')->name('shop.main');
    Route::get('/list/{category}/{id}', 'ShopController@single')->name('shop.single');
    Route::get('/list/sales/{category}/{id}', 'ShopController@single_sale')->name('shop.sales.single');
    Route::get('/list/{category}', 'ShopController@list')->name('shop.list');
    Route::get('/search', 'ShopController@search');

    //BASKET
    Route::get('/basket', 'BasketController@index')->name('basket');

    Route::get('/order-form', 'OrderController@index')->name('order.form');
    Route::post('/order', 'OrderController@store')->name('order.store');
    Route::get('/order-thanks', 'OrderController@thanks')->name('order.thanks');
});

Route::get('/admin', 'AdminController@login')->name('admin.login');
Route::post('/admin-check', 'AdminController@check');
Route::post('/callback-request', 'AdminController@mobile');
Route::middleware([AdminMiddleware::class])->group(function (){
    Route::post('/admin', 'AdminController@store')->name('admin.store');
    Route::get('/admin-main', 'AdminController@index')->name('admin.main');
    Route::get('/admin/orders', 'AdminController@orders')->name('admin.orders');
    Route::get('/admin/sales', 'AdminController@sales')->name('admin.sales');
    Route::get('/admin/orders/{id}', 'AdminController@order_details')->name('admin.order-details');
    Route::delete('/admin/sales/{id}/remove', 'AdminController@sale_remove')->name('admin.sale-remove');
    Route::get('/admin/sales/{id}', 'AdminController@sale_details')->name('admin.sale-details');
    Route::put('/admin/sales/{id}/edit', 'AdminController@sale_edit')->name('admin.sale.edit');
    Route::post('/admin/sales/store', 'AdminController@sale_store')->name('admin.sale.store');
    Route::get('/admin/sales/{product}/create', 'AdminController@sale_create')->name('admin.sale-create');
    Route::get('/admin/{id}', 'AdminController@edit')->name('admin.edit');
    Route::delete('/admin/{id}', 'AdminController@delete')->name('admin.delete');
    Route::patch('/admin', 'AdminController@save')->name('admin.save');
});

Route::post('/basket-api', 'BasketController@store')->name('basket.store');
Route::delete('/basket-api', 'BasketController@delete')->name('basket.delete');
