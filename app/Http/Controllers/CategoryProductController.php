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
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Exception;

class CategoryProductController extends Controller
{
    public function add_category_product()
    {
        $category = CategoryProductModel::orderby('category_id', 'DESC')->get();
        return view('admin.category.add_category_product', compact('category'));
    }

    public function all_category_product()
    {
        $category_product = CategoryProductModel::orderby('category_id', 'DESC')->get();
        $all_category_product = DB::table('tbl_category_product')->get();
        return view('admin.category.all_category_product', compact('all_category_product', 'category_product'));
    }
    public function validation($request)
    {
        return $this->validate($request, [
            'category_name' => 'required', 'max:255',
            // 'category_product_desc' => 'required|max:255',
            // 'category_product_keywords' => 'required|email|max:255',
        ]);
    }
    public function save_category_product(Request $request)
    {
        // dd($request['thumbnail']);
        $this->validation($request);

        $data = array();
        $uploadedFileUrl = Cloudinary::upload($request->file('thumbnail')->getRealPath(), [
            'folder' => 'Category',
        ])->getSecurePath();
        $data['thumbnail'] = $uploadedFileUrl;
        $data['category_name'] = $request->category_name;
        $data['meta_keywords'] = $request->category_product_keywords;
        $data['category_desc'] = $request->category_product_desc;
        $data['slug_category_product'] = $request->category_product_slug;
        $data['category_status'] = 1;

        DB::table('tbl_category_product')->insert($data);
        Session::put('message', 'Thêm danh mục sản phẩm thành công');

        return back();
    }

    public function unactive_category_product($categoryproduct_id)
    {
        DB::table('tbl_category_product')->where('category_id', $categoryproduct_id)->update(['category_status' => 0]);
        Session::put('message', 'Kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }

    public function active_category_product($categoryproduct_id)
    {
        DB::table('tbl_category_product')->where('category_id', $categoryproduct_id)->update(['category_status' => 1]);
        Session::put('message', 'Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }

    public function edit_category_product($categoryproduct_id)
    {
        // dd($categoryproduct_id);

        $category = CategoryProductModel::where('category_id', $categoryproduct_id)->first();
        return view('admin.category.edit_category_product', compact('category'));
    }

    public function delete_category_product($categoryproduct_id)
    {
        DB::table('tbl_category_product')->where('category_id', $categoryproduct_id)->delete();
        Session::put('message', 'Xoá danh mục sản phẩm thành công');
        return Redirect::to('/all-category-product');
    }

    public function update_category_product(Request $request, $categoryproduct_id)
    {
        $data = array();

        if ($request->file('thumbnail')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('thumbnail')->getRealPath(), [
                'folder' => 'Category',
            ])->getSecurePath();
            $data['thumbnail'] = $uploadedFileUrl;
        }
        $data['category_name'] = $request->category_product_name;
        $data['meta_keywords'] = $request->category_product_keywords;
        $data['category_desc'] = $request->category_product_desc;
        $data['slug_category_product'] = $request->category_product_slug;
        CategoryProductModel::where('category_id', $categoryproduct_id)->update($data);
        Session::put('message', 'Cập nhập thành công');
        return Redirect::to('/all-category-product');
    }

    //End function Admin Page

    public function show_category_home($category_id, Request $request)
    {
        // dd($request->all());
        $category_post = CategoryPost::orderby('cate_post_name', 'DESC')->where('cate_post_status', '1')->get();
        $meta_decs = "Danh mục mô hình";
        $meta_title = "LK - Shopping";
        $meta_keyword = "danh mục mô hình";
        $url_canonical = $request->url();
        // get all category
        $categories  = CategoryProductModel::where('category_status', 1)->orderBy('category_name', 'asc')->get();
        $category = CategoryProductModel::find($category_id);
        // get category by id 
        // dd($products);
        // $products = $category->products;
        $products = Product::with('category')->where('category_id', $category_id)->paginate(6);
        $sort_by = null;
        $minRange = null;
        $maxRange = null;
        if (isset($_GET['sort_by'])) {
            $sort_by = $_GET['sort_by'];
            if ($sort_by == 'gia_giam_dan') {
                $products = Product::with('category')
                    ->where('category_id', $category_id)->orderby('product_price', 'DESC')->paginate(6)->appends(request()->query());
            } else if ($sort_by == 'gia_tang_dan') {
                $products = Product::with('category')->where('category_id', $category_id)->orderby(
                    'product_price',
                    'ASC'
                )->paginate(6)->appends(request()->query());
            } else if ($sort_by == 'z_a') {
                $products = Product::with('category')->where('category_id', $category_id)->orderby(
                    'product_name',
                    'DESC'
                )->paginate(6)->appends(request()->query());
            } else if ($sort_by == 'a_z') {
                $products = Product::with('category')->where('category_id', $category_id)->orderby(
                    'product_name',
                    'ASC'
                )->paginate(6)->appends(request()->query());
            }
        } elseif (isset($_GET['price-min']) && isset($_GET['price-max'])) {
            $minRange = $_GET['price-min'] * 1000;
            $maxRange = $_GET['price-max'] * 1000;
            $products = Product::with('category')->where('category_id', $category_id)->whereBetween('product_price', [$minRange, $maxRange])->orderby(
                'product_price',
                'ASC'
            )->paginate(9)->appends(request()->query());
        } elseif (isset($_GET['cate'])) {
            $category_filter = $_GET['cate'];
            $category_arr = explode(",", $category_filter);
            $products = Product::with('category')->whereIn('category_id', $category_arr)->orderby(
                'product_price',
                'ASC'
            )->paginate(12)->appends(request()->query());
        } else {
            $products = Product::with('category')->where('category_id', $category_id)->orderby(
                'product_id',
                'DESC'
            )->paginate(6);
        }
        // dd($products);
        $meta_decs = $category->category_desc;
        $meta_title = $category->category_name;
        $meta_keyword = $category->meta_keywords;
        $url_canonical = $request->url();
        return view('user.pages.category.show_category', compact('minRange', 'maxRange', 'sort_by', 'category', 'categories', 'products', 'category_post'))
            ->with('meta_decs', $meta_decs)
            ->with('meta_title', $meta_title)
            ->with('meta_keyword', $meta_keyword)
            ->with('url_canonical', $url_canonical);
    }
}
