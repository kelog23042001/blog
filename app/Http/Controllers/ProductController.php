<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use App\Models\Comment;
use App\Models\Rate;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\CategoryProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

session_start();
class ProductController extends Controller
{
    public function reply_comment(Request $request)
    {
        $data = $request->all();
        $comment = new Comment();
        $comment->comment = $data['comment'];
        $comment->comment_name = 'Admin';
        $comment->comment_product_id = $data['comment_product_id'];
        $comment->comment_status = 0;
        $comment->comment_parent_comment = $data['comment_id'];
        $comment->save();
    }
    public function allow_comment(Request $request)
    {
        $data = $request->all();
        $comment = Comment::find($data['comment_id']);
        $comment->comment_status = $data['comment_status'];
        $comment->save();
    }
    public function list_comment()
    {
        $comment = Comment::with('product')->where('comment_parent_comment', '=', 0)
            ->orderBy('comment_status', 'desc')->orderBy('comment_date', 'desc')->get();
        $comment_rep = Comment::with('product')->where('comment_parent_comment', '>', 0)->get();

        return view('admin.comment.list_comment', compact('comment', 'comment_rep'));
    }

    public function send_comment(Request$request){
        $product_id = $request->product_id;
        $comment_name = $request->comment_name;
        $comment_content = $request->comment_content;
        $comment=new Comment();
        $comment->comment = $comment_content;
        $comment->comment_name = $comment_name;
        $comment->comment_product_id = $product_id;
        $comment->comment_status = 1;
        $comment->save();
    }

    public function load_comment(Request $request)
    {
        $product_id = $request->product_id;
        $comment = Comment::where('comment_product_id', $product_id)
            ->where('comment_status', '=', 0)
            ->where('comment_parent_comment', 0)
            ->orderBy('comment_id', 'desc')
            ->get();
        $comment_rep = Comment::with('product')->where('comment_parent_comment', '>', 0)->get();

        $output = '';
        foreach ($comment as $key => $comm) {

            $output .= '
            <div class="row style_comment">
                <div class="col-md-2">
                    <img width="50%"src="' . url('frontend/images/product-details/similar3.jpg') . '" class="img img-responsive img-thumbnail">
                </div>
                <div class="col-md-10">
                    <p style="color: black;">' . $comm->comment_date . '</p>
                    <p style="color: green;"> @' . $comm->comment_name . '</p>
                    <p>' . $comm->comment . '</p>
                </div>
            </div><p></p>
            ';
            foreach ($comment_rep as $key => $rep_comment) {
                if ($rep_comment->comment_parent_comment == $comm->comment_id) {
                    $output .= '
                <div class="row style_comment" style="margin:5px 40px">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-10">
                        <p style="color: black;">' .  '</p>
                        <p style="color: green;"> @LKShop</p>
                        <p>' . $rep_comment->comment . '</p>
                    </div>
                </div>
                <p></p>';
                }
            }
        }
        echo $output;
    }
    public function add_product()
    {
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderBy('brand_id', 'desc')->get();
        return view('admin.product.add_product', compact('cate_product', 'brand_product'));
    }

    public function all_product()
    {
        $all_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
            ->paginate(5);
        return view('admin.product.all_product', compact('all_product'));
    }

    public function save_product(Request $request)
    {
        $this->validate($request, [
            'product_name' => ['required', 'max:255', 'unique:tbl_product'],
        ]);
        $data = array();
        $data['product_name']    = $request->product_name;
        $data['product_tags']    = $request->product_tags;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_slug']    = $request->product_slug;
        $data['product_desc']    = $request->product_desc;
        $data['product_price']   = $request->product_price;
        $data['price_cost']   = $request->price_cost;
        $data['category_id']     = $request->product_cate;
        $data['brand_id']        = $request->product_brand;
        $data['product_status']  = $request->product_status;
        $get_image = $request->file('product_image');

        $path_product = 'public/uploads/product/';
        $path_gallery = 'public/uploads/gallery/';

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName(); //tenhinhanh.jpg
            $name_image = current(explode('.', $get_name_image)); //[0] => tenhinhanh . [1] => jpg , lay mang dau tien
            $new_image = $name_image . rand(0, 9999).'.'.$get_image->getClientOriginalExtension(); // random tranh trung hinh anh, getClientOriginalExtension lay duoi mo rong
            $get_image->move($path_product, $new_image);
            File::copy($path_product.$new_image, $path_gallery.$new_image);
            $data['product_image'] = $new_image;
            // DB::table('tbl_product')->insert($data);
            // Session::put('message', 'Thêm sản phẩm thành công');
            // return Redirect::to('/add-product');
        }
        // $data['product_image'] = '';
        $pro_id = DB::table('tbl_product')->insertGetId($data);
        $gallery = new Gallery();

       // Session::put('message', 'Thêm sản phẩm thành công');
        $gallery->gallery_image = $new_image;
        $gallery->gallery_name = $new_image;
        $gallery->product_id = $pro_id;
        $gallery->save();
        return Redirect::to('/all-product');
    }

    public function unactive_product($product_id)
    {
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 1]);
        return Redirect::to('/all-product');
    }

    public function active_product($product_id)
    {
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 0]);
        return Redirect::to('/all-product');
    }

    public function edit_product($product_id)
    {
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderBy('brand_id', 'desc')->get();

        $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();
        return view('admin.product.edit_product', compact('edit_product', 'cate_product', 'brand_product'));
    }

    public function delete_product($product_id)
    {
        // $product = DB::table('tbl_product')->where('product_id',$product_id)->get();
        // $data = array();
        // $product_image = $data['product_image'];
        // if($product_image){
        //     $path = 'public/uploads/product/'.$product_image;
        //     unlink($path);
        // }else{
        //     $product->delete();
        // }
        DB::table('tbl_product')->where('product_id', $product_id)->delete();
        Session::put('message', 'Xoá danh mục sản phẩm thành công');
        return Redirect::to('/all-product');
    }

    public function update_product(Request $request, $product_id)
    {
        $data = array();
        $data['product_name']    = $request->product_name;
        $data['product_tags']    = $request->product_tags;
        $data['product_quantity']    = $request->product_quantity;
        $data['product_slug']    = $request->product_slug;
        $data['product_desc']    = $request->product_desc;
        $data['product_price']   = $request->product_price;
        $data['price_cost']   = $request->price_cost;
        $data['category_id']     = $request->product_cate;
        $data['brand_id']        = $request->product_brand;
        $data['product_status']  = $request->product_status;

        $get_image = $request->file('product_image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName(); //tenhinhanh.jpg
            $name_image = current(explode('.', $get_name_image)); //[0] => tenhinhanh . [1] => jpg , lay mang dau tien
            $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension(); // random tranh trung hinh anh, getClientOriginalExtension lay duoi mo rong
            $get_image->move('public/uploads/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            Session::put('message', 'Cập nhập sản phẩm thành công');
            return Redirect::to('/all-product');
        }

        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message', 'Cập nhập sản phẩm thành công');
        return Redirect::to('/all-product');
    }
    //end admin page

    public function details_product($product_id, Request $request)
    {
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->paginate(5);

        $category = DB::table('tbl_category_product')->where('category_status', '0')->orderBy('category_id', 'desc')->get();
        $brand = DB::table('tbl_brand_product')->where('brand_status', '0')->orderBy('brand_id', 'desc')->get();

        $detail_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_product.product_id', $product_id)
            ->get();

            $rating = Rate::where('product_id', $product_id)->avg('rating');
            $rating = round($rating);
        foreach ($detail_product as $key => $value) {
            $product_id = $value->product_id;
            $category_id = $value->category_id;
            $brand_id = $value->brand_id;
            $product_cate = $value->category_name;
            $product_brand = $value->brand_name;
            $meta_decs = $value->product_desc;
            $meta_title =  $value->product_name;
            $meta_keyword =  $value->product_slug;
            $url_canonical = $request->url();
        }
        $gallery = Gallery::where('product_id', $product_id)->get();
        $related_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_id', [$product_id])->limit(3)
            ->get();

            $product = Product::where('product_id', $product_id)->first();
            $product->product_views = $product->product_views + 1;
            $product->save();

        return view('user.pages.product.show_detail', compact('brand_id', 'product_brand', 'product_cate', 'category', 'rating', 'category_id', 'brand', 'gallery', 'detail_product', 'related_product', 'category_post'))
            ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical);
    }
    public function tag(Request $request, $product_tag)
    {
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->where('cate_post_status', "0")->get();

        $category = CategoryProductModel::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand = DB::table('tbl_brand_product')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        $tag = str_replace("-","",$product_tag);

        $pro_tag = Product::where('product_status', 1)
        ->where('product_name', 'LIKE', '%'.$tag.'%')
        ->orWhere('product_tags', 'LIKE', '%'.$tag.'%')
        ->get();
        $meta_decs = 'Tag: '.$product_tag;
        $meta_title =  'Tag: '.$product_tag;
        $meta_keyword =  'Tag: '.$product_tag;
        $url_canonical = $request->url();
        return view('user.pages.product.tag')
            ->with('category_post', $category_post)
            ->with('category', $category)
            ->with('brand', $brand)
            ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)
            ->with('meta_keyword', $meta_keyword)
            ->with('url_canonical', $url_canonical)
            ->with('product_tag', $product_tag)
            ->with('pro_tag', $pro_tag);
    }

    public function insert_rating(Request $request)
    {
        $data = $request->all();
        $rating = new Rate();
        $rating->product_id = $data['product_id'];
        $rating->rating = $data['index'];
        $rating->save();
        echo 'done';
    }
}
