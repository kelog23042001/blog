<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
session_start();
class ProductController extends Controller
{
    public function add_product(){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        $color_product = DB::table('tbl_color_product')->orderBy('color_id','desc')->get();
        $size_product = DB::table('tbl_size_product')->orderBy('size_id','desc')->get();
        return view('admin.add_product', compact('cate_product', 'brand_product','color_product','size_product'));

    }

    public function all_product(){
        $all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->join('tbl_color_product','tbl_color_product.color_id','=','tbl_product.color_id')
        ->join('tbl_size_product','tbl_size_product.size_id','=','tbl_product.size_id')
        ->get();
        return view('admin.all_product', compact('all_product'));
    }

    public function save_product(Request $request){
        $data = array();
        $data['product_name']    = $request->product_name;
        $data['product_desc']    = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['product_price']   = $request->product_price;
        $data['category_id']     = $request->product_cate;
        $data['brand_id']        = $request->product_brand;
        $data['color_id']        = $request->product_color;
        $data['size_id']        = $request->product_size;
        $data['product_status']  = $request->product_status;

        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName(); //tenhinhanh.jpg
            $name_image = current(explode('.',$get_name_image)); //[0] => tenhinhanh . [1] => jpg , lay mang dau tien
            $new_image = $name_image.rand(0,9999).'.'. $get_image->getClientOriginalExtension(); // random tranh trung hinh anh, getClientOriginalExtension lay duoi mo rong
            $get_image->move('/uploads/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->insert($data);
            Session::put('message', 'Thêm sản phẩm thành công');

            return Redirect::to('/add-product');
        }
        $data['product_image'] = '';
        DB::table('tbl_product')->insert($data);
        Session::put('message', 'Thêm sản phẩm thành công');

        return Redirect::to('/all-product');
    }

    public function unactive_product($product_id){
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status' => 1]);
        return Redirect::to('/all-product');
    }

    public function active_product($product_id){
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status' => 0]);
        return Redirect::to('/all-product');
    }

    public function edit_product($product_id){
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        $color_product = DB::table('tbl_color_product')->orderBy('color_id','desc')->get();
        $size_product = DB::table('tbl_size_product')->orderBy('size_id','desc')->get();

        $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();
        return view('admin.edit_product', compact('edit_product', 'cate_product', 'brand_product', 'color_product', 'size_product'));
    }

    public function delete_product($product_id){
        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('message', 'Xoá danh mục sản phẩm thành công');
        return Redirect::to('/all-product');
    }

    public function update_product(Request $request,$product_id){
        $data = array();
        $data['product_name']    = $request->product_name;
        $data['product_desc']    = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['product_price']   = $request->product_price;
        $data['category_id']     = $request->product_cate;
        $data['brand_id']        = $request->product_brand;
        $data['color_id']        = $request->product_color;
        $data['size_id']         = $request->product_size;
        $data['product_status']  = $request->product_status;

        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName(); //tenhinhanh.jpg
            $name_image = current(explode('.',$get_name_image)); //[0] => tenhinhanh . [1] => jpg , lay mang dau tien
            $new_image = $name_image.rand(0,9999).'.'. $get_image->getClientOriginalExtension(); // random tranh trung hinh anh, getClientOriginalExtension lay duoi mo rong
            $get_image->move('/uploads/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            Session::put('message', 'Cập nhập sản phẩm thành công');
            return Redirect::to('/all-product');
        }

        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Session::put('message', 'Cập nhập sản phẩm thành công');
        return Redirect::to('/all-product');
    }
    //end admin page

    public function details_product($product_id){
        $category = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();

        $detail_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_id', $product_id)
        ->get();

        foreach($detail_product as $key=> $value){
            $category_id = $value->category_id;
        }

        $related_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_id', [$product_id])
        ->get();

        return view('user.pages.product.show_detail', compact('category', 'brand', 'detail_product', 'related_product'));
    }
}
