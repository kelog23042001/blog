<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GalleryController extends Controller
{

    public function add_gallery($product_id){
        $pro_id = $product_id;
       return view('admin.gallery.add_gallery', compact('pro_id'));
    }

    public function select_gallery(Request $request){
        $pro_id = $request->pro_id;
        $gallery = Gallery::where('product_id', $pro_id)->get();
        $gallery_count = $gallery->count();
        $output = '';
        $output = '<table class="table">
                        <thead>
                        <tr>
                            <th>Thứ tự</th>
                            <th>Tên hình ảnh</th>
                            <th>Hình ảnh</th>
                            <th>Quản lý</th>
                        </tr>
                        </thead>
                        <tbody>';
        if($gallery_count > 0){
            $i = 0;
            foreach($gallery as $key => $gal){
                $i++;
                $output.='
                <tr>
                <td>'.$i.'</td>
                <td contenteditable class = "edit_gal_name" data-gal_id="'.$gal->gallery_id.'">'.$gal->gallery_name.'</td>
                <td style =  "width: 500px;">
                    <img width = "20%" height = "120px" src = "'.url('public/uploads/gallery/'.$gal->gallery_image).'" class = "img-thumbnail"><br>
                    <input type ="file" class = "file_image" style ="width: 40%" data-gal_id="'.$gal->gallery_id.'" id = "file-'.$gal->gallery_id.'" name="file" accpect="image/*" />
                </td>


                <td>
                    <button type ="button" data-gal_id="'.$gal->gallery_id.'" class ="btn btn-xs btn-danger delete-gallery">Xoá</button>

                </td>
            </tr>
                ';
            }
        }else{
            $output.='
                        <tr>
                            <td></td>
                             <td colspan = "4">Sản phẩm chưa có thư viện ảnh</td>

                         </tr>';
        }
        echo $output;

    }
    public function update_gallery_name(Request $request){
        $gal_id = $request->gal_id;
        $gal_text = $request->gal_text;

        $gallery = Gallery::find($gal_id);
        $gallery->gallery_name = $gal_text;

         $gallery->save();
        echo $gallery;
    }

    public function update_gallery(Request $request){
        $get_image = $request->file('file');
        $gal_id = $request->gal_id;
        if($get_image){

                    $get_name_image = $get_image->getClientOriginalName(); //tenhinhanh.jpg
                    $name_image = current(explode('.',$get_name_image)); //[0] => tenhinhanh . [1] => jpg , lay mang dau tien
                    $new_image = $name_image.rand(0,9999).'.'. $get_image->getClientOriginalExtension(); // random tranh trung hinh anh, getClientOriginalExtension lay duoi mo rong
                    $get_image->move('public/uploads/gallery', $new_image);

                    $gallery = Gallery::find($gal_id);
                    unlink('public/uploads/gallery/'.$gallery->gallery_image);

                    $gallery->gallery_image = $new_image;
                    $gallery->save();



        }
    }
    public function delete_gallery(Request $request){
        $gal_id = $request->gal_id;
        $gallery = Gallery::find($gal_id);
        unlink('public/uploads/gallery/'.$gallery->gallery_image);
        $gallery->delete();
    }

    public function insert_gallery(Request $request,$product_id){
        $get_image = $request->file('file');
        if($get_image){
            foreach($get_image as $image){
                if($get_image){
                    $get_name_image = $image->getClientOriginalName(); //tenhinhanh.jpg
                    $name_image = current(explode('.',$get_name_image)); //[0] => tenhinhanh . [1] => jpg , lay mang dau tien
                    $new_image = $name_image.rand(0,9999).'.'. $image->getClientOriginalExtension(); // random tranh trung hinh anh, getClientOriginalExtension lay duoi mo rong
                    $image->move('public/uploads/gallery', $new_image);
                    $gallery = new Gallery();
                    $gallery->gallery_name  = $new_image;
                    $gallery->gallery_image = $new_image;
                    $gallery->product_id    = $product_id;
                    $gallery->save();

                }
            }
        }
        Session::put('message', 'Thêm thư viện ảnh thành công');

        return redirect()->back();

    }

    public function all_gallery(){
        $all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->paginate(5);
        return view('admin.product.all_product', compact('all_product'));
    }


}
