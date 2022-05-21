<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Banner;

class HomeController extends Controller
{
    // public function send_mail(){

    //    $to_name="Thiatv.com";
    //    $to_email="thiatv1994@gmail.com";
    //    $link_reset_pass=url('/update-new-pass?email='.$to_email.'&token='.$rand_id);
    //    $data=array("name"=>"Thiatv.com","body"=>$link_reset_pass);
    //    Mail::send('admin.reset_pass',$data,function($message) use ($to_name,$to_email){
    //      $message->to($to_email)->subject('Quên mật khẩu Admin Thiatv.com'):
    //      $message->from($to_email,$to_name):
    //    })
    // }
    public function index(Request $request){
        //slider
        $slider = Banner::orderBy('slider_id','DESC')->where('slider_status', '1')->take(4)->get();

        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status', '0')->orderBy('product_id','desc')->limit(9)
        ->get();

        return view('user.pages.home')->with('category', $cate_product)->with('brand', $brand_product)->with('product', $all_product)
        ->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical)
        ->with('slider', $slider);
        //return view('user.pages.home')->with(compact('cate_product', 'brand_product', 'all_product' ));

    }

    public function search(Request $request){
        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $keywords = $request->keywords_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();

         $search_product = DB::table('tbl_product')->where('product_name', 'like', '%'.$keywords.'%')->get();

        return view('user.pages.product.search')->with('category', $cate_product)->with('brand', $brand_product)
        ->with('search_product', $search_product)
        ->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical);
    }
}
