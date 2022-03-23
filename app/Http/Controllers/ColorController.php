<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ColorController extends Controller
{
    public function add_color_product(){
        return view('admin.add_color_product');
    }
    public function all_color_product(){

        $all_color_product =DB::table('tbl_color_product')->get();
        $manager_color = view('admin.all_color_product')->with('all_color', $all_color_product);
        return view('admin.all_color_product', compact('all_color_product'));
    }
    public function save_color_product(Request $request){
        $data = array();
        $data['color_name'] = $request->color_product_name;
        $data['color_desc'] = $request->color_product_desc;
        $data['color_status'] = $request->color_product_status;

        DB::table('tbl_color_product')->insert($data);
        Session::put('message', 'Thêm danh mục sản phẩm thành công');

        return Redirect::to('/add-color-product');
    }
    public function unactive_color_product($colorproduct_id){
        DB::table('tbl_color_product')->where('color_id',$colorproduct_id)->update(['color_status' => 1]);
        Session::put('message', 'Kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('/all-color-product');
    }

    public function active_color_product($colorproduct_id){
        DB::table('tbl_color_product')->where('color_id',$colorproduct_id)->update(['color_status' => 0]);
        Session::put('message', 'Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('/all-color-product');
    }

    public function edit_color_product($colorproduct_id){
        $edit_color_product = DB::table('tbl_color_product')->where('color_id', $colorproduct_id)->get();
        return view('admin.edit_color_product', compact('edit_color_product'));
    }

    public function delete_color_product($colorproduct_id){
        DB::table('tbl_color_product')->where('color_id',$colorproduct_id)->delete();
        Session::put('message', 'Xoá danh mục sản phẩm thành công');
        return Redirect::to('/all-color-product');
    }

    public function update_color_product(Request $request,$colorproduct_id){
        $data = array();
        $data['color_name'] = $request->color_product_name;
        $data['color_desc'] = $request->color_product_desc;

        DB::table('tbl_color_product')->where('color_id',$colorproduct_id)->update($data);
        Session::put('message', 'Cập nhập thành công');
        return Redirect::to('/all-color-product');
    }
      // End function Admin page
    // public function show_brand_home($color_id){
    //     $cate_product  = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
    //     $brand_product = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();
    //     $color_product = DB::table('tbl_color_product')->where('color_status', '0')->orderBy('color_id','desc')->get();
    //     $size_product  = DB::table('tbl_size_product')->where('size_status', '0')->orderBy('size_id','desc')->get();

    //     $color_by_id = DB::table('tbl_product')
    //     ->join('tbl_color_product','tbl_product.color_id','=','tbl_color_product.color_id')->where('tbl_product.color_id',$color_id)->get();

    //     return view('pages.color.show_color', compact('cate_product', 'brand_product', 'color_product', 'size_category','color_by_id'));
    // }
}
