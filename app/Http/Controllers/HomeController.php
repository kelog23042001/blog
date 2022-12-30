<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Banner;
use App\Models\CategoryPost;
use App\Models\CategoryProductModel;
use App\Models\Product;

class HomeController extends Controller
{

    public function test(Request $request)
    {
        //Post category
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->where('cate_post_status', "1")->get();

        //slider
        $slider = Banner::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status', '1')->orderBy('product_id', 'desc')->limit(6)
            ->get();

        $sold_product = DB::table('tbl_product')->where('product_status', '1')->orderBy('product_sold', 'desc')->limit(3)
            ->get();

        return view('user.pages.testSlide')->with('category', $cate_product)->with('brand', $brand_product)->with('product', $all_product)
            ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical)
            ->with('slider', $slider)->with('category_post', $category_post)->with('sold_product', $sold_product);
        # code...
    }

    public function show_quick_cart()
    {
        $output = '
        <form>
            ' . csrf_field() . '

        <table class="table table-condensed">';
        if (Session::get('cart')) {
            $output .= '' . csrf_field() . '';
        }
        $output .= '<thead>
                <tr class="cart_menu">
                    <td class="image">Hình ảnh</td>
                    <td class="description">Tên sản phẩm</td>
                    <td class="price">Giá sản phẩm</td>
                    <td class="quantity">Số lượng</td>
                    <td class="total">Thành tiền</td>
                    <td class="function">&nbsp</td>
                </tr>
            </thead>
            <tbody>';
        if (Session::get('cart')) {
            $total = 0;
            foreach (Session::get('cart') as $key => $cart) {

                $subtotal = $cart['product_price'] * $cart['product_qty'];
                $total += $subtotal;

                $output .= '  <tr>
                        <td class="cart_product">
                            <img src="' . asset('public/uploads/product/' . $cart['product_image']) . '" width="90" alt="' . $cart['product_name'] . '" />
                        </td>

                        <td class="cart_description">
                            <h4><a href=""></a></h4>
                            <p>' . $cart['product_name'] . '</p>
                        </td>

                        <td class="cart_price">
                            <p>' . number_format($cart['product_price'], 0, ',', '.') . ' VNĐ</p>
                        </td>

                            <input type="hidden"  data-session_remain_qty="' . $cart['remain_qty'] . '" value="' . $cart['remain_qty'] . '">

                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <input class="cart_qty_update" type="number" min="1" data-session_id="' . $cart['session_id'] . '" value="' . $cart['product_qty'] . '">
                            </div>
                        </td>

                        <td class="cart_total">
                            <p class="cart_total_price">
                                ' . number_format($subtotal, 0, ',', '.') . ' VND
                            </p>
                        </td>

                        <td class="cart_delete">
                            <a class="cart_quantity_delete" style = "pointer: cursor" id = "' . $cart['session_id'] . '" onclick = "DeleteItemCart(this.id)" ><i class="fa fa-times"></i></a>
                        </td>
                    </tr>';
            };
            $output .= '<tr>
                    </tr>';
        } else {
            $output .= '<tr>
                    <td colspan="5">
                        <center>';

            echo "Chưa có sản phẩm trong giỏ hàng";

            $output .= '</center>
                    </td>
                </tr>';
        }
        $output .= '</tbody>
                        </table>
                        </form>';



        if (Session::get('cart')) {
            $output .= '<section id="do_action">
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="total_area">
                <ul>
                    <li>Tổng tiền :<span>' . number_format($total, 0, ',', '.') . ' VND</span></li>
                </ul>

                ';
            if (Session::get('customer_id')) {
                $output .= '<a class="btn btn-warning check_out" href="' . url('/checkout') . '">Đặt hàng</a>';
            } else {
                $output .= '<a class="btn btn-warning check_out" href="' . url('/checkout') . '">Đặt hàng</a>

                <!-- <a class="btn btn-warning check_out" href="' . url('/login-checkout') . '">Đặt hàng</a> -->';
            }
            $output .= '</div>
        </div>
            </div>
        </div>
        </section>';
        }
        $output .= '</div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
        ';
        echo $output;
    }

    public function update_quick_cart(Request $request)
    {
        $data = $request->all();
        $cart = Session::get('cart');
        // dd($cart);
        if ($cart) {
            foreach ($cart as $session => $val) {
                if ($val['session_id'] == $data['session_id']) {
                    if ($cart[$session]['remain_qty'] - $data['quantity'] < 0) {
                        return Redirect()->back();
                    } else {
                        $cart[$session]['product_qty'] = $data['quantity'];
                    }
                }
            }
            Session::put('cart', $cart);
        }
    }

    public function send_mail()
    {

        $to_name = "LKShop";
        $to_email = "khalongtvh@gmail.com";
        $data = array("name" => "LKShop", "body" => "Mail mã khuyến mãi");

        Mail::send('admin.mail.confirm_order', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email)->subject('Nhận mã khuyến mãi');
            $message->from($to_email, $to_name);
        });
        //    return redirect('/')->with('message', '');
    }
    public function index(Request $request)
    {
        //Post category
        $category_post = CategoryPost::orderby('cate_post_name', 'ASC')->where('cate_post_status', "1")->get();

        //slider
        $slider = Banner::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();

        $cate_product = CategoryProductModel::where('category_status', '1')->orderBy('category_name', 'asc')->get();

        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        $all_product = Product::where('product_status', 1)->where('deleted', 0)->orderBy('product_id', 'desc')
            ->limit(10)->get();

        $sold_product = Product::where('product_status', 1)->where('deleted', 0)->orderBy('product_sold', 'desc')
            ->limit(10)->get();

        $view_product = Product::where('product_status', 1)->where('deleted', 0)->orderBy('product_views', 'desc')
            ->limit(10)->get();

        $price_product = Product::where('product_status', 1)->where('deleted', 0)->where('product_price', '<', '500000')->orderBy('product_price', 'desc')
            ->limit(10)->get();

        return view('user.pages.home')->with('categories', $cate_product)->with('brand', $brand_product)->with('products', $all_product)
            ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical)
            ->with('slider', $slider)->with('category_post', $category_post)
            ->with('view_product', $view_product)
            ->with('price_product', $price_product)
            ->with('sold_product', $sold_product);
        //return view('user.pages.home')->with(compact('cate_product', 'brand_product', 'all_product' ));

    }

    public function search(Request $request)
    {
        $category_post = CategoryPost::orderby('cate_post_id', 'DESC')->paginate(5);

        $meta_decs = "Chuyên bán quần áo nữ";
        $meta_title = "LK - Shopping";
        $meta_keyword = "quan ao nu, quần áo nữ";
        $url_canonical = $request->url();
        $keywords = $request->keywords_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%' . $keywords . '%')->get();

        return view('user.pages.product.search', compact('category_post'))->with('category', $cate_product)->with('brand', $brand_product)
            ->with('search_product', $search_product)
            ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical);
    }


    public function autocomplete_ajax(Request $request)
    {
        $data = $request->all();
        if ($data['query']) {
            $product = Product::where('product_status', 1)->where('product_name', 'LIKE', '%' . $data['query'] . '%')->get();
            $output = '<ul class= "dropdown-menu" style="display:block; position:relative">';
            if (count($product)) {
                foreach ($product as $key => $val) {
                    $output .= '
                    <li class="li_search_ajax"><a  href="' . url('chi-tiet-san-pham/' . $val->product_id) . '">' . $val->product_name . '</a></li>';
                }
            } else {
                $output .= '
                    <li class="li_search_ajax"><a  href="#">Không thấy sản phẩm</a></li>';
            }

            $output .= '</ul>';
            echo $output;
        }
    }

    // public function load_more_product(Request $request){
    //     $data = $request->all();
    //     if($data['id'] > 0){
    //         $all_product = Product::where('product_status', '1')->where('product_id', '<', $data['id'])->orderBy('product_id','desc')->take(3)->get();

    //     }else{
    //         $all_product = Product::where('product_status', '1')->orderBy('product_id','desc')->take(3)->get();
    //     }
    //     $output = '';
    //     if(!$all_product->isEmpty()){

    //     foreach($all_product as $key => $val){
    //         $last_id = $val->product_id;
    //         $output.='  <div class="col-sm-4">
    //         <div class="product-image-wrapper">
    //             <div class="single-products">
    //                     <div class="productinfo text-center">
    //                         <form>
    //                             '.csrf_field().'
    //                             <input type="hidden" value="'.$val->product_id.'" class="cart_product_id_'.$val->product_id.'">
    //                             <input type="hidden" id="wishlist_productname'.$val->product_id.'" value="'.$val->product_name.'" class="cart_product_name_'.$val->product_id.'">
    //                             <input type="hidden" value="'.$val->product_image.'" class="cart_product_image_'.$val->product_id.'">
    //                             <input type="hidden" id="wishlist_productprice'.$val->product_id.'" value="'.$val->product_price.'" class="cart_product_price_'.$val->product_id.'">
    //                             <input type="hidden" value="1" class="cart_product_qty_'.$val->product_id.'">

    //                             <input type="hidden" value="'.$val->product_product_quantity.'" class="product_qty_'.$val->product_id.'">
    //                             <input type="hidden" id="wishlist_productdesc'.$val->product_id.'" value="'.$val->product_desc.'" class="cart_product_desc_'.$val->product_id.'">

    //                             <a id="wishlist_producturl'.$val->product_id.'" href="'.url('chi-tiet-san-pham/'.$val->product_id).'">
    //                                 <img id="wishlist_productimage'.$val->product_id.'" width="200px" height="250px" src="'.url('public/uploads/product/'.$val->product_image).'" alt="" />
    //                                 <h2>'.number_format($val->product_price, 0, ',','.').' VND</h2>
    //                                 <p>'.$val->product_name.'</p>
    //                             </a>
    //                             <button type="button" class="btn  add-to-cart"
    //                                id="'.$val->product_id.'" onclick = "Addtocart(this.id);"><i class = "fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
    //                             </form>
    //                     </div>
    //                 </a>
    //             </div>
    //             <div class="choose">

    //                 <ul class="nav nav-pills nav-justified">

    //                     <li><i class="fa fa-star"></i><button  class="button_wishlist" id="'.$val->product_id.'" onclick="add_wistlist(this.id);"><span>Yêu thích</span></button></li>
    //                     <li><a style="cursor: pointer;" onclick="add_compare('.$val->product_id.');" ><i class="fa fa-plus-square"></i>So sánh</a></li>

    //                     <div class="container">
    //                         <div class="modal fade" id="sosanh" role="dialog" >
    //                             <div class="modal-dialog modal-lg">
    //                             <div class="modal-content">

    //                                     <div class="modal-header">
    //                                         <button type="button" class="close" data-dismiss="modal">&times;</button>
    //                                         <div id="notify"></div>
    //                                         <h4 class="modal-title"><div id="title-compare"></div></h4>
    //                                     </div>

    //                                 <div class="modal-body" >
    //                                     <table class="table table-hover" id="row_compare">
    //                                         <thead>
    //                                             <tr>
    //                                                 <th>Tên</th>
    //                                                 <th>Giá</th>
    //                                                 <th>Hình ảnh</th>
    //                                                 <th>Thuộc tính</th>
    //                                                 <th>Thông tin kỹ thuật</th>
    //                                                 <th>Mô tả</th>
    //                                                 <th>Quản lý</th>
    //                                                 <th>Xoá</th>
    //                                             </tr>
    //                                         </thead>
    //                                         <tbody>

    //                                         </tbody>
    //                                     </table>

    //                                 </div>
    //                                 <div class="modal-footer">
    //                                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    //                                 </div>
    //                             </div>

    //                             </div>
    //                         </div>

    //                     </div>
    //                 </ul>
    //             </div>
    //         </div>
    //     </div>';


    //     }
    //     $output.='<div id = "load_more" >
    //     <button type = "button" name = "load_more_button" class = "form-control" style="border:none; color:red; height:40px; font-size:16px; -webkit-box-shadow:none; font-size:16" data-id="'.$last_id.'"
    //      id = "load_more_button">Xem thêm...</button>
    // </div>';
    //     }else{
    //         $output.='<div id = "load_more" >
    //         <button type = "button" name = "load_more_button" class = "btn btn-default form-control " style="display: none;"
    //          >Dữ liệu đang cập nhập thêm</button>
    //     </div>';
    //     }
    //     echo $output;
    // }
    // public function load_more_selling_product(Request $request){
    //     $data = $request->all();
    //     if($data['id'] > 0){
    //         $all_product = Product::where('product_status', '1')->where('product_id', '>', $data['id'])->orwhere('product_id', '<', $data['id'])->where('product_id', '<>', $data['id'])->orderBy('product_sold','desc')->orderBy('product_sold','desc')->take(3)->get();

    //     }else{
    //         $all_product = Product::where('product_status', '1')->orderBy('product_sold','desc')->take(6)->get();
    //     }
    //     $output = '';
    //     if(!$all_product->isEmpty()){

    //         foreach($all_product as $key => $val){
    //             $last_id = $val->product_id;
    //             $output.='  <div class="col-sm-4">
    //             <div class="product-image-wrapper">
    //                 <div class="single-products">
    //                         <div class="productinfo text-center">
    //                             <form>
    //                                 '.csrf_field().'
    //                                 <input type="hidden" value="'.$val->product_id.'" class="cart_product_id_'.$val->product_id.'">
    //                                 <input type="hidden" id="wishlist_productname'.$val->product_id.'" value="'.$val->product_name.'" class="cart_product_name_'.$val->product_id.'">
    //                                 <input type="hidden" value="'.$val->product_image.'" class="cart_product_image_'.$val->product_id.'">
    //                                 <input type="hidden" id="wishlist_productprice'.$val->product_id.'" value="'.$val->product_price.'" class="cart_product_price_'.$val->product_id.'">
    //                                 <input type="hidden" value="1" class="cart_product_qty_'.$val->product_id.'">
    //                                 <input type="hidden" id="wishlist_productdesc'.$val->product_id.'" value="'.$val->product_desc.'" class="cart_product_desc_'.$val->product_id.'">

    //                                 <a id="wishlist_producturl'.$val->product_id.'" href="'.url('chi-tiet-san-pham/'.$val->product_id).'">
    //                                     <img id="wishlist_productimage'.$val->product_id.'" width="200px" height="250px" src="'.url('public/uploads/product/'.$val->product_image).'" alt="" />
    //                                     <h2>'.number_format($val->product_price, 0, ',','.').' VND</h2>
    //                                     <p>'.$val->product_name.'</p>
    //                                 </a>
    //                                 <button type="button" class="btn  add-to-cart"
    //                                    id="'.$val->product_id.'" onclick = "Addtocart(this.id);"><i class = "fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
    //                                 </form>
    //                         </div>
    //                     </a>
    //                 </div>
    //                 <div class="choose">

    //                     <ul class="nav nav-pills nav-justified">

    //                         <li><i class="fa fa-star"></i><button  class="button_wishlist" id="'.$val->product_id.'" onclick="add_wistlist(this.id);"><span>Yêu thích</span></button></li>
    //                         <li><a style="cursor: pointer;" onclick="add_compare('.$val->product_id.');" ><i class="fa fa-plus-square"></i>So sánh</a></li>

    //                         <div class="container">
    //                             <div class="modal fade" id="sosanh" role="dialog" >
    //                                 <div class="modal-dialog modal-lg">
    //                                 <div class="modal-content">

    //                                         <div class="modal-header">
    //                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
    //                                             <div id="notify"></div>
    //                                             <h4 class="modal-title"><div id="title-compare"></div></h4>
    //                                         </div>

    //                                     <div class="modal-body" >
    //                                         <table class="table table-hover" id="row_compare">
    //                                             <thead>
    //                                                 <tr>
    //                                                     <th>Tên</th>
    //                                                     <th>Giá</th>
    //                                                     <th>Hình ảnh</th>
    //                                                     <th>Thuộc tính</th>
    //                                                     <th>Thông tin kỹ thuật</th>
    //                                                     <th>Mô tả</th>
    //                                                     <th>Quản lý</th>
    //                                                     <th>Xoá</th>
    //                                                 </tr>
    //                                             </thead>
    //                                             <tbody>

    //                                             </tbody>
    //                                         </table>

    //                                     </div>
    //                                     <div class="modal-footer">
    //                                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    //                                     </div>
    //                                 </div>

    //                                 </div>
    //                             </div>

    //                         </div>
    //                     </ul>
    //                 </div>
    //             </div>
    //         </div>';


    //         }
    //     //     $output.='<div id = "load_more" >
    //     //     <button type = "button" name = "load_more_button" class = "form-control" style="border:none; color:red; height:40px; font-size:16px; -webkit-box-shadow:none; font-size:16" data-id="'.$last_id.'"
    //     //      id = "load_more_button">Xem thêm...</button>
    //     // </div>';
    //     //     }else{
    //     //         $output.='<div id = "load_more" >
    //     //         <button type = "button" name = "load_more_button" class = "btn btn-default form-control " style="display: none;"
    //     //          >Dữ liệu đang cập nhập thêm</button>
    //     //     </div>';
    //         }
    //         echo $output;
    // }

}
