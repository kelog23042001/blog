<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
class PostController extends Controller
{
    public function add_post(){
        $cate_post = CategoryPost::orderby('cate_post_id', 'DESC')->get();
        return view('admin.post.add_post', compact('cate_post'));
    }

    public function all_product(){
        $all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->paginate(5);
        return view('admin.product.all_product', compact('all_product'));
    }

    // public function save_product(Request $request){
    //     $this->validate($request,[
    //         'product_name' => ['required','max:255', 'unique:tbl_product'],
    //     ]);
    //     $data = array();
    //     $data['product_name']    = $request->product_name;
    //     $data['product_quantity']= $request->product_quantity;
    //     $data['product_slug']    = $request->product_slug;
    //     $data['product_desc']    = $request->product_desc;
    //     $data['product_price']   = $request->product_price;
    //     $data['category_id']     = $request->product_cate;
    //     $data['brand_id']        = $request->product_brand;
    //     $data['product_status']  = $request->product_status;

    //     $get_image = $request->file('product_image');
    //     if($get_image){
    //         $get_name_image = $get_image->getClientOriginalName(); //tenhinhanh.jpg
    //         $name_image = current(explode('.',$get_name_image)); //[0] => tenhinhanh . [1] => jpg , lay mang dau tien
    //         $new_image = $name_image.rand(0,9999).'.'. $get_image->getClientOriginalExtension(); // random tranh trung hinh anh, getClientOriginalExtension lay duoi mo rong
    //         $get_image->move('public/uploads/product', $new_image);
    //         $data['product_image'] = $new_image;
    //         DB::table('tbl_product')->insert($data);
    //         Session::put('message', 'Thêm sản phẩm thành công');

    //         return Redirect::to('/add-product');
    //     }
    //     $data['product_image'] = '';
    //     DB::table('tbl_product')->insert($data);
    //     Session::put('message', 'Thêm sản phẩm thành công');

    //     return Redirect::to('/all-product');
    // }

    // public function unactive_product($product_id){
    //     DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status' => 1]);
    //     return Redirect::to('/all-product');
    // }

    // public function active_product($product_id){
    //     DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status' => 0]);
    //     return Redirect::to('/all-product');
    // }

    // public function edit_product($product_id){
    //     $cate_product = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
    //     $brand_product = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();

    //     $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();
    //     return view('admin.product.edit_product', compact('edit_product', 'cate_product', 'brand_product'));
    // }

    // public function delete_product($product_id){
    //     DB::table('tbl_product')->where('product_id',$product_id)->delete();
    //     Session::put('message', 'Xoá danh mục sản phẩm thành công');
    //     return Redirect::to('/all-product');
    // }

    // public function update_product(Request $request,$product_id){
    //     $data = array();
    //     $data['product_name']    = $request->product_name;
    //     $data['product_quantity']    = $request->product_quantity;
    //     $data['product_slug']    = $request->product_slug;
    //     $data['product_desc']    = $request->product_desc;
    //     $data['product_price']   = $request->product_price;
    //     $data['category_id']     = $request->product_cate;
    //     $data['brand_id']        = $request->product_brand;
    //     $data['product_status']  = $request->product_status;

    //     $get_image = $request->file('product_image');
    //     if($get_image){
    //         $get_name_image = $get_image->getClientOriginalName(); //tenhinhanh.jpg
    //         $name_image = current(explode('.',$get_name_image)); //[0] => tenhinhanh . [1] => jpg , lay mang dau tien
    //         $new_image = $name_image.rand(0,9999).'.'. $get_image->getClientOriginalExtension(); // random tranh trung hinh anh, getClientOriginalExtension lay duoi mo rong
    //         $get_image->move('public/uploads/product', $new_image);
    //         $data['product_image'] = $new_image;
    //         DB::table('tbl_product')->where('product_id', $product_id)->update($data);
    //         Session::put('message', 'Cập nhập sản phẩm thành công');
    //         return Redirect::to('/all-product');
    //     }

    //     DB::table('tbl_product')->where('product_id',$product_id)->update($data);
    //     Session::put('message', 'Cập nhập sản phẩm thành công');
    //     return Redirect::to('/all-product');
    // }
    // //end admin page

}
