<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Category;
use App\Services\BasketService;

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
        View::composer(['shop.list', 'admin.index', 'admin.edit', 'layouts.partials.header', 'shop.sales.list'], function($view){
            $view->with('categories', Category::all());
        });
        View::composer('layouts.partials.header', function($view) {
            $view->with('basket_prod_count', BasketService::productCount());
        });
    }
}
