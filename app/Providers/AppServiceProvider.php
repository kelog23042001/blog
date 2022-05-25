<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\ServiceProvider;

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
        view()->composer('*',function($view){
            $min_price = Product :: min('product_price');
            $max_price = Product :: max('product_price');
            $min_price_range = $min_price - 100000;
            $max_price_range = $max_price + 100000;
            $view->with('min_price',$min_price)->with('max_price',$max_price)->with('min_price_range',$min_price_range)
                ->with('max_price_range',$max_price_range);
        });
    }
}
