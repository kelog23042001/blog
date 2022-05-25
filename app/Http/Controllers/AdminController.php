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
session_start();

class AdminController extends Controller
{
    public function index(){
        return view('admin_login');
    }
    public function show_dashboard(){
        return view('admin.dashboard');
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
        return Redirect::to('admin');
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

