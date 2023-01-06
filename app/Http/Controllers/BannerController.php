<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Gallery;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{

    public function unactive_slide($slide_id)
    {
        Banner::where('slider_id', $slide_id)->update(['slider_status' => 0]);
        Session::put('message', 'Ẩn slider thành công');
        return redirect('/manage-banner');
    }
    public function active_slide($slide_id)
    {
        Banner::where('slider_id', $slide_id)->update(['slider_status' => 1]);
        Session::put('message', 'Hiển thị slider thành công');
        return redirect('/manage-banner');
    }

    public function manage_banner()
    {
        $all_slide = Banner::orderby('slider_id', 'DESC')->where('slider_status', 1)->get();
        return view('admin.slider.list_slider', compact('all_slide'));
    }

    public function add_banner()
    {
        return view('admin.slider.add_slider');
    }

    public function insert_slider(Request $request)
    {
        $data = $request->all();
        $data['slider_name']    = $request->slider_name;
        $data['slider_desc']    = $request->slider_desc;
        $data['slider_status']  = $request->slider_status;

        //dd($data);
        $thumbnailUrl = Cloudinary::upload($request['slide_image']->getRealPath(), [
            'folder' => 'Products',
        ])->getSecurePath();

        $data['slider_image'] = $thumbnailUrl;
        $banner = new Banner();
        $banner->slider_name =  $data['slider_name'];
        $banner->slider_desc =  $data['slider_desc'];
        $banner->slider_status =  $data['slider_status'];
        $banner->slider_image =  $data['slider_image'];
        $banner->save();

        return redirect('/manage-banner');
        // dd($product->insertGetId($data));

        // foreach ($request->file('product_image') as $key => $file) {
        //     $uploadedImages = Cloudinary::upload($file->getRealPath(), [
        //         'folder' => 'Products',
        //     ])->getSecurePath();

        //     // $image = new Gallery();
        //     // $image::create([
        //     //     'imageUrl' => $uploadedImages,
        //     //     'slider_id' => $newBanner,
        //     // ]);
        //     // dd($image);
        // }

    }


    public function getFormSlider($slider_id)
    {
        $slider = Banner::where('slider_id', $slider_id)->first();


        return view('admin.slider.edit_slider', compact('slider'));
    }

    public function update_slider(Request $request, $slider_id)
    {
        $data = array();

        $data['slider_name']    = $request->slider_name;
        $data['slider_desc']    = $request->slider_desc;
        $data['slider_status']    = $request->slider_status;

        if ($request->file('slider_image')) {
            $uploadedImages = Cloudinary::upload($request->file('slider_image')->getRealPath(), [
                'folder' => 'Products',
            ])->getSecurePath();
            $data['slider_image'] = $uploadedImages;
        }

        Banner::where('slider_id', $slider_id)->update($data);
        Session::put('message', 'Cập nhập sản phẩm thành công');

        return redirect('/manage-banner');
    }

    public function delete_slider($slider_id)
    {
    }
}
