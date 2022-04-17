<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
class HomeController extends Controller
{
    public function index(){
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status', '0')->orderBy('product_id','desc')->limit(9)
        ->get();

        return view('user.pages.home')->with('category', $cate_product)->with('brand', $brand_product)->with('product', $all_product);
    }
}
