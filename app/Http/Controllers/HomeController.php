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

        $cate_product = CategoryProductModel::where('category_status', 1)->orderBy('category_name', 'asc')->get();

        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        $all_product = Product::where('product_status', 1)->where('deleted', 0)->orderBy('product_id', 'desc')
            ->limit(10)->get();

        $sold_product = Product::where('product_status', 1)->where('deleted', 0)->orderBy('product_sold', 'desc')
            ->limit(10)->get();

        $view_product = Product::where('product_status', 1)->where('deleted', 0)->orderBy('product_views', 'desc')
            ->limit(10)->get();

        $price_product = Product::where('product_status', 1)->where('deleted', 0)->where('product_price', '<', '500000')->orderBy('product_price', 'desc')
            ->limit(10)->get();

        $category_tabs = CategoryProductModel::where('category_status', 1)->orderBy('category_name', 'asc')->limit(4)->get();
        return view('user.pages.home')->with('categories', $cate_product)->with('products', $all_product)
            ->with('meta_decs', $meta_decs)->with('meta_title', $meta_title)->with('meta_keyword', $meta_keyword)->with('url_canonical', $url_canonical)
            ->with('slider', $slider)->with('category_post', $category_post)
            ->with('view_product', $view_product)
            ->with('category_tabs', $category_tabs)
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
            $output = '<ul class= "dropdown-menu" style="display:block; position:relative; height: 400px; overflow: scroll">';
            if (count($product)) {
                foreach ($product as $key => $val) {
                    $output .= '
                    <li class="li_search_ajax"><a  href="' . url('chi-tiet-san-pham/' . $val->product_id) . '">'.'<img width="50px" style = "margin-right: 20px" src="'.$val->product_image .'">'.$val->product_name . '</a></li>';
                }
            } else {
                $output .= '
                    <li class="li_search_ajax"><a  href="#">Không thấy sản phẩm</a></li>';
            }

            $output .= '</ul>';
            echo $output;
        }
    }
}
