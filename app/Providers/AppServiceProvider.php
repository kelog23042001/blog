<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\ServiceProvider;

use App\Models\Statistic;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Visitors;
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
            $min_price = Product::min('product_price');
            $max_price = Product::max('product_price');
            $min_price_range = $min_price - $min_price;
            $max_price_range = $max_price + 100000;

            $product_count = Product::all()->count();
            $post_count = Post::all()->count();
            $order_count = Order::all()->count();
            $customer_count = Customer::all()->count();

            $view->with('customer_count', $customer_count)
                ->with('order_count', $order_count)
                ->with('post_count', $post_count)
                ->with('product_count', $product_count)
                ->with('min_price',$min_price)
                ->with('max_price',$max_price)
                ->with('min_price_range',$min_price_range)
                ->with('max_price_range',$max_price_range);
        });
    }
}
