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
class OrderController extends Controller
{
    public function print_order($order_code){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($order_code));
        return $pdf->steam();
    }
    public function print_order_convert($order_code){
        return "1";
    }
    public function manage_order(){
        $order = Order::orderby('created_at', 'DESC')->get();
        return view('admin.manage_order')->with(compact('order'));
    }
    public function view_order($order_code){
        $order_details = OrderDetails::where('order_code',$order_code)->get();
        $order = Order::where('order_code',$order_code)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();
        $order_details =  OrderDetails :: with('product')->where('order_code',$order_code)->get();
        foreach($order_details as$key=>$order_d){
            $product_coupon = $order_d->product_coupon;
         }
        if($product_coupon != 0){
            $coupon = Coupon:: where('coupon_code',$product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number =  $coupon->coupon_number;
        }else{
            $coupon_condition = 2;
            $coupon_number =  0;
        }      

        return view('admin.view_order')->with(compact('order_details','customer','shipping','order_details', 'coupon_number', 'coupon_condition'));
    }
    

}
