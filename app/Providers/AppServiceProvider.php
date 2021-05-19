<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['shop.list', 'admin.index', 'layouts.partials.header'], function($view){
            $view->with('categories', Category::all());
        });
        // json_encode(array_map(function (size) { return size->size }, $product->sizes));
    }
}
