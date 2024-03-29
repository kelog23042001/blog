<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Exception;

class MailController extends Controller
{

    public function send_coupon($coupon_code)
    {
        $customer = User::orderBy('id')->get();
        $data = [];
        foreach ($customer as $cus) {
            $data['email'][] = $cus->email;
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
        $coupon = Coupon::first();
        $start_date = $coupon->coupon_date_start; //ngày kết thúc
        $end_date = $coupon->coupon_date_end; // ngày bắt đầu
        $coupon_time = $coupon->coupon_time; // số lần nhập coupon
        $coupon_condition = $coupon->coupon_condition; //% or money
        $coupon_number = $coupon->coupon_number; //số tiền giảm or % giảm
        $coupon_name = $coupon->coupon_name; // tên coupon
        $coupon_code = $coupon->coupon_code; // tên coupon
        $coupon = array(
            'start_coupon' => $start_date,
            'end_coupon' => $end_date,
            'coupon_time' => $coupon_time,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_name' => $coupon_name,
            'coupon_code' => $coupon_code,
        );

        $customer = Customer::orderBy('customer_id')->get();
        $data = [];
        foreach ($customer as $cus) {
            $data['email'][] = $cus->customer_email;
        }
        // dd($data);
        $to_name = "LKShop";
        $to_email = $data['email'];

        $data = array("name" => "LKShop", "body" => "Mail mã khuyến mãi");

        try {
            Mail::send('admin.mail.mail_coupon', ['coupon' => $coupon], function ($message) use ($to_name, $to_email) {
                $message->to($to_email)->subject('Nhận mã khuyến mãi');
                $message->from($to_email, $to_name);
            });
        } catch (Exception $e) {
            dd($e);
        }
        // dd($coupon);
        // return view('admin.mail.mail_coupon', compact('coupon'));
    }
}
