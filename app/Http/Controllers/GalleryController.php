<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GalleryController extends Controller
{

    public function add_gallery($product_id)
    {
        // dd($product_id);
        return view('admin.gallery.add_gallery', compact('product_id'));
    }

    public function select_gallery(Request $request)
    {
        // dd($request->all());
        $pro_id = $request->product_id;
        $gallery = Gallery::where('product_id', $pro_id)->get();
        $gallery_count = $gallery->count();
        // dd($gallery_count);
        $output = '';
        $output = '<table  class="table table-striped" id="table-category">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Hình ảnh</th>
                            <th>Quản lý</th>
                        </tr>
                        </thead>
                        <tbody>';
        if ($gallery_count > 0) {
            foreach ($gallery as $key => $gal) {
                $output .= '
                <tr>
                <td>' . ($key + 1) . '</td>
                <td style =  "width: 500px;">
                    <img width = "20%" height = "120px" src = "' . $gal->imageUrl . '" class = "img-thumbnail"><br>
                    <input type ="file" class = "file_image" style ="width: 40%" data-gal_id="' . $gal->gallery_id . '" id = "file-' . $gal->gallery_id . '"name="file" accpect="image/*" />
                </td>
                <td>
                    <button type ="button" data-gal_id="' . $gal->gallery_id . '" class ="btn btn-xs btn-danger delete-gallery">Xoá</button>
                </td>
            </tr>';
            }
        } else {
            $output .= '<tr><td></td><td colspan = "4">Sản phẩm chưa có thư viện ảnh</td></tr>';
        }
        echo $output;
    }
    public function update_gallery_name(Request $request)
    {
        $gal_id = $request->gal_id;
        $gal_text = $request->gal_text;

        $gallery = Gallery::find($gal_id);
        $gallery->gallery_name = $gal_text;

        $gallery->save();
        echo $gallery;
    }

    public function update_gallery(Request $request)
    {
        // dd($request->all());
        $get_image = $request->file('file');
        $gal_id = $request->gal_id;
        if ($get_image) {
            $uploadedImages = Cloudinary::upload($get_image->getRealPath(), [
                'folder' => 'Products',
            ])->getSecurePath();
            $gallery = Gallery::find($gal_id);
            $gallery->imageUrl = $uploadedImages;
            $gallery->save();
        }
    }
    public function delete_gallery(Request $request)
    {
        // dd($request->all());
        $gal_id = $request->gal_id;
        $gallery = Gallery::find($gal_id);
        // dd($gallery);
        $gallery->delete();
    }

    public function insert_gallery(Request $request, $product_id)
    {
        // dd($request->all());
        $get_image = $request->file('file');

        if ($get_image) {
            foreach ($get_image as $image) {
                if ($get_image) {
                    $uploadedImages = Cloudinary::upload($image->getRealPath(), [
                        'folder' => 'Products',
                    ])->getSecurePath();
                    $gallery = new Gallery();
                    $gallery->imageUrl = $uploadedImages;
                    $gallery->product_id    = $product_id;
                    $gallery->save();
                }
            }
        }
        Session::put('message', 'Thêm thư viện ảnh thành công');

        return back();
    }

    public function all_gallery()
    {
        $all_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
            ->paginate(5);
        return view('admin.product.all_product', compact('all_product'));
    }
}
