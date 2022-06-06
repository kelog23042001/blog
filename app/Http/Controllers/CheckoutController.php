<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
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
use App\Models\Customer;
use App\Models\Coupon;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;


class CheckoutController extends Controller
{

    public function momo_payment(Request $request)
    {


        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $serectkey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $_POST['total_momopay'];
        $orderId = time() . "";
        $redirectUrl = "http://127.0.0.1:8000/checkout";
        $ipnUrl = "http://127.0.0.1:8000/checkout";
        $extraData = "";



        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $serectkey);
        // dd($signature);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        \Session::put('pay_success', true);

        return redirect()->to($jsonResult['payUrl']);
        // header('Location: ' . $jsonResult['payUrl']);
    }
    public function vnpay_payment(Request $request)
    {

        $data = $request->all();
        $code_cart = rand(00, 9999);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/checkout";
        $vnp_TmnCode = "GEDE6LAR"; //Mã website tại VNPAY 
        $vnp_HashSecret = "SZXCXGPCPPYLGMYJPYWAQBCSGESOCRWP"; //Chuỗi bí mật

        $vnp_TxnRef = $code_cart; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán hoá đơn';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $data['total_vnpay'] * 100;
        $vnp_Locale = 'VN';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            // "vnp_ExpireDate" => $vnp_ExpireDate
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        \Session::put('pay_success', true);
    }
    public function confirm_order(Request $request)
    {
        $data = $request->all();

        $coupon_mail = '';
        if ($data['order_coupon'] != 'non') {
            $coupon = Coupon::where('coupon_code', $data['order_coupon'])->first();
            // $coupon->coupon_time = $coupon->coupon_time - 1;
            $coupon_number = $coupon->coupon_number;
            $coupon_condition = $coupon->coupon_condition;
            $coupon_mail = $data['order_coupon'];
            // $coupon->save();
        }

        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_notes = $data['shipping_notes'];
        $shipping->shipping_method = $data['shipping_method'];

        $shipping->save();
        $shipping_id = $shipping->shipping_id;


        $checkout_code = substr(md5(microtime()), rand(0, 26), 5);
        $order = new Order;
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();

        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');

        $order->created_at = $today;
        $order->order_date = $order_date;

        $order->save();


        if ($data['order_coupon'] != 'non') {
            $ordercode_mail = array(
                'coupon_number' => $coupon_number,
                'coupon_condition' => $coupon_condition,
                'coupon_code' => $coupon_mail,
                'order_code' => $data['order_coupon']
            );
        } else {
            $ordercode_mail = array(
                'coupon_number' => '',
                'coupon_condition' => '',
                'coupon_code' => '',
                'order_code' => $checkout_code
            );
        }


        if (Session::get('cart')) {
            foreach (Session::get('cart') as $key => $cart) {
                $order_details =  new OrderDetails;
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sale_quantity = $cart['product_qty'];
                if ($data['order_coupon'] != null) {
                    $order_details->product_coupon = $data['order_coupon'];
                } else {
                    $order_details->product_coupon = 0;
                }
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
        }

        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $title_mail = "Đơn hàng xác nhận ngày " . $now;
        $customer = Customer::find(Session::get('customer_id'));
        $data['email'][] = $customer->customer_email;

        if (session::get('cart')) {
            foreach (session::get('cart') as $key => $cart_mail) {
                $cart_array[] = array(
                    'product_name' => $cart_mail['product_name'],
                    'product_price' => $cart_mail['product_price'],
                    'product_qty' => $cart_mail['product_qty']
                );
            }
        }

        $shipping_array = array(
            'customer_name' => $customer->customer_name,
            'shipping_name' => $data['shipping_name'],
            'shipping_email' => $data['shipping_email'],
            'shipping_phone' => $data['shipping_phone'],
            'shipping_address' => $data['shipping_address'],
            'shipping_notes' => $data['shipping_notes'],
            'shipping_method' => $data['shipping_method'],
            'shipping_feeShip' => $data['order_fee']
        );

        Mail::send(
            'user.mail.mail_order',
            ['data' => $data, 'cart_array' => $cart_array, 'shipping_array' => $shipping_array, 'code' => $ordercode_mail],
            function ($message) use ($title_mail, $data) {
                $message->to($data['email'])->subject($title_mail);
                $message->from($data['email'], $title_mail);
            }
        );
        session::forget('cart');
        session::forget('pay_success');
        session::forget('fee');
        session::forget('coupon');
    }
    public function del_fee()
    {
        Session::forget('fee');
        return redirect()->back();
    }
    public function select_delivery_home(Request $request)
    {
        $data = $request->all();

        if ($data['action']) {
            $output = '';
            if ($data['action'] == 'city') {
                if ($data['id'] < 10) {
                    $data['id'] = '0' . $data['id'];
                }
                $select_province = Province::where('matp', $data['id'])->orderby('maqh', 'ASC')->get();
                $city = City::where('matp', $data['id'])->first();
                $output .= '<option>---Chọn Quận Huyện---</option>';
                foreach ($select_province as $key => $province) {
                    $output .= '<option value = "' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
                }
                Session::forget('city');
                // \Session::put('city', $city->name_city);
            } else {
                if ($data['id'] < 100) {
                    $data['id'] = '00' . $data['id'];
                }
                $select_wards = Wards::where('maqh', $data['id'])->orderby('xaid', 'ASC')->get();
                $output .= '<option>---Chọn Xã Phường---</option>';
                foreach ($select_wards as $key => $province) {
                    $output .= '<option value = "' . $province->xaid . '">' . $province->name_xaphuong . '</option>';
                }
                Session::forget('province');

                // \Session::put('province', $data['id']);
            }
        }
        // \Session::put('pay_success', true);
        echo $output;
    }

    public function calculate_fee(Request $request)
    {
        $data = $request->all();
        Session::forget('fee');
        
        Session::forget('city');
        Session::forget('province');
        Session::forget('wards');

        if ($data['matp'] < 10) {
            $data['matp'] = '0' . $data['matp'];
        }
        if ($data['maqh'] < 100) {
            $data['maqh'] = '00' . $data['maqh'];
        }elseif($data['maqh'] < 10){
            $data['maqh'] = '0' . $data['maqh'];
        }
        if ($data['xaid'] < 10000) {
            $data['xaid'] = '0000' . $data['xaid'];
        }elseif ($data['xaid'] < 1000) {
            $data['xaid'] = '000' . $data['xaid'];
        }elseif ($data['xaid'] < 100) {
            $data['xaid'] = '00' . $data['xaid'];
        }elseif ($data['xaid'] < 10) {
            $data['xaid'] = '0' . $data['xaid'];
        }


        $city = City::where('matp', $data['matp'])->first();

        $province = Province::where('maqh',$data['maqh'])->first();

        $wards = Wards::where('xaid',$data['xaid'])->first();

        // dd($wards->name_xaphuong);

        Session::put('city', $city->name_city);
        Session::put('province', $province->name_quanhuyen);
        Session::put('wards', $wards->name_xaphuong);

        if ($data['matp']) {
            $feeship = Feeship::where('fee_matp', $data['matp'])->where('fee_maqh', $data['maqh'])->where('fee_xaid', $data['xaid'])->get();
            if ($feeship) {
                $count_feeship = $feeship->count();
                if ($count_feeship > 0) {
                    foreach ($feeship as $key => $fee) {
                        Session::put('fee', $fee->fee_feeship);
                        Session::save();
                    }
                } else {
                    Session::put('fee', 20000);
                    Session::save();
                }
            }
        }
    }
    public function login_checkout(Request $request)
    {
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->paginate(5);

        $meta_decs = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $meta_keyword = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id', 'desc')->get();

        return view('user.pages.checkout.login_checkout', compact('category_post'))->with('category', $cate_product)->with('brand', $brand_product)
            ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical);
    }

    public function add_customer(Request $request)
    {

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
    public function checkout(Request $request)
    {
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->paginate(5);

        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id', 'desc')->get();
        $city = City::orderby('matp', 'ASC')->get();
        $province = Province::orderby('maqh', 'ASC')->get();
        $wards = Wards::orderby('xaid', 'ASC')->get();
        if (Session::get('customer_id')) {
            $customerid = Session::get('customer_id');
        } else {
            $customerid = -1;
        }
        $customer = Customer::where('customer_id', $customerid)->first();
        // dd($customer);
        return view('user.pages.checkout.show_checkout', compact('category_post', 'customer'))->with('category', $cate_product)->with('brand', $brand_product)
            ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical)
            ->with(compact('city'));
    }

    public function save_checkout_customer(Request $request)
    {
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

    public function payment(Request $request)
    {
        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id', 'desc')->get();
        return view('user.pages.checkout.payment')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical);
    }

    public function order_place(Request $request)
    {
        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id', 'desc')->get();
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
        foreach ($content as $v_content) {
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] =  $v_content->name;
            $order_d_data['product_price'] =  $v_content->price;
            $order_d_data['product_sale_quantity'] =  $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }
        if ($data['payment_method'] == 1) {
            echo 'Thanh toán ATM';
        } else if ($data['payment_method'] == 2) {
            Cart::destroy();
            return view('user.pages.checkout.handcash')->with('category', $cate_product)->with('brand', $brand_product)
                ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical);
        } else {
            echo 'Thẻ ghi nợ';
        }

        //return Redirect('/payment');
    }

    public function view_order($orderId, Request $request)
    {
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->paginate(5);

        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $order_by_id = DB::table('tbl_order')
            ->join('tbl_customers', 'tbl_order.customer_id', '=', 'tbl_customers.customer_id')
            ->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
            ->join('tbl_order_details', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
            ->select('tbl_order.*', 'tbl_customers.*', 'tbl_shipping.*', 'tbl_order_details.*')
            ->first();

        $manage_order_by_id = view('admin.view_order')->with('order_by_id', $order_by_id);
        return view('admin_layout', compact('category_post'))->with('admin.view_order', $manage_order_by_id)
            ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical);
    }

    public function logout_checkout(Request $request)
    {
        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        Session::flush();
        return Redirect('/login-checkout')->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical);
    }

    public function login_customer(Request $request)
    {
        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $email = $request->email_account;
        $password = $request->password_account;
        $result =  DB::table('tbl_customers')->where('customer_email', $email)->where('customer_password', $password)->first();

        if ($result) {
            Session::put('customer_id', $result->customer_id);
            return Redirect('/checkout')->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical);
        } else {
            return Redirect('/login-checkout')->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical);
        }
    }

    public function manage_order()
    {
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->paginate(5);

        $all_order = DB::table('tbl_order')
            ->join('tbl_customers', 'tbl_order.customer_id', '=', 'tbl_customers.customer_id')
            ->select('tbl_order.*', 'tbl_customers.customer_name')
            ->orderBy('tbl_order.order_id', 'desc')
            ->get();

        $manage_order = view('admin.manage_order')->with('all_order', $all_order);
        return view('admin_layout', compact('category_post'))->with('admin.manage_order', $manage_order);
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
}
