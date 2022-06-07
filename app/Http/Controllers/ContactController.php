<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\CategoryPost;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class ContactController extends Controller
{
    public function lien_he(Request $request){
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->where('cate_post_status', "1")->get();
        $contact = Contact::where('info_id', "2")->get();

        //slider
        $slider = Banner::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        $category  = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand_product')->where('brand_status', '1')->orderBy('brand_id','desc')->get();

        $meta_decs = "Liên hệ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "Liên hệ";
        $url_canonical = $request->url();
        return view('user.pages.contact.contact', compact('category', 'brand', 'contact')) ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical)
        ->with('slider', $slider)->with('category_post', $category_post);
    }

    public function information(){
        $contact = Contact::where('info_id', "2")->get();
       // dd($contact);
        return view('admin.information.add_information', compact('contact'));
    }

    public function update_info(Request $request, $info_id){
        $data = $request->all();
        $contact = Contact::find($info_id);
        $contact->info_contact = $data['info_contact'];
        $contact->info_map = $data['info_map'];
        $contact->info_fanpage = $data['info_fanpage'];
        $get_image = $request->file('info_image');

        $path = 'public/uploads/contact/';

        if ($get_image) {
            unlink($path.$contact->info_logo);
            $get_name_image = $get_image->getClientOriginalName(); //tenhinhanh.jpg
            $name_image = current(explode('.', $get_name_image)); //[0] => tenhinhanh . [1] => jpg , lay mang dau tien
            $new_image = $name_image.rand(0, 9999).'.'.$get_image->getClientOriginalExtension(); // random tranh trung hinh anh, getClientOriginalExtension lay duoi mo rong
            $get_image->move($path, $new_image);
            $contact->info_logo = $new_image;
            // DB::table('tbl_product')->insert($data);
            // Session::put('message', 'Thêm sản phẩm thành công');
            // return Redirect::to('/add-product');
        }
        $contact->save();
        return redirect()->back()->with('message', 'Cập nhập thông tin thành công');
    }
    public function save_info(Request $request){
        $data = $request->all();
        $contact = new Contact();
        $contact->info_contact = $data['info_contact'];
        $contact->info_map = $data['info_map'];
        $contact->info_fanpage = $data['info_fanpage'];
        $get_image = $request->file('info_image');

        $path = 'public/uploads/contact/';

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName(); //tenhinhanh.jpg
            $name_image = current(explode('.', $get_name_image)); //[0] => tenhinhanh . [1] => jpg , lay mang dau tien
            $new_image = $name_image.rand(0, 9999).'.'.$get_image->getClientOriginalExtension(); // random tranh trung hinh anh, getClientOriginalExtension lay duoi mo rong
            $get_image->move($path, $new_image);
            $contact->info_logo = $new_image;
            // DB::table('tbl_product')->insert($data);
            // Session::put('message', 'Thêm sản phẩm thành công');
            // return Redirect::to('/add-product');
        }
        $contact->save();
        return redirect()->back()->with('message', 'Cập nhập thông tin thành công');
    }
}
