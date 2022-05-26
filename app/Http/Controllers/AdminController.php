<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Login;
use App\Models\Social;
use App\Models\SocialCustomer;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use  Laravel\Socialite\SocialiteServiceProvider;
use Laravel\Socialite\Facades\Socialite;

use App\Models\Statistic;
use App\Models\Product;
use App\Models\Order;
use App\Models\Post;
use App\Models\Visitors;
use Carbon\Carbon;

session_start();

class AdminController extends Controller
{
    public function index(){
        return view('admin_login');
    }
    public function show_dashboard( Request $request){
        $user_ip_address = $request->ip();

        $early_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endofMonth()->toDateString();

        $early_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $oneyears = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        // total last month
        $visitor_of_lastmonth = Visitors::whereBetween('date_visitors', [$early_last_month, $end_of_last_month])->get();
        $visitor_last_month_count = $visitor_of_lastmonth->count();

        // total this month
        $visitor_of_thismonth = Visitors::whereBetween('date_visitors', [$early_this_month, $now])->get();
        $visitor_this_month_count = $visitor_of_thismonth->count();

        // total in one year
        $visitor_of_year = Visitors::whereBetween('date_visitors', [$oneyears, $now])->get();
        $visitor_year_count = $visitor_of_year->count();
        // current online
        $visitors_current = Visitors::where('ip_address', $user_ip_address)->get();
        $visitor_count = $visitors_current->count();

        if ($visitor_count < 1) {
            $visitor = new Visitors();
            $visitor->ip_address = $user_ip_address;
            $visitor->date_visitors = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $visitor->save();
        }

        // total visitors
        $visitors = Visitors::all();
        $visitors_total = $visitors->count();

        $product_count = Product::all()->count();
        // $product_views = Product::orderBy('product_views', 'DESC')->take(20)->get();

        $post_count = Post::all()->count();
        // $post_views = Post::orderBy('post_views', 'DESC')->take(20)->get();

        $order_count = Order::all()->count();
        $customer_count = Customer::all()->count();

        $product_views = Product::orderBy('product_views', 'DESC')->take(10)->get();
        $post_views = Post::orderBy('post_views', 'DESC')->take(10)->get();

        return view('admin.dashboard', compact('product_views', 'post_views', 'product_count', 'post_count', 'order_count', 'customer_count', 'visitor_year_count', 'visitors_total', 'visitor_count', 'visitor_last_month_count', 'visitor_this_month_count',));
    
    }
    
    public function day_order()
    {
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistic::whereBetween('order_date', [$dauthangnay, $now])->orderBy('order_date', 'ASC')->get();
        $chart_data[] = array();
        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        // echo $get;
        echo $data = json_encode($chart_data);
    }

    public function dashboard_filter(Request $request)
    {
        $data = $request->all();
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if ($data['dashboard_value'] == '7ngay') {

            $get = Statistic::whereBetween('order_date', [$sub7days, $now])->orderBy('order_date', 'ASC')->get();
        } else 
        if ($data['dashboard_value'] == 'thangtruoc') {

            $get = Statistic::whereBetween('order_date', [$dau_thangtruoc, $cuoi_thangtruoc])->orderBy('order_date', 'ASC')->get();
        } else if ($data['dashboard_value'] == 'thangnay') {

            $get = Statistic::whereBetween('order_date', [$dauthangnay, $now])->orderBy('order_date', 'ASC')->get();
        } else if ($data['dashboard_value'] == '365ngayqua') {

            $get = Statistic::whereBetween('order_date', [$sub365days, $now])->orderBy('order_date', 'ASC')->get();
        }
        $chart_data[] = array();
        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }
    public function filter_by_date(Request $request)
    {
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $chart_data[] = array();
        $get = Statistic::whereBetween('order_date', [$from_date, $to_date])->orderBy('order_date', 'ASC')->get();
        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }
    public function dashboard(Request $request){
        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);
        $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password', $admin_password)->first();
        if($result){
            Session::put('admin_name', $result->admin_name);
            Session::put('admin_id', $result->admin_id);
            return Redirect::to('/dashboard');
        }else{
            Session::put('message', 'Mật khẩu hoặc tài khoản không dúng, làm ơn nhập lại');
            return Redirect::to('/admin');
        }
        return view('admin.dashboard');
        print_r($result);
    }
    public function logout(){
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/login-auth');
    }


    public function login_customer_google(){

         return Socialite::driver('google')->redirect();
   }

   public function callback_customer_google(){


            $users = Socialite::driver('google')->stateless()->user();


            $authUser = $this->FindOrCreateCustomer($users, 'google');
            if($authUser){
                $account_name = Customer::where('customer_id',$authUser->user)->first();
                Session::put('customer_id',$account_name->customer_id);
                Session::put('customer_picture',$account_name->customer_picture);
                Session::put('customer_name',$account_name->customer_name);
                Session::put('customer_phone',$account_name->customer_phone);
                Session::put('customer_email',$account_name->customer_email);
            }else{
                $account_name = Customer::where('customer_id',$authUser->user)->first();
                Session::put('customer_id',$account_name->customer_id);
                Session::put('customer_picture',$account_name->customer_picture);
                Session::put('customer_name',$account_name->customer_name);
                Session::put('customer_phone',$account_name->customer_phone);
                Session::put('customer_email',$account_name->customer_email);

            }
           return redirect('/trang-chu')->with('message', 'Đăng nhập tài khoản google '.$account_name->customer_email.' thành công');
   }

    public function FindOrCreateCustomer($users, $provider){
        $authUser = SocialCustomer::where('provider_user_id', $users->id)->first();
        if($authUser){
            return $authUser;
        }else{
                $customer_new = new SocialCustomer([
                'provider_user_id' => $users->id,
                'provider_user_email' => $users->email,
                'provider' => strtoupper($provider)
            ]);

             $customer = Customer::where('customer_email',$users->email)->first();

             if(!$customer){
                $customer = Customer::create([
                    'customer_name' => $users->name,
                    'customer_email' => $users->email,
                    'customer_picture' => '',

                    'customer_password' => '123456',
                    'customer_phone' => '01234567'
                ]);
            }
             $customer_new->customer()->associate($customer);
            $customer_new->save();
            return $customer_new;
        }

    }


}

