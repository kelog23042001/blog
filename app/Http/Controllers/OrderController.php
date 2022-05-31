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
        return "1";
    }
    public function manage_order()
    {
        $order = Order::orderby('created_at', 'DESC')->get();
        return view('admin.manage_order')->with(compact('order'));
    }
    public function view_order($order_code)
    {
        $order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
        $order = Order::where('order_code', $order_code)->get();
        foreach ($order as $key => $ord) {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
            $order_status = $ord->order_status;
        }
        $customer = Customer::where('customer_id', $customer_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
        $order_details_products = OrderDetails::with('product')->where('order_code', $order_code)->get();
        foreach ($order_details_products as $key => $order_d) {
            $product_coupon = $order_d->product_coupon;
        }
        if ($product_coupon != 0) {
            $coupon = Coupon::where('coupon_code', $product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number =  $coupon->coupon_number;
        } else {
            $coupon_condition = 2;
            $coupon_number =  0;
        }

        return view('admin.view_order')->with(compact('order_details', 'customer', 'shipping', 'order_details', 'coupon_number', 'coupon_condition', 'order', 'order_status'));
    }


    public function update_qty(Request $request)
    {
        $data = $request->all();
        $order_details = OrderDetails::where('product_id', $data['order_product_id'])->where('order_code', $data['order_code'])->first();
        $order_details->product_sale_quantity = $data['order_qty'];
        $order_details->save();
    }

    public function update_order_quantity(Request $request)
    {
        $data = $request->all();
        $order = Order::find($data['order_id']);
        $order->order_status = $data['order_status'];
        $order->save();

        $order_date = $order->order_date;

        $statistic = Statistic::where('order_date', $order_date)->get();
        if ($statistic) {
            $statistic_count = $statistic->count();
        } else {
            $statistic_count = 0;
        }

        if ($order->order_status == 2) {
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
                        $total_order += 1;
                        $sales += $product_price * $qty;
                        $profit = $sales - ($product_cost * $qty);
                    }
                }
            }

            $title_mail = "Đơn hàng của bạn đã được giao";


            $customer = Customer::find(Session::get('customer_id'));

            $shipping = Shipping::where('shipping_id', $order->shipping_id)->first();
            $details = OrderDetails::where('order_code', $order->order_code)->first();
            $fee_ship = $details->product_feeship;
            $coupon_code = $details->product_coupon;

            if($coupon_code != 0){
                $coupon = Coupon::find($coupon_code)->first();
                $coupon_number = $coupon->coupon_number;
                $coupon_condition = $coupon->coupon_condition;
            }else{
                $coupon_number = 0;
            }

            $ordercode_mail = array(
                'coupon_number'=> $coupon_number,
                'coupon_condition'=> $coupon_condition,
                'coupon_code' => $coupon_code,
            );
            
            $shipping_array = array(
                'customer_name'=>$customer->customer_name,
                'shipping_name' => $shipping->shipping_name,
                'shipping_email' => $shipping->shipping_email,
                'shipping_phone' => $shipping->shipping_phone,
                'shipping_address' => $shipping->shipping_address,
                'shipping_notes' => $shipping->shipping_notes,
                'shipping_method' => $shipping->shipping_method,
                'feeShip' => $fee_ship
            );

            $data['email'][] = $customer->customer_email;
            

            Mail::send(
                'admin.mail.confirm_order',
                ['data', $data, 'cart_array' => $cart_array, 'shipping_array' => $shipping_array, 'cart_array' => $cart_array,'code' => $ordercode_mail],
                function ($message) use ($data, $title_mail) {
                    $message->to($data['email'])->subject($title_mail);
                    $message->from($data['email'], "LKShop");
                }
            );


            if ($statistic_count > 0) {
                $statistic_update = Statistic::where('order_date', $order_date)->first();
                $statistic_update->sales = $statistic_update->sales + $sales;
                $statistic_update->profit = $statistic_update->profit + $profit;
                $statistic_update->quantity = $statistic_update->quantity + $quantity;
                $statistic_update->total_order = $statistic_update->total_order + $total_order;
                $statistic_update->save();
            } else {
                $statistic_new  = new Statistic();
                $statistic_new->sales = $sales;
                $statistic_new->order_date = $now;
                $statistic_new->profit =  $profit;
                $statistic_new->quantity =  $quantity;
                $statistic_new->total_order = $total_order;
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
}
