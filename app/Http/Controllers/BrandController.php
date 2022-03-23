<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function add_brand_product(){
        return view('admin.add_brand_product');
    }
    public function all_brand_product(){

        $all_brand_product = DB::table('tbl_brand_product')->get();
        $manager_brand = view('admin.all_brand_product')->with('all_brand', $all_brand_product);
        return view('admin.all_brand_product', compact('all_brand_product'));
    }
    public function save_brand_product(Request $request){
        $data = array();
        $data['brand_name'] = $request->brand_product_name;
        $data['brand_desc'] = $request->brand_product_desc;
        $data['brand_status'] = $request->brand_product_status;

        DB::table('tbl_brand_product')->insert($data);
        Session::put('message', 'Thêm danh mục sản phẩm thành công');

        return Redirect::to('/add-brand-product');
    }
    public function unactive_brand_product($brandproduct_id){
        DB::table('tbl_brand_product')->where('brand_id',$brandproduct_id)->update(['brand_status' => 1]);
        Session::put('message', 'Kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('/all-brand-product');
    }

    public function active_brand_product($brandproduct_id){
        DB::table('tbl_brand_product')->where('brand_id',$brandproduct_id)->update(['brand_status' => 0]);
        Session::put('message', 'Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('/all-brand-product');
    }

    public function edit_brand_product($brandproduct_id){
        $edit_brand_product = DB::table('tbl_brand_product')->where('brand_id', $brandproduct_id)->get();
        return view('admin.edit_brand_product', compact('edit_brand_product'));
    }

    public function delete_brand_product($brandproduct_id){
        DB::table('tbl_brand_product')->where('brand_id',$brandproduct_id)->delete();
        Session::put('message', 'Xoá danh mục sản phẩm thành công');
        return Redirect::to('/all-brand-product');
    }

    public function update_brand_product(Request $request,$brandproduct_id){
        $data = array();
        $data['brand_name'] = $request->brand_product_name;
        $data['brand_desc'] = $request->brand_product_desc;

        DB::table('tbl_brand_product')->where('brand_id',$brandproduct_id)->update($data);
        Session::put('message', 'Cập nhập thành công');
        return Redirect::to('/all-brand-product');
    }

    //End funcion admin pages

    public function show_brand_home($brand_id){
        $category  = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();

        $brand_name = DB::table('tbl_brand_product')->where('tbl_brand_product.brand_id', $brand_id)->limit(1)->get();

        $brand_by_id = DB::table('tbl_product')
        ->join('tbl_brand_product', 'tbl_product.brand_id', '=', 'tbl_brand_product.brand_id')
        ->where('tbl_brand_product.brand_id', $brand_id)
        ->get();
        return view('user.pages.brand.show_brand', compact('category', 'brand', 'brand_by_id', 'brand_name'));
    }
}
