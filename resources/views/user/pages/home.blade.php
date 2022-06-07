@extends('layout')
@section('content')
<section id="slider">
    <!--slider-->
    @include('user.elements.slider')
</section>
<div class="col-sm-3">
    <div class="left-sidebar">
        @include('user.elements.left_sidebar')
        @include('user.elements.left_sidebar.viewed')
        @include('user.elements.left_sidebar.wishlist')
    </div>
</div>

<?php 
    use Illuminate\Support\Facades\Session;
    // session::forget('cart');
    // session::forget('cart');
?>
<style>
    .slick-slide {
        width: 250px !important;
    }

    .slick-arrow {
        z-index: 100;
    }

    .product-image-wrappe {
        margin-bottom: 0;
    }

    .slick-next {
        position: absolute;
        top: none !important;
    }

    /* 
    .slick-next {
        right: 0;
    } */

    /* .product-image-wrapper{
        margin-bottom: 20px;
    } */
    .new_top .slick-next {
        top: 48px;
        right: 0px;
    }

    .new_top .slick-prev {
        float: right;
        position: relative;
        top: 0;
        right: 58px;
    }

    .favorites-slider .slick-arrow i {
        width: 40px;
        height: 40px;
        background: #ff000000;
        border: 2px solid #FE980F;
        border-radius: 20px 20px;
    }

    .sold_top .slick-next {
        /* background-color: #ba1f24; */
        /* background: red; */
        top: 577px;
        right: 0px;
    }

    .sold_top .slick-prev {
        float: right;
        position: relative;
        top: 0;
        right: 58px;
    }
    
    .price_top .slick-next {
        /* background-color: #ba1f24; */
        /* background: red; */
        top: 1108px;
        right: 0px;
    }

    .price_top .slick-prev {
        float: right;
        position: relative;
        top: 0;
        right: 58px;
    }

    .view_top .slick-next {
        /* background-color: #ba1f24; */
        /* background: red; */
        top: 1637px;
        right: 0px;
    }

    .view_top .slick-prev {
        float: right;
        position: relative;
        top: 0;
        right: 58px;
    }
    

</style>


<div class="col-sm-9 padding-right ">

    <div class="features_items overflow-hidden new_top" style="height: 530px;">
        <h2 class="title text-center" style="margin-top : 16px; margin-bottom: 10px">hàng mới về</h2>
        <ul class="favorites-slider list-inline">
            @foreach($product as $key=>$productNew)
            <li class="col-sm-2">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <form>
                                <input type="hidden" value="{{$productNew->product_id}}" class="cart_product_id_{{$productNew->product_id}}">

                                <input type="hidden" id="wishlist_productname{{$productNew->product_id}}" value="{{$productNew->product_name}}" class="cart_product_name_{{$productNew->product_id}}">

                                <input type="hidden" value="{{$productNew->product_image}}" class="cart_product_image_{{$productNew->product_id}}">

                                <input type="hidden" id="wishlist_productprice{{$productNew->product_id}}" value="{{$productNew->product_price}}" class="cart_product_price_{{$productNew->product_id}}">

                                <input type="hidden" value="1" class="cart_product_qty_{{$productNew->product_id}}">

                                <input type="hidden" value="{{$productNew->product_quantity}}" class="product_qty_{{$productNew->product_id}}">

                                <input type="hidden" id="wishlist_productdesc{{$productNew->product_id}}" value="{{$productNew->product_desc}}" class="cart_product_desc_{{$productNew->product_id}}">

                                <a id="wishlist_producturl{{$productNew->product_id}}" href="{{URL::to('chi-tiet-san-pham/'.$productNew->product_id)}}">
                                    <img id="wishlist_productimage{{$productNew->product_id}}" width="200px" height="250px" src="{{URL::to('public/uploads/product/'.$productNew->product_image)}}" alt="" />
                                    <h2>{{number_format($productNew->product_price,0,',','.')}} VNĐ</h2>
                                    <p>{{ $productNew->product_name}}</p>
                                </a>
                                <button type="button" class="btn  add-to-cart" style="margin-bottom: 0" id="{{$productNew->product_id}}" onclick="Addtocart(this.id);"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                            </form>
                        </div>
                        </a>
                    </div>

                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><i class="fa fa-star"></i><button class="button_wishlist" id="{{$productNew->product_id}}" onclick="add_wistlist(this.id);"><span>Yêu thích</span></button>
                            </li>
                            <li>
                                <a style="cursor: pointer;" onclick="add_compare({{$productNew->product_id}});">
                                    <i class="fa fa-plus-square"></i>So sánh
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="features_items overflow-hidden sold_top" style="height: 530px;">
        <h2 class="title text-center" style="margin-top : 16px; margin-bottom: 10px">được mua nhiều nhất</h2>
        <ul class="favorites-slider list-inline ">
            @foreach($sold_product as $key=>$productNew)
            <li class="col-sm-2">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <form>
                                <input type="hidden" value="{{$productNew->product_id}}" class="cart_product_id_{{$productNew->product_id}}">

                                <input type="hidden" id="wishlist_productname{{$productNew->product_id}}" value="{{$productNew->product_name}}" class="cart_product_name_{{$productNew->product_id}}">

                                <input type="hidden" value="{{$productNew->product_image}}" class="cart_product_image_{{$productNew->product_id}}">

                                <input type="hidden" id="wishlist_productprice{{$productNew->product_id}}" value="{{$productNew->product_price}}" class="cart_product_price_{{$productNew->product_id}}">

                                <input type="hidden" value="1" class="cart_product_qty_{{$productNew->product_id}}">

                                <input type="hidden" value="{{$productNew->product_quantity}}" class="product_qty_{{$productNew->product_id}}">

                                <input type="hidden" id="wishlist_productdesc{{$productNew->product_id}}" value="{{$productNew->product_desc}}" class="cart_product_desc_{{$productNew->product_id}}">

                                <a id="wishlist_producturl{{$productNew->product_id}}" href="{{URL::to('chi-tiet-san-pham/'.$productNew->product_id)}}">
                                    <img id="wishlist_productimage{{$productNew->product_id}}" width="200px" height="250px" src="{{URL::to('public/uploads/product/'.$productNew->product_image)}}" alt="" />
                                    <h2>{{number_format($productNew->product_price,0,',','.')}} VNĐ</h2>
                                    <p>{{ $productNew->product_name}}</p>
                                </a>
                                <button type="button" class="btn  add-to-cart"  style="margin-bottom: 0" id="{{$productNew->product_id}}" onclick="Addtocart(this.id);"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                            </form>
                        </div>
                        </a>
                    </div>

                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><i class="fa fa-star"></i><button class="button_wishlist" id="{{$productNew->product_id}}" onclick="add_wistlist(this.id);"><span>Yêu thích</span></button>
                            </li>
                            <li>
                                <a style="cursor: pointer;" onclick="add_compare({{$productNew->product_id}});">
                                    <i class="fa fa-plus-square"></i>So sánh
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="features_items overflow-hidden price_top" style="height: 530px;">
        <h2 class="title text-center" style="margin-top : 16px; margin-bottom: 10px">giá rẻ</h2>
        <ul class="favorites-slider list-inline ">
            @foreach($price_product as $key=>$productNew)
            <li class="col-sm-2">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <form>
                                <input type="hidden" value="{{$productNew->product_id}}" class="cart_product_id_{{$productNew->product_id}}">

                                <input type="hidden" id="wishlist_productname{{$productNew->product_id}}" value="{{$productNew->product_name}}" class="cart_product_name_{{$productNew->product_id}}">

                                <input type="hidden" value="{{$productNew->product_image}}" class="cart_product_image_{{$productNew->product_id}}">

                                <input type="hidden" id="wishlist_productprice{{$productNew->product_id}}" value="{{$productNew->product_price}}" class="cart_product_price_{{$productNew->product_id}}">

                                <input type="hidden" value="1" class="cart_product_qty_{{$productNew->product_id}}">

                                <input type="hidden" value="{{$productNew->product_quantity}}" class="product_qty_{{$productNew->product_id}}">

                                <input type="hidden" id="wishlist_productdesc{{$productNew->product_id}}" value="{{$productNew->product_desc}}" class="cart_product_desc_{{$productNew->product_id}}">

                                <a id="wishlist_producturl{{$productNew->product_id}}" href="{{URL::to('chi-tiet-san-pham/'.$productNew->product_id)}}">
                                    <img id="wishlist_productimage{{$productNew->product_id}}" width="200px" height="250px" src="{{URL::to('public/uploads/product/'.$productNew->product_image)}}" alt="" />
                                    <h2>{{number_format($productNew->product_price,0,',','.')}} VNĐ</h2>
                                    <p>{{ $productNew->product_name}}</p>
                                </a>
                                <button type="button" class="btn  add-to-cart"  style="margin-bottom: 0" id="{{$productNew->product_id}}" onclick="Addtocart(this.id);"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                            </form>
                        </div>
                        </a>
                    </div>

                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><i class="fa fa-star"></i><button class="button_wishlist" id="{{$productNew->product_id}}" onclick="add_wistlist(this.id);"><span>Yêu thích</span></button>
                            </li>
                            <li>
                                <a style="cursor: pointer;" onclick="add_compare({{$productNew->product_id}});">
                                    <i class="fa fa-plus-square"></i>So sánh
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="features_items overflow-hidden view_top" style="height: 530px;">
        <h2 class="title text-center" style="margin-top : 16px; margin-bottom: 10px">được xem nhiều nhất</h2>
        <ul class="favorites-slider list-inline ">
            @foreach($view_product as $key=>$productNew)
            <li class="col-sm-2">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <form>
                                <input type="hidden" value="{{$productNew->product_id}}" class="cart_product_id_{{$productNew->product_id}}">

                                <input type="hidden" id="wishlist_productname{{$productNew->product_id}}" value="{{$productNew->product_name}}" class="cart_product_name_{{$productNew->product_id}}">

                                <input type="hidden" value="{{$productNew->product_image}}" class="cart_product_image_{{$productNew->product_id}}">

                                <input type="hidden" id="wishlist_productprice{{$productNew->product_id}}" value="{{$productNew->product_price}}" class="cart_product_price_{{$productNew->product_id}}">

                                <input type="hidden" value="1" class="cart_product_qty_{{$productNew->product_id}}">

                                <input type="hidden" value="{{$productNew->product_quantity}}" class="product_qty_{{$productNew->product_id}}">

                                <input type="hidden" id="wishlist_productdesc{{$productNew->product_id}}" value="{{$productNew->product_desc}}" class="cart_product_desc_{{$productNew->product_id}}">

                                <a id="wishlist_producturl{{$productNew->product_id}}" href="{{URL::to('chi-tiet-san-pham/'.$productNew->product_id)}}">
                                    <img id="wishlist_productimage{{$productNew->product_id}}" width="200px" height="250px" src="{{URL::to('public/uploads/product/'.$productNew->product_image)}}" alt="" />
                                    <h2>{{number_format($productNew->product_price,0,',','.')}} VNĐ</h2>
                                    <p>{{ $productNew->product_name}}</p>
                                </a>
                                <button type="button" class="btn  add-to-cart"  style="margin-bottom: 0" id="{{$productNew->product_id}}" onclick="Addtocart(this.id);"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                            </form>
                        </div>
                        </a>
                    </div>

                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><i class="fa fa-star"></i><button class="button_wishlist" id="{{$productNew->product_id}}" onclick="add_wistlist(this.id);"><span>Yêu thích</span></button>
                            </li>
                            <li>
                                <a style="cursor: pointer;" onclick="add_compare({{$productNew->product_id}});">
                                    <i class="fa fa-plus-square"></i>So sánh
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="modal fade" id="sosanh" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="width: fit-content;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div id="notify"></div>
                <h2 class="modal-title title text-center">
                    <div id="title-compare"></div>
                </h2>
            </div>
            <div class="modal-body" style="padding: 0 10px;">
                <table style="width:100%" class="table table-hover" id="row_compare">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên</th>
                            <th>Giá</th>
                            <th>Mô tả</th>
                            <th>Quản lý</th>
                            <th>Xoá</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="quick-cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="width: fit-content; height:1000px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title title text-center" id="exampleModalLongTitle">Giỏ hàng</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0 10px;">
                <div id="show_quick_cart_alert"></div>
                <div id="show_quick_cart">
                </div>
            </div>

        </div>
        <!--features_items-->
    </div>
</div>

<!-- Your Plugin chat code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "102323342502839");
    chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: 'v14.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- <div id="all_product"></div><br>
        <h2 class="title text-center" style="margin-top : 16px">Sản Phẩm bán chạy nhất</h2>
        <div id="all_selling_product"></div> -->
@endsection