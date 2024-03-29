<?php

namespace App\Http\Controllers;

use App\Models\Feeship;
use App\Models\Shipping;
use App\Models\OrderDetails;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Coupon;
use Illuminate\Http\Request;
use PDF;
use App\Models\Product;
use App\Models\Statistic;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\Banner;
use App\Models\CategoryPost;
use App\Models\CategoryProductModel;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function print_order($order_code)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($order_code));
        return $pdf->stream();
    }
    public function print_order_convert($order_code)
    {
        $order = Order::where('order_code', $order_code)->get();

        foreach ($order as $key => $ord) {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = Customer::where('customer_id', $customer_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();

        $order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
        foreach ($order_details as $key => $order_d) {
            $product_coupon = $order_d->product_coupon;
        }
        $output = '';
        $output = '
        <style>
        body{
            font-family: Dejavu Sans;
        }
        table, th, td {
            border: 1px solid black;
            margin: o auto;
            padding: 10px 20px;
            border-collapse: collapse;
        }
        </style>
        <div class="table-agile-info">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><h2>THÔNG TIN ĐƠN HÀNG</h2></center>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nguời nhận hàng</th>
                                <th>Địa chỉ</th>
                                <th>Số điện thoại</th>
                                <th>Ghi Chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>' . $shipping->shipping_name . '</td>
                                <td>' . $shipping->shipping_address . '</td>
                                <td>' . $shipping->shipping_phone . '</td>
                                <td>' . $shipping->shipping_notes . '</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="table-agile-info">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <center><h2>THÔNG TIN HÀNG HOÁ</h2></center>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                            </tr>
                        </thead>
                        <tbody>';
        $i = 0;
        $total = 0;
        foreach ($order_details as $key => $details) {
            $i++;
            $subTotal = $details->product_price * $details->product_sale_quantity;
            $total += $subTotal;
            $output .=
                '<tr>'
                . '<td>' . $details->product_name . '</td>'
                . '<td>' . $details->product_sale_quantity . '</td>'
                . '<td>' . number_format($details->product_price, 0, ',', '.') . ' VND</td>' .
                '</tr>';
        }
        $total_coupon = $product_coupon;
        // dd($total_coupon);
        $output .= '  <tr>
                                <td colspan="2" style="text-align:right">Thành tiền</td>
                                <td>' . number_format($total, 0, ',', '.') . ' VND</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:right">Phí vận chuyển</td>
                                <td>' . number_format($details->product_feeship, 0, ',', '.') . ' VND</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:right">Giảm giá</td>
                                <td>' . number_format($product_coupon, 0, ',', '.') . ' VND</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:right">Tổng tiền thanh toán</td>
                                <td>' . number_format($total - $total_coupon + $details->product_feeship, 0, ',', '.') . ' VND</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        ';
        return ($output);
    }
    public function manage_order()
    {
        $order = Order::orderby('created_at', 'DESC')->get();
        return view('admin.manage_order')->with(compact('order'));
    }
    public function view_order($order_code)
    {
        $order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
        $order = Order::where('order_code', $order_code)->first();
        $customer_id = $order->customer_id;
        $shipping_id = $order->shipping_id;
        $order_status = $order->order_status;
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
        $order_details_products = OrderDetails::with('product')->where('order_code', $order_code)->first();
        $coupon = $order_details_products->product_coupon;
        $customer = Customer::where('customer_id', $customer_id)->first();
        return view('admin.view_order')
            ->with('order', $order)
            ->with('order_details', $order_details)
            ->with('customer', $customer)
            ->with('coupon', $coupon)
            ->with('shipping', $shipping)
            ->with('order_status', $order_status);
    }


    public function update_qty(Request $request)
    {
        $data = $request->all();
        $order_details = OrderDetails::where('product_id', $data['order_product_id'])->where('order_code', $data['order_code'])->first();
        $order_details->product_sale_quantity = $data['order_qty'];
        $order_details->save();
    }

    public function destroy_order(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $order = Order::find($data['order_id']);
        $order->order_status = $data['order_status'];
        $order->save();

        $order_date = $order->order_date;

        $shipping = Shipping::where('shipping_id', $order->shipping_id)->first();
        if ($shipping->shipping_email) {
            $title_mail = "Trạng thái đơn hàng của bạn đã thay đổi";
            $details = OrderDetails::where('order_code', $order->order_code)->get();
            $fee_ship = $details[0]->product_feeship;
            $coupon_number = 0;
            if ($details[0]->product_coupon)
                $coupon_number = $details[0]->product_coupon;
            // dd($coupon_number);
            $ordercode_mail = array(
                'coupon_number' => $coupon_number,
                'order_code' => $data['order_id'],
            );

            $shipping_array = array(
                'customer_name' => $shipping->customer_name,
                'shipping_name' => $shipping->shipping_name,
                'shipping_email' => $shipping->shipping_email,
                'shipping_phone' => $shipping->shipping_phone,
                'shipping_address' => $shipping->shipping_address,
                'shipping_notes' => $shipping->shipping_notes,
                'shipping_method' => $shipping->shipping_method,
                'feeShip' => $fee_ship
            );

            $data['email'][] = $shipping->shipping_email;
            // dd($details);
            Mail::send(
                'admin.mail.confirm_order',
                ['data', $data, 'cart_array' => $details, 'shipping_array' => $shipping_array, 'code' => $ordercode_mail],
                function ($message) use ($data, $title_mail) {
                    $message->to($data['email'])->subject($title_mail);
                    $message->from($data['email'], "LKShop");
                }
            );
        }


        $statistic = Statistic::where('order_date', $order_date)->get();
        if ($statistic) {
            $statistic_count = $statistic->count();
        } else {
            $statistic_count = 0;
        }

        if ($order->order_status == 2) {
            // đơn hàng đã xử lý, đang giao hàng
            $total_order = 0;
            $sales = 0;
            $profit = 0;
            $quantity = 0;
            foreach ($data['order_product_id'] as $key => $product_id) {
                $product = Product::find($product_id);
                $product_quantity = $product->product_quantity;
                $product_sold = $product->product_sold;
                $product_price = $product->product_price;
                $product_cost = $product->price_cost;
                $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

                foreach ($data['quantity'] as $key2 => $qty) {
                    if ($key == $key2) {
                        $cart_array[] = array(
                            'product_name' => $product['product_name'],
                            'product_price' => $product['product_price'],
                            'product_qty' => $qty
                        );
                        $pro_remain = $product_quantity - $qty;
                        $product->product_quantity = $pro_remain;
                        $product->product_sold = $product_sold + $qty;
                        $product->save();

                        //update doanh thu
                        $quantity += $qty;
                        // $total_order += 1;
                        $sales += $product_price * $qty;
                        $profit = $sales - ($product_cost * $qty);
                    }
                }
            }

            if ($statistic_count > 0) {
                // dd($statistic_count);
                $statistic_update = Statistic::where('order_date', $order_date)->first();
                $statistic_update->sales = $statistic_update->sales + $sales;
                $statistic_update->profit = $statistic_update->profit + $profit;
                $statistic_update->quantity = $statistic_update->quantity + $quantity;
                $statistic_update->total_order = $statistic_update->total_order + 1;
                // $statistic_update->total_order = $statistic_update->total_order + $total_order;
                $statistic_update->save();
            } else {
                $statistic_new  = new Statistic();
                $statistic_new->sales = $sales;
                $statistic_new->order_date = $now;
                $statistic_new->profit =  $profit;
                $statistic_new->quantity =  $quantity;
                $statistic_new->total_order = 1;
                // $statistic_new->total_order = $total_order;
                $statistic_new->save();
            }
            // elseif($order->order_status != 2 && $order->order_status != 3){
            //     foreach($data['order_product_id'] as $key => $product_id){
            //         $product = Product::find($product_id);
            //         $product_quantity = $product->product_quantity;
            //         $product_sold = $product->product_sold;

            //         foreach($data['quantity'] as $key2 => $qty){
            //             if($key == $key2){
            //                 $pro_remain = $product_quantity + $qty;
            //                 $product->product_quantity = $pro_remain;
            //                 $product->product_sold = $product_sold - $qty;
            //                 $product->save();
            //             }
            //         }
            //     }
            // }
        }
    }

    public function history_order(Request $request)
    {
        // if (!Session::get('customer_id')) {
        //     return redirect('login-checkout')->with('error', 'Bạn chưa đăng nhập!');
        // } else 
        {
            $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->where('cate_post_status', "1")->get();
            //slider
            $slider = Banner::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

            $meta_decs = "Lịch sử mua hàng";
            $meta_title = "Lịch sử mua hàng";
            $meta_keyword = "Lịch sử mua hàng";
            $url_canonical = $request->url();

            $categories = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
            $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

            $order = Order::where('user_id', Auth::user()->id)->orderby('created_at', 'DESC')->get();
            // dd($order);
            return view('user.pages.history.history')->with('order', $order)->with('categories', $categories)->with('brand', $brand_product)
                ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical)
                ->with('slider', $slider)->with('category_post', $category_post);
            //     return view('user.pages.history.history')->with(compact('order'));
        }
    }

    public function view_history_order($order_code, Request $request)
    {
        //slider
        $meta_decs = "Lịch sử mua hàng";
        $meta_title = "Lịch sử mua hàng";
        $meta_keyword = "Lịch sử mua hàng";
        $url_canonical = $request->url();
        $cate_product = CategoryProductModel::where('category_status', '1')->orderBy('category_id', 'desc')->get();

        $order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();

        $order = Order::where('order_code', $order_code)->first();
        // dd($order);

        $shipping_id = $order->shipping_id;
        $order_status = $order->order_status;
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
        $order_details_products = OrderDetails::with('product')->where('order_code', $order_code)->first();
        $coupon = $order_details_products->product_coupon;
        // dd($order_details_products);


        return view('user.pages.history.view_history_order')
            ->with('order', $order)
            ->with('categories', $cate_product)
            ->with('meta_decs', $meta_decs)
            ->with('meta_title', $meta_title)
            ->with('meta_keyword', $meta_keyword)
            ->with('url_canonical', $url_canonical)
            ->with('order_details', $order_details)
            ->with('coupon', $coupon)
            ->with('shipping', $shipping)
            ->with('order_status', $order_status);
        // if ($product_coupon != 0) {
        //     $coupon_condition = $coupon->coupon_condition;
        //     $coupon_number =  $coupon->coupon_number;
        // } else {
        //     $coupon_condition = 2;
        //     $coupon_number =  0;
        // }
        // dd($customer);
    }
}
