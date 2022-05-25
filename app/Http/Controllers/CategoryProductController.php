<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use App\Models\CategoryProductModel;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
class CategoryProductController extends Controller
{
    public function add_category_product(){

        $category = CategoryProductModel::where('category_parent', 0)->orderby('category_id', 'DESC')->get();

        return view('admin.category.add_category_product', compact('category'));
    }

    public function all_category_product(){
        $category_product = CategoryProductModel::where('category_parent', 0)->orderby('category_id', 'DESC')->get();
        $all_category_product = DB::table('tbl_category_product')->orderby('category_parent', 'ASC')->paginate(5);
        return view('admin.category.all_category_product', compact('all_category_product', 'category_product'));
    }
    public function validation($request){
        return $this->validate($request,[
            'category_name' => 'required','max:255',
            'category_product_desc' => 'required|max:255',
            'category_product_keywords' => 'required|email|max:255',
        ]);
    }
    public function save_category_product(Request $request){

        $this->validate($request,[
            'category_product_desc' =>  ['required','max:255'],
            'category_name' => ['required','max:255', 'unique:tbl_category_product'],
            'category_product_keywords' =>  ['required','max:255'],
        ]);
        $data = array();
        $data['category_name'] = $request->category_name;
        $data['meta_keywords'] = $request->category_product_keywords;
        $data['category_desc'] = $request->category_product_desc;
        $data['slug_category_product'] = $request->category_product_slug;
        $data['category_status'] = $request->category_product_status;
        $data['category_parent'] = $request->category_parent;

        DB::table('tbl_category_product')->insert($data);
        Session::put('message', 'Thêm danh mục sản phẩm thành công');

        return Redirect::to('/add-category-product');
    }

    public function unactive_category_product($categoryproduct_id){
        DB::table('tbl_category_product')->where('category_id',$categoryproduct_id)->update(['category_status' => 1]);
        Session::put('message', 'Kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }

    public function active_category_product($categoryproduct_id){
        DB::table('tbl_category_product')->where('category_id',$categoryproduct_id)->update(['category_status' => 0]);
        Session::put('message', 'Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }

    public function edit_category_product($categoryproduct_id){
        $category = CategoryProductModel::orderby('category_id', 'DESC')->get();
        $category_product = CategoryProductModel::where('category_parent', 0)->orderby('category_id', 'DESC')->get();

        $edit_category_product = DB::table('tbl_category_product')->where('category_id', $categoryproduct_id)->get();
        return view('admin.category.edit_category_product', compact('edit_category_product', 'category', 'category_product'));
    }

    public function delete_category_product($categoryproduct_id){
        DB::table('tbl_category_product')->where('category_id',$categoryproduct_id)->delete();
        Session::put('message', 'Xoá danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }

    public function update_category_product(Request $request,$categoryproduct_id){
        $this->validate($request,[
            'category_name' => ['required','max:255', 'unique:tbl_category_product'],
        ]);
        $data = array();
        $data['category_name'] = $request->category_name;
        $data['meta_keywords'] = $request->category_product_keywords;
        $data['category_parent'] = $request->category_parent;

        $data['category_desc'] = $request->category_product_desc;
        $data['slug_category_product'] = $request->category_product_slug;
        DB::table('tbl_category_product')->where('category_id',$categoryproduct_id)->update($data);
        Session::put('message', 'Cập nhập thành công');
        return Redirect::to('/all-category-product');
    }

     //End function Admin Page

    public function show_category_home($category_id, Request $request){
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->paginate(5);

        $meta_decs = "Danh mục mô hình";
        $meta_title = "LK - Shopping";
        $meta_keyword = "danh mục mô hình";
        $url_canonical = $request->url();
        $category  = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id','desc')->get();

        $category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id', $category_id)->limit(1)->get();
        $category_id_cate = CategoryProductModel::where('category_id', $category_id)->get();
        // $category_by_id = DB::table('tbl_product')
        // ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
        // ->where('tbl_category_product.category_id', $category_id)
        // ->paginate(6);
        foreach($category_id_cate as $key => $cate){
            $category_id = $cate->category_id;
        }
        if(isset($_GET['sort_by'])){
            $sort_by = $_GET['sort_by'];
            if($sort_by == 'giam_dan'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderby('product_price',
                'DESC')->paginate(6)->appends(request()->query());
            }else if($sort_by == 'tang_dan'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderby('product_price',
                'ASC')->paginate(6)->appends(request()->query());
            }else if($sort_by == 'kytu_za'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderby('product_name',
                'DESC')->paginate(6)->appends(request()->query());
            }else if($sort_by == 'kytu_az'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderby('product_name',
                'ASC')->paginate(6)->appends(request()->query());
            }
        }else{
            $category_by_id = Product::with('category')->where('category_id',$category_id)->orderby('product_id',
            'DESC')->paginate(6);
        }
            foreach($category_name as $key => $value){
                $meta_decs = $value->category_desc;
                $meta_title = $value->category_name;
                $meta_keyword = $value->meta_keywords;
                $url_canonical = $request->url();
            }


        return view('user.pages.category.show_category', compact('category', 'brand', 'category_by_id', 'category_name', 'category_post'))
        ->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical);
    }
}

