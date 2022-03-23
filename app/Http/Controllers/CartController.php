<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Cart;
class CartController extends Controller
{
    public function save_cart(Request $request){


        $productId = $request->productid_hidden;
        $quantity = $request->qty;

        $product_info = DB::table('tbl_product')->where('product_id', $productId)->first();

        Cart::add('293ad', 'Product 1', 1, 1, 550);

        Cart::add($data);
        return Redirect::to('/show_cart');
    }

    public function show_cart(){
        $category = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();
        return view('user.pages.cart.show_cart', compact('category', 'brand'));
    }
}
