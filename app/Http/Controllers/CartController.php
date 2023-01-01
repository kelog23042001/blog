<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Cart;

class CartController extends Controller
{

    public function hover_cart()
    {
        $cart = count(Session::get('cart'));
        $output = '';
        if ($cart > 0) {

            $output .= '
            <ul class="hover-cart">';
            foreach (Session::get('cart') as $key => $val) {
                $output .= ' 
                <a>

                <li  class="zoom-box">
                        <img  src="' . asset('public/uploads/product/' . $val['product_image']) . '">
                        <div class="text">
                            <p class="cart_item_name">' . $val['product_name'] . '</p>
                            <p style="width:150px">' . number_format($val['product_price'], 0, ',', '.') . ' VND</p>
                            <p>Số lượng: ' . $val['product_qty'] . '</p>
                        </div>
                        
                        <p class="icon_del">
                            <a style = "background: none; float:right; text-align: center; margin:0 0 0 5px;font-size: 25px;" class = "delete-hover-cart" href = "' . url('del-product/' . $val['session_id']) . '">
                            <i class="fa fa-times"></i>
                            </a>
                        </p>
                </li>
                    </a>';
            }
            $output .= '  </ul>';
        }
        // elseif($cart == ''){
        //     $output.='
        //     <ul class="hover-cart">
        //     <li><p>Giỏ hàng trống</p></li>

        // </ul>';
        // }

        echo $output;
    }
    public function show_cart_qty()
    {
        $cart = count(Session::get('cart'));
        $output = '';
        $output .= '     <span class="badges">' . $cart . '  </span>';
        echo $output;
    }

    public function delete_product($session_id)
    {
        $cart = Session::get('cart');
        if ($cart == true) {
            foreach ($cart as $key => $value) {
                if ($value['session_id'] == $session_id)
                    unset($cart[$key]);
            }
            Session::put('cart', $cart);
            return Redirect()->back()->with('message', 'Xoá sản phẩm thành công');
        } else {
            return Redirect()->back()->with('message', 'Xoá sản phẩm thất bại');
        }
    }

    public function update_cart(Request $request)
    {
        $data = $request->all();
        $cart = Session::get('cart');
        if ($cart) {
            foreach ($data['cart_qty'] as $key => $qty) {
                foreach ($cart as $session => $val) {
                    if ($val['session_id']  == $key) {
                        if ($cart[$session]['remain_qty'] - $qty < 0) {
                            // dd($cart[$session]['remain_qty']);
                            return Redirect()->back()->with('error', 'Số lượng thất bại cho sản phẩm ' . $cart[$session]['product_name'] . ' không đủ!');
                        } else {
                            $cart[$session]['product_qty'] = $qty;
                        }
                    }
                }
            }
            Session::put('cart', $cart);
            return Redirect()->back()->with('message', 'Cập nhập số lượng thành công');
        } else {
            return Redirect()->back()->with('message', 'Cập nhập số lượng thất bại');
        }

        // $product_id = $cart[0]['product_id'];
        // $product = Product::where('product_id', $product_id)->first();
        // dd($product->product_quantity);
    }

    public function delete_all_product()
    {
        $cart = Session::get('cart');
        if ($cart == true) {
            Session::forget('cart');
            Session::forget('coupon');
            Session::forget('fee');
            return Redirect()->back()->with('message', 'Xoá tất cả sản phẩm thành công');
        }
    }

    public function add_cart_ajax(Request $request)
    {
        // "cart_product_id" => "130"
        // "cart_product_name" => "123"
        // "cart_product_image" => "https://res.cloudinary.com/ddnvoenef/image/upload/v1672221610/Products/rrmr8fwzc23wtpcmpj6t.png"
        // "cart_product_price" => "123"
        // "cart_product_qty" => "1"
        // "remain_qty" => "123"
        // "_token" => "frzAvB1ASqHFhlDnP4w1a3gWjx1oplFacugAO9DD"


        $data = $request->all();
        // dd($data);
        $session_id = substr(md5(microtime()), rand(0, 26), 5);
        $cart = Session::get('cart');
        if ($cart) {
            $is_avaiable = 0;
            $i = 0;
            foreach ($cart as $key => $val) {
                if ($val['product_id'] == $data['cart_product_id']) {
                    $is_avaiable++;
                    $i = $key;
                }
            }
            if ($is_avaiable != 0) {
                // $cart[$i]['product_qty'] = $data['cart_product_qty'] + $val['product_qty'];
                // $cart[$i]['product_qty'] = 100;
                // Session::put('cart', $cart);
                // dd($cart[$i]['product_qty']);
            } else {
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price'],
                    'remain_qty' => $data['remain_qty'],
                );
                Session::put('cart', $cart);
            }
        } else {
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                'remain_qty' => $data['remain_qty'],
            );
            Session::put('cart', $cart);
        }
        Session::save();
    }

    public function gio_hang(Request $request)
    {

        $cart = Session::get('cart');
        $total = 0;
        if ($cart) {
            foreach (Session::get('cart') as $key => $cart) {
                $subtotal = $cart['product_price'] * $cart['product_qty'];
                $total += $subtotal;
            }
        }
        // dd($total);
        $meta_decs = "Giỏ hàng";
        $meta_title = "Giỏ hàng ";
        $meta_keyword = "Giỏ hàng ";
        $url_canonical = $request->url();
        $categories = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        return view('user.pages.cart.cart_ajax', compact('categories', 'cart', 'total'))
            ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical);
    }


    //Coupon


    // public function show_cart(Request $request)
    // {
    //     $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->paginate(5);

    //     $meta_decs = "Giỏ hàng1";
    //     $meta_title = "Giỏ hàng1";
    //     $meta_keyword = "Giỏ hàng1";
    //     $url_canonical = $request->url();
    //     $category = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id', 'desc')->get();
    //     $brand = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id', 'desc')->get();
    //     return view('user.pages.cart.show_cart', compact('category', 'brand', 'category_post'))
    //         ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical);
    // }

    // public function save_cart(Request $request)
    // {
    //     $productId = $request->productid_hidden;
    //     $quantity = $request->qty;

    //     $product_info = DB::table('tbl_product')->where('product_id', $productId)->first();

    //     $data['id'] = $product_info->product_id;
    //     $data['name'] = $product_info->product_name;
    //     $data['qty'] = $quantity;
    //     $data['price'] = $product_info->product_price;
    //     $data['weight'] = 0;
    //     $data['options']['image'] = $product_info->product_image;
    //     Cart::add($data);

    //     // Cart::destroy();
    //     return Redirect::to('/show_cart');
    // }

    // public function detele_to_cart($rowId)
    // {
    //     Cart::update($rowId, 0);
    //     return Redirect::to('/show_cart');
    // }

    // public function update_cart_qty(Request $request)
    // {
    //     $rowId = $request->rowId_cart;
    //     $quantity = $request->quantity_cart;

    //     Cart::update($rowId, $quantity);
    //     return Redirect::to('/show_cart');
    // }

}
