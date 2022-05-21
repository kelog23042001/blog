<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Banner;
class BannerController extends Controller
{
    public function manage_banner(){
        // $all_slide = Banner::orderby('slider_id', 'DESC');
        $all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->join('tbl_color_product','tbl_color_product.color_id','=','tbl_product.color_id')
        ->join('tbl_size_product','tbl_size_product.size_id','=','tbl_product.size_id')
        ->get();
        return view('ardmin.slider.all_product', compact('all_poduct'));
    }

    public function add_banner(){
        return view('admin.slider.add_slider');
    }

    public function insert_slider(Request $request){
        $data = $request->all();
        $get_image= $request->file('slide_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'. $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/slider',$new_image);

            $slider = new Banner();
            $slider->slider_name = $data['slider_name'];
            $slider->slider_image = $name_image;                        
            $slider->slider_status =$data['slider_status'];
            $slider->slider_desc = $data['slider_desc'];
            $slider->save();

            Session :: put('message','Thêm slide thành công');
            return Redirect :: to('add-banner');
        }else{
            Session::put('message', 'Chưa chọn hình ảnh');
            return Redirect::to('add-banner');
        }

    }
}
