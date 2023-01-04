<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function check_coupon(Request $request)
    {
        // $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        // "coupon" => "tet2023"
        $data = $request->all();
        // dd($data);
        $now =  date("Y-m-d");
        $coupon = Coupon::where('coupon_code', $data['coupon'])->where('coupon_time', '>', 0)
            ->whereDate('coupon_date_start', '<=', $now)
            ->whereDate('coupon_date_end', '>=', $now)
            ->first();

        if ($coupon) {
            $count_coupon = $coupon->count();
            if ($count_coupon > 0) {
                $coupon_session = Session::get('coupon');
                $cou[] = array(
                    'coupon_code' => $coupon->coupon_code,
                    'coupon_condition' => $coupon->coupon_condition,
                    'coupon_number' => $coupon->coupon_number,
                );
                Session::put('coupon', $cou);

                Session::save();
                $coupon->coupon_time = $coupon->coupon_time - 1;
                $coupon->save();
                return redirect()->back()->with('message', 'Áp dụng mã giảm giá thành công');
            }
        } else {
            return redirect()->back()->with('error', 'Mã giảm giá không đúng hoặc đã hết hạn');
        }
    }
    public function insert_coupon_code(Request $request)
    {
        $this->validate($request, [
            'coupon_code' => ['required', 'max:255', 'unique:tbl_coupon'],
        ]);
        $data = $request->all();
        $coupon = new Coupon();

        $coupon->coupon_name      = $data['coupon_name'];
        $coupon->coupon_number    = $data['coupon_number'];
        $coupon->coupon_time      = $data['coupon_time'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->coupon_code      = $data['coupon_code'];
        $coupon->coupon_date_start      = $data['coupon_date_start'];
        $coupon->coupon_date_end      = $data['coupon_date_end'];


        $coupon->save();
        Session::put('message', 'Thêm mã giảm giá thành công');
        return Redirect::to('/insert-coupon');
    }

    public function insert_coupon()
    {
        return view('admin.coupon.insert_coupon');
    }


    public function list_coupon(Request $request)
    {
        $coupon = Coupon::orderby('coupon_id', 'DESC')->paginate(5);
        return view('admin.coupon.list_coupon', compact('coupon'));
    }

    public function delete_coupon($coupon_id)
    {
        dd(2);
        // $coupon = Coupon::find($coupon_id);
        // $coupon->delete();
        // Session::put('message', 'Xoá mã giảm giá thành công');
        // return Redirect::to('/list-coupon');
    }

    public function unset_coupon($code)
    {
        // dd(2);
        $now =  date("Y-m-d");
        $coupon_id = Coupon::where('coupon_code', $code)->where('coupon_time', '>', 0)
            ->whereDate('coupon_date_start', '<=', $now)
            ->whereDate('coupon_date_end', '>=', $now)
            ->first();
        $coupon = Session::get('coupon');
        // dd($coupon_id->coupon_time);
        if ($coupon == true) {
            Session::forget('coupon');
            $coupon_id->coupon_time = $coupon_id->coupon_time + 1;
            $coupon_id->save();
            return Redirect()->back()->with('message', 'Xoá mã giảm giá thành công');
        }
    }

     public function getFormEdit_coupon($coupon_id){
        $coupon = Coupon::find($coupon_id);
        return view('admin.coupon.edit_coupon', compact('coupon'));

    }

    public function update_coupon(Request $request, $coupon_id){
        $data['coupon_name']    = $request->coupon_name;
        $data['coupon_code']    = $request->coupon_code;
        $data['coupon_time']    = $request->coupon_time;
        $data['coupon_condition']    = $request->coupon_condition;
        $data['coupon_number']   = $request->coupon_number;
        $data['coupon_date_start']   = $request->coupon_date_start;
        $data['coupon_date_end']     = $request->coupon_date_end;
       
        Coupon::where('coupon_id', $coupon_id)->update($data);
        Session::put('message', 'Cập nhập mã giảm giá thành công');
        return redirect('/list-coupon');
    }
}
