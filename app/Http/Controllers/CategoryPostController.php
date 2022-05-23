<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryProductModel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
class CategoryPostController extends Controller
{
    public function add_category_product(){
        $category = CategoryProductModel::where('category_parent', 0)->orderby('category_id', 'DESC')->get();

        return view('admin.category.add_category_product', compact('category'));
    }

    // public function all_category_product(){
    //     $category_product = CategoryProductModel::where('category_parent', 0)->orderby('category_id', 'DESC')->get();
    //     $all_category_product = DB::table('tbl_category_product')->orderby('category_parent', 'ASC')->get();
    //     return view('admin.category.all_category_product', compact('all_category_product', 'category_product'));
    // }

    // public function save_category_product(Request $request){
    //     $data = array();
    //     $data['category_name'] = $request->category_product_name;
    //     $data['meta_keywords'] = $request->category_product_keywords;
    //     $data['category_desc'] = $request->category_product_desc;
    //     $data['slug_category_product'] = $request->category_product_slug;
    //     $data['category_status'] = $request->category_product_status;
    //     $data['category_parent'] = $request->category_parent;

    //     DB::table('tbl_category_product')->insert($data);
    //     Session::put('message', 'Thêm danh mục sản phẩm thành công');

    //     return Redirect::to('/add-category-product');
    // }

    // public function unactive_category_product($categoryproduct_id){
    //     DB::table('tbl_category_product')->where('category_id',$categoryproduct_id)->update(['category_status' => 1]);
    //     Session::put('message', 'Kích hoạt danh mục sản phẩm thành công');
    //     return Redirect::to('/all-category-product');
    // }

    // public function active_category_product($categoryproduct_id){
    //     DB::table('tbl_category_product')->where('category_id',$categoryproduct_id)->update(['category_status' => 0]);
    //     Session::put('message', 'Không kích hoạt danh mục sản phẩm thành công');
    //     return Redirect::to('/all-category-product');
    // }

    // public function edit_category_product($categoryproduct_id){
    //     $category = CategoryProductModel::orderby('category_id', 'DESC')->get();
    //     $category_product = CategoryProductModel::where('category_parent', 0)->orderby('category_id', 'DESC')->get();

    //     $edit_category_product = DB::table('tbl_category_product')->where('category_id', $categoryproduct_id)->get();
    //     return view('admin.category.edit_category_product', compact('edit_category_product', 'category', 'category_product'));
    // }

    // public function delete_category_product($categoryproduct_id){
    //     DB::table('tbl_category_product')->where('category_id',$categoryproduct_id)->delete();
    //     Session::put('message', 'Xoá danh mục sản phẩm thành công');
    //     return Redirect::to('/all-category-product');
    // }

    // public function update_category_product(Request $request,$categoryproduct_id){
    //     $data = array();
    //     $data['category_name'] = $request->category_product_name;
    //     $data['meta_keywords'] = $request->category_product_keywords;
    //     $data['category_parent'] = $request->category_parent;

    //     $data['category_desc'] = $request->category_product_desc;
    //     $data['slug_category_product'] = $request->category_product_slug;
    //     DB::table('tbl_category_product')->where('category_id',$categoryproduct_id)->update($data);
    //     Session::put('message', 'Cập nhập thành công');
    //     return Redirect::to('/all-category-product');
    // }
}
