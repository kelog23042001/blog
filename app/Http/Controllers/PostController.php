<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function add_post()
    {
        $cate_post = CategoryPost::orderby('cate_post_id', 'DESC')->get();
        return view('admin.post.add_post', compact('cate_post'));
    }

    public function all_post()
    {
        $all_post = Post::orderby('post_id', 'DESC')
            ->join('tbl_category_post', 'tbl_category_post.cate_post_id', '=', 'tbl_posts.cate_post_id')
            ->paginate(5);
        return view('admin.post.list_post', compact('all_post'));
    }

    public function save_post(Request $request)
    {
        // $this->validate($request,[
        //     'post_name' => ['required','max:255', 'unique:tbl_post'],
        // ]);
        // $data = array();
        $data = $request->all();
        $post = new Post();
        $post->post_title = $data['post_title'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->post_status = $data['post_status'];
        $post->post_meta_keywords = $data['post_meta_keywords'];
        $post->post_slug = $data['post_slug'];
        $post->cate_post_id = $data['cate_post_id'];

        $get_image = $request->file('post_image');

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName(); //tenhinhanh.jpg
            $name_image = current(explode('.', $get_name_image)); //[0] => tenhinhanh . [1] => jpg , lay mang dau tien
            $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension(); // random tranh trung hinh anh, getClientOriginalExtension lay duoi mo rong
            $get_image->move('public/uploads/post', $new_image);
            $post->post_image = $new_image;

            $post->save();
            Session::put('message', 'Thêm bài viết thành công');

            return redirect()->back();
        } else {
            Session::put('message', 'Làm ơn thêm hình ảnh');

            return redirect()->back();
        }
    }
    public function delete_post($post_id)
    {
        $post = Post::find($post_id);
        $post_image = $post->post_image;
        if ($post_image) {
            $path = 'public/uploads/post/' . $post_image;
            unlink($path);
        } else {
            $post->delete();
        }
        Session::put('message', 'Xoá bài viết thành công');
        return redirect('/all-post');
    }


    public function edit_post($post_id)
    {

        $post = Post::find($post_id);
        $cate_post = CategoryPost::orderby('cate_post_id', 'DESC')->get();

        return view('admin.post.edit_post', compact('post', 'cate_post'));
    }
    public function update_post(Request $request, $post_id)
    {
        $post = Post::find($post_id);
        $data = $request->all();
        $post->post_title = $data['post_title'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->post_status = $data['post_status'];
        $post->post_meta_keywords = $data['post_meta_keywords'];
        $post->post_slug = $data['post_slug'];
        $post->cate_post_id = $data['cate_post_id'];

        $get_image = $request->file('post_image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName(); //tenhinhanh.jpg
            $name_image = current(explode('.', $get_name_image)); //[0] => tenhinhanh . [1] => jpg , lay mang dau tien
            $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension(); // random tranh trung hinh anh, getClientOriginalExtension lay duoi mo rong
            $get_image->move('public/uploads/post', $new_image);
            $post->post_image = $new_image;

            $post->save();
            Session::put('message', 'Cập nhập bài viết thành công');
            return redirect('/all-post');
        }
        $post->save();
        Session::put('message', 'Cập nhập bài viết thành công');
        return redirect('/all-post');
    }

    public function danh_muc_bai_viet($post_slug, Request $request)
    {
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->where('cate_post_status', '1')->paginate(5);
        $cate_post = CategoryPost::where('cate_post_slug', $post_slug)->take(1)->get();
        foreach ($cate_post as $key => $cate) {
            $meta_decs = $cate->cate_post_desc;
            $meta_title = $cate->cate_post_name;
            $meta_keyword = $cate->cate_post_slug;
            $cate_id = $cate->cate_post_id;
            $url_canonical = $request->url();
        }
        $slider = Banner::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

        $post = Post::with('cate_post')->where('post_status', 1)->where('cate_post_id', $cate_id)->paginate(5);
        $category = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand = DB::table('tbl_brand_product')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        return view('user.pages.post.danhmucbaiviet', compact(
            'slider',
            'meta_decs',
            'meta_title',
            'meta_keyword',
            'url_canonical',
            'category',
            'category_post',
            'brand',
            'post'
        ));
    }


    public function bai_viet($post_slug, Request $request)
    {
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->paginate(5);
        $post = Post::with('cate_post')->where('post_status', 1)->where('post_slug', $post_slug)->take(1)->get();

        foreach ($post as $key => $cate) {
            $meta_decs = $cate->post_desc;
            $meta_title = $cate->post_title;
            $meta_keyword = $cate->meta_post_keywords;
            $cate_id = $cate->cate_post_id;
            $cate_post_id = $cate->cate_post_id;

            $url_canonical = $request->url();
        }
        $slider = Banner::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        $related = Post::with('cate_post')->where('post_status', 1)->where('cate_post_id', $cate_post_id)->whereNotIn(
            'post_slug',
            [$post_slug]
        )->take(5)->get();
        $category = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand = DB::table('tbl_brand_product')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        return view('user.pages.post.baiviet', compact(
            'slider',
            'meta_decs',
            'meta_title',
            'meta_keyword',
            'url_canonical',
            'category',
            'category_post',
            'brand',
            'post',
            'related'
        ));
    }
}
