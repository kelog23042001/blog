<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use App\Models\CategoryProductModel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
class CategoryPostController extends Controller
{
    public function add_category_post(){

        return view('admin.category_post.add_category');
    }

    public function all_category_post(){

        $all_category_post = CategoryPost::orderby('cate_post_id', 'DESC')->paginate(5);
        return view('admin.category_post.list_category', compact('all_category_post'));
    }

    public function save_category_post(Request $request){
        $data = array();
        $data= $request->all();
        $category_post = new CategoryPost();
        $category_post->cate_post_name = $data['cate_post_name'];
        $category_post->cate_post_slug =$data['cate_post_slug'];
        $category_post->cate_post_desc =$data['cate_post_desc'];
        $category_post->cate_post_status =$data['cate_post_status'] ;

        $category_post->save();

        return redirect()->back()->with('message', 'Thêm danh mục bài viết thành công');
    }
    public function danh_muc_bai_viet($cate_post_slug){

    }
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
