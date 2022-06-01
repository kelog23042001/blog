<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use App\Models\Coupon;
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
    public function hover_cart(){
        $cart = count(Session::get('cart'));
        $output = '';
        if($cart > 0){



            $output.='
            <ul class="hover-cart">';
            foreach(Session::get('cart') as $key => $val){
                $output.=' <li href = ".."><a>
                    <img  src="'.asset('public/uploads/product/'.$val['product_image']).'">
                 
                    <p>'.number_format($val['product_price'],0,',','.').'</p>
                    <p>Số lượng: '.$val['product_qty'].'</p>
                </a>
                <p>
                    <a style = "    background: bisque;text-align: center; font-size: 20px;" class = "delete-hover-cart" href = "'.url('del-product/'.$val['session_id']).'">
                    <i class= "fa fa-times"></i>
                    </a>
                </p></li>';
            }
            $output.='  </ul>';
        }
        // elseif($cart == ''){
        //     $output.='
        //     <ul class="hover-cart">
        //     <li><p>Giỏ hàng trống</p></li>

        // </ul>';
        // }

        echo $output;
    }
    public function show_cart_qty(){
        $cart = count(Session::get('cart'));
        $output = '';
        $output.= '     <span class="badges">'.$cart.'  </span>';
        echo $output;
    }
    public function delete_product($session_id){
        $cart = Session::get('cart');
        if($cart == true){
            foreach($cart as $key => $value){
                if($value['session_id'] == $session_id)
                    unset($cart[$key]);
            }
            Session::put('cart', $cart);
            return Redirect()->back()->with('message','Xoá sản phẩm thành công');
        }else{
            return Redirect()->back()->with('message','Xoá sản phẩm thất bại');
        }
    }

    public function update_cart(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if ($cart == true){
            foreach($data['cart_qty'] as $key => $qty){
                foreach($cart as $session => $val){
                    if($val['session_id']  == $key){
                        $cart[$session]['product_qty']= $qty;
                    }
                }
            }
            Session::put('cart', $cart);
            return Redirect()->back()->with('message','Cập nhập số lượng thành công');
        }
        else{
            return Redirect()->back()->with('message','Cập nhập số lượng thất bại');
        }
    }

    public function delete_all_product(){
        $cart = Session::get('cart');
        if($cart == true){
            Session::forget('cart');
            Session::forget('coupon');
            return Redirect()->back()->with('message','Xoá tất cả sản phẩm thành công');

        }
    }
    public function show_cart(Request $request){
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->paginate(5);

        $meta_decs = "Giỏ hàng";
        $meta_title = "Giỏ hàng";
        $meta_keyword = "Giỏ hàng";
        $url_canonical = $request->url();
        $category = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();
        return view('user.pages.cart.show_cart', compact('category', 'brand', 'category_post'))
        ->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical);
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

    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                }
            }
            if($is_avaiable == 0){
                $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],

            );
            Session::put('cart',$cart);
        }

        Session::save();

    }

    public function gio_hang(Request $request){
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->paginate(5);

        $meta_decs = "Giỏ hàng";
        $meta_title = "Giỏ hàng Ajax";
        $meta_keyword = "Giỏ hàng Ajax";
        $url_canonical = $request->url();
        $category = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();
        return view('user.pages.cart.cart_ajax', compact('category', 'brand', 'category_post' ))
        ->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical);
    }


    //Coupon


}
