<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class MailController extends Controller
{
    //
    public function send_coupon($coupon_code)
    {
        $customer = Customer::orderBy('customer_id')->get();
        $data = [];
        foreach ($customer as $cus) {
            $data['email'][] = $cus->customer_email;
        }
        $coupon = Coupon::where('coupon_code', $coupon_code)->first();
        $start_date = $coupon->coupon_date_start;
        $end_date = $coupon->coupon_date_end;
        $coupon_time = $coupon->coupon_time;
        $coupon_condition = $coupon->coupon_condition;
        $coupon_number = $coupon->coupon_number;
        $coupon_name = $coupon->coupon_name;
        $coupon = array(
            'start_coupon' => $start_date,
            'end_coupon' => $end_date,
            'coupon_time' => $coupon_time,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_name' => $coupon_name,
            'coupon_code' => $coupon_code
        );

        $to_name = "LKShop";
        $to_email = $data['email'];

        $data = array("name" => "LKShop", "body" => "Mail mã khuyến mãi");

        Mail::send('admin.mail.mail_coupon', ['coupon' => $coupon], function ($message) use ($to_name, $to_email) {
            $message->to($to_email)->subject('Nhận mã khuyến mãi');
            $message->from($to_email, $to_name);
        });
        // dd($coupon);
        return redirect()->back()->with('message', 'Gửi mail thành công');
    }

    public function mail_order()
    {
        # code...
        return view('user.mail.mail_order');
    }
    public function send_example()
    {
        $coupon = Coupon::where('coupon_code', 2)->first();
        $start_date = $coupon->coupon_date_start;
        $end_date = $coupon->coupon_date_end;
        $coupon_time = $coupon->coupon_time;
        $coupon_condition = $coupon->coupon_condition;
        $coupon_number = $coupon->coupon_number;
        $coupon_name = $coupon->coupon_name;
        $coupon = array(
            'start_coupon' => $start_date,
            'end_coupon' => $end_date,
            'coupon_time' => $coupon_time,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_name' => $coupon_name,
            'coupon_code' => 2
        );
        return view('admin.mail.mail_coupon', compact('coupon'));
    }
}
