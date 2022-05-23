<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('coupon_code', $data['coupon'])->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon > 0){
                $coupon_session = Session::get('coupon');
                if($coupon_session == true){
                   $is_avaiable = 0;
                   if($is_avaiable == 0){
                       $cou[] = array(
                           'coupon_code' =>$coupon->coupon_code,
                           'coupon_condition' =>$coupon->coupon_condition,
                           'coupon_number' =>$coupon->coupon_number,
                       );
                       Session::put('coupon',$cou);
                   }

                }
                else{
                    $cou[] = array(
                        'coupon_code' =>$coupon->coupon_code,
                        'coupon_condition' =>$coupon->coupon_condition,
                        'coupon_number' =>$coupon->coupon_number,
                    );
                    Session::put('coupon',$cou);
             }
                Session::save();
                return redirect()->back()->with('message', 'Thêm mã giảm giá thành công');
            }
        }else{
           return redirect()->back()->with('error', 'Mã giảm giá không đúng');

        }
    }
    public function insert_coupon_code(Request $request){
        $this->validate($request,[
            'coupon_code' => ['required','max:255', 'unique:tbl_coupon'],
        ]);
        $data = $request->all();
       $coupon = new Coupon();

       $coupon->coupon_name      = $data['coupon_name'];
       $coupon->coupon_number    = $data['coupon_number'];
       $coupon->coupon_time      = $data['coupon_time'];
       $coupon->coupon_condition = $data['coupon_condition'];
       $coupon->coupon_code      = $data['coupon_code'];

       $coupon->save();
       Session::put('message', 'Thêm mã giảm giá thành công');
       return Redirect::to('/insert-coupon');
    }

    public function insert_coupon(){
        return view('admin.coupon.insert_coupon');
    }


    public function list_coupon(Request $request){
        $coupon = Coupon::orderby('coupon_id','DESC')->paginate(5);
        return view('admin.coupon.list_coupon', compact('coupon'));

    }

    public function delete_coupon($coupon_id){
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();
        Session::put('message', 'Xoá mã giảm giá thành công');
       return Redirect::to('/list-coupon');
    }

    public function unset_coupon(){
        $coupon = Session::get('coupon');
        if($coupon == true){

            Session::forget('coupon');
            return Redirect()->back()->with('message','Xoá mã giảm giá thành công');

        }
    }
}
