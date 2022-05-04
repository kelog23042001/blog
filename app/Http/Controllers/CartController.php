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

        $data['id'] = $product_info->product_id;
        $data['name'] = $product_info->product_name;
        $data['qty'] = $quantity;
        $data['price'] = $product_info->product_price;
        $data['weight'] = 0;
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);

        // Cart::destroy();
        return Redirect::to('/show_cart');
    }

    public function show_cart(){
        $category = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();
        return view('user.pages.cart.show_cart', compact('category', 'brand'));
    }

    public function detele_to_cart($rowId){
        Cart::update($rowId, 0);
        return Redirect::to('/show_cart');
    }

    public function update_cart_qty(Request $request){
        $rowId = $request->rowId_cart;
        $quantity = $request->quantity_cart;

        Car::update($rowId, $quantity);
        return Redirect::to('/show_cart');
    }
}
