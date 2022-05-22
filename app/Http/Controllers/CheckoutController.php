<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Feeship;
use App\Models\Province;
use App\Models\Wards;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

use App\Models\Shipping;
use App\Models\OrderDetails;
use App\Models\Order;

class CheckoutController extends Controller
{

    public function confirm_order(Request $request){
        $data = $request->all();
        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_email = $data['shipping_name'];
        $shipping->shipping_phone = $data['shipping_name'];
        $shipping->shipping_address = $data['shipping_name'];
        $shipping->shipping_notes = $data['shipping_name'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();
        $shipping_id = $shipping->shipping_id;

        $checkout_code = substr(md5(microtime()),rand(0,26),5);
        $order=new Order;
        $order->customer_id=Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status=1;
        $order->order_code = $checkout_code;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();
        $order->save();

        if(Session::get('cart')){
            foreach(Session::get('cart') as $key=>$cart){
                $order_details =  new OrderDetails;
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price=$cart['product_price'];
                $order_details->product_sale_quantity = $cart['product_qty'];
                if($data['order_coupon']!=null){
                    $order_details->product_coupon = $data['order_coupon'];
                }else{
                    $order_details->product_coupon = 0;
                }
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
        }
        Session :: forget('coupon');
        Session :: forget('fee');
        Session :: forget('cart');
    }
    public function del_fee(){
        Session::forget('fee');
        return redirect()->back();
    }
    public function select_delivery_home(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action'] == 'city'){
                $select_province = Province::where('matp', $data['ma_id'])->orderby('maqh', 'ASC')->get();
                $output.='<option>---Chọn quận huyện---</option>';
                foreach($select_province as $key => $province){
                    $output.='<option value = "'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }
            }else{
                $select_wards = Wards::where('maqh', $data['ma_id'])->orderby('xaid', 'ASC')->get();
                $output.='<option>---Chọn xã phường---</option>';
                foreach($select_wards as $key => $province){
                    $output.='<option value = "'.$province->xaid.'">'.$province->name_xaphuong.'</option>';
                }
            }
        }
        echo $output;
    }

    public function calculate_fee(Request $request){
        $data = $request->all();
        if($data['matp']){
            $feeship = Feeship::where('fee_matp', $data['matp'])->where('fee_maqh', $data['maqh'])->where('fee_xaid', $data['xaid'])->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship > 0){
                    foreach($feeship as $key => $fee){
                    Session::put('fee', $fee->fee_feeship);
                    Session::save();
                    }
                }else{
                    Session::put('fee', 20000);
                    Session::save();
                }
            }
            
        }

    }
    public function login_checkout(Request $request){
        $meta_decs = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $meta_keyword = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();

        return view('user.pages.checkout.login_checkout')->with('category', $cate_product)->with('brand', $brand_product)
        ->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical);
    }

    public function add_customer(Request $request){

        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_password'] = $request->customer_password;
        $data['customer_email'] = $request->customer_email;
        $data['customer_phone'] = $request->customer_phone;

        $customer_id = DB::table('tbl_customers')->insertGetId($data);

        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);
        // dd(Redirect()->back());
        return Redirect('/checkout');

    }
    public function checkout(Request $request){
        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();
        $city = City::orderby('matp', 'ASC')->get();
        $province = Province::orderby('maqh', 'ASC')->get();
        $wards = Wards::orderby('xaid', 'ASC')->get();

        return view('user.pages.checkout.show_checkout')->with('category', $cate_product)->with('brand', $brand_product)
        ->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical)
        ->with(compact('city'));
    }

    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;

        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_notes'] = $request->shipping_notes;
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id', $shipping_id);


        return Redirect('/payment');
    }

    public function payment(Request $request){
        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();
        return view('user.pages.checkout.payment')->with('category', $cate_product)->with('brand', $brand_product)
        ->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical);
    }

    public function order_place(Request $request){
        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();
        //insert payment method
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_data['order_total'] = Cart::total();
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        //inser order detail
        $content = Cart::content();
       foreach($content as $v_content){
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] =  $v_content->name;
            $order_d_data['product_price'] =  $v_content->price;
            $order_d_data['product_sale_quantity'] =  $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
       }
       if($data['payment_method'] == 1){
           echo 'Thanh toán ATM';
       }else if($data['payment_method'] == 2){
            Cart::destroy();
            return view('user.pages.checkout.handcash')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical);
       }else{
           echo 'Thẻ ghi nợ';
       }

        //return Redirect('/payment');
    }

    public function view_order($orderId, Request $request){
        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_details.*')
        ->first();

        $manage_order_by_id = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order', $manage_order_by_id)
        ->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical);

    }

    public function logout_checkout(Request $request){
        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        Session::flush();
        return Redirect('/login-checkout')->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical);
    }

    public function login_customer(Request $request){
        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $email = $request->email_account;
        $password = $request->password_account;
        $result =  DB::table('tbl_customers')->where('customer_email', $email)->where('customer_password', $password)->first();

        if($result){
            Session::put('customer_id', $result->customer_id);
            return Redirect('/checkout')->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical);
        }else{
            return Redirect('/login-checkout')->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical);
        }

    }

    public function manage_order(){
        $all_order = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->select('tbl_order.*','tbl_customers.customer_name')
        ->orderBy('tbl_order.order_id','desc')
        ->get();

        $manage_order = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order', $manage_order);
    }


}
