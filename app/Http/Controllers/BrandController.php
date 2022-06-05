<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryPost;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function validation($request){
        return $this->validate($request,[
            'brand_name' => 'required','max:255',
            'brand_product_desc' => 'required|max:255',

        ]);
    }
    public function add_brand_product(){
        return view('admin.brand.add_brand_product');
    }
    public function all_brand_product(){
       // $all_brand_product = DB::table('tbl_brand_product')->get();
        $all_brand_product= Brand::orderBy('brand_id','DESC')->paginate(5);
        $manager_brand = view('admin.brand.all_brand_product')->with('all_brand', $all_brand_product);
        return view('admin.brand.all_brand_product', compact('all_brand_product'));
    }
    public function save_brand_product(Request $request){
        $this->validate($request,[
            'brand_name' => ['required','max:255', 'unique:tbl_brand_product'],
        ]);
        $data = $request->all();
        $brand = new Brand();
        $brand->brand_name = $data['brand_name'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->brand_slug = $data['brand_product_slug'];
        $brand->brand_status = $data['brand_product_status'];
        $brand->save();
        // $data = array();
        // $data['brand_name'] = $request->brand_product_name;
        // $data['brand_desc'] = $request->brand_product_desc;
        // $data['brand_status'] = $request->brand_product_status;

        // DB::table('tbl_brand_product')->insert($data);
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
        //$edit_brand_product = DB::table('tbl_brand_product')->where('brand_id', $brandproduct_id)->get();
        $edit_brand_product = Brand::where('brand_id', $brandproduct_id)->get();
        return view('admin.brand.edit_brand_product', compact('edit_brand_product'));
    }

    public function delete_brand_product($brandproduct_id){
        DB::table('tbl_brand_product')->where('brand_id',$brandproduct_id)->delete();
        Session::put('message', 'Xoá danh mục sản phẩm thành công');
        return Redirect::to('/all-brand-product');
    }

    public function update_brand_product(Request $request,$brandproduct_id){
        $data = $request->all();

        $brand = Brand::find($brandproduct_id);
        $brand->brand_name = $data['brand_name'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->brand_slug = $data['brand_product_slug'];
        $brand->save();
        // $data = array();
        // $data['brand_name'] = $request->brand_product_name;
        // $data['brand_desc'] = $request->brand_product_desc;
        // $data['brand_desc'] = $request->brand_product_slug;

        // DB::table('tbl_brand_product')->where('brand_id',$brandproduct_id)->update($data);
        Session::put('message', 'Cập nhập thành công');
        return Redirect::to('/all-brand-product');
    }

    //End funcion admin pages

    public function show_brand_home($brand_id, Request $request){
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->paginate(5);

        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $category  = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_id','desc')->get();
        $brand =    DB::table('tbl_brand_product')->where('brand_status', '1')->orderBy('brand_id','desc')->get();

   

        $brand_name = DB::table('tbl_brand_product')->where('tbl_brand_product.brand_id', $brand_id)->limit(1)->get();
        $brand_by_id = DB::table('tbl_product')
        ->join('tbl_brand_product', 'tbl_product.brand_id', '=', 'tbl_brand_product.brand_id')
        ->where('tbl_brand_product.brand_id', $brand_id)
        ->paginate(3);
        // if(isset($_GET['brand'])){
        //     $brand_id = $_GET['brand'];
        //     $brand_arr = explode(",", $brand_id);
        //     $brand_by_id = DB::table('tbl_product')
        //     ->join('tbl_brand_product', 'tbl_product.brand_id', '=', 'tbl_brand_product.brand_id')
        //     ->where('tbl_brand_product.brand_id', $brand_id)
        //     ->paginate(12)->appends(request()->query());
        // }else{

        // }
        return view('user.pages.brand.show_brand', compact('category', 'brand', 'brand_by_id', 'brand_name', 'category_post'))
        ->with('meta_decs',$meta_decs)->with('meta_title',$meta_title)->with('meta_keyword',$meta_keyword)->with('url_canonical', $url_canonical);
    }
}
