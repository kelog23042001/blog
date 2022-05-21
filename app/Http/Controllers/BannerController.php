<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{

    public function unactive_slide($slide_id){
        DB::table('tbl_slider')->where('slider_id',$slide_id)->update(['slider_status'=>1]);
        Session::put('message','Ẩn slider thành công');
        return Redirect :: to('manage-banner');
    }
    public function active_slide($slide_id){
        DB :: table('tbl_slider')->where('slider_id',$slide_id)->update(['slider_status'=>0]);
        Session::put('message','Hiển thị slider thành công');
        return Redirect :: to('manage-banner');
    }

    public function manage_banner(){
        $all_slide = Banner::orderby('slider_id', 'DESC')->get();
        return view('admin.slider.list_slider', compact('all_slide'));
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
            $slider->slider_image = $new_image;                        
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
