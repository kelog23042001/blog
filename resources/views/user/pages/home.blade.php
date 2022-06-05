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

<div class="col-sm-9 padding-right">
    <div class="features_items">
        <h2 class="title text-center" style="margin-top : 16px">Sản Phẩm Mới Nhất</h2>
        @foreach($product as $key => $product)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <form>
                            <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                           
                            <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                            
                            <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                           
                            <input type="hidden" id="wishlist_productprice{{$product->product_id}}" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                           
                            <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">

                            <input type="hidden" value="{{$product->product_quantity}}" class="product_qty_{{$product->product_id}}">
                           
                            <input type="hidden" id="wishlist_productdesc{{$product->product_id}}" value="{{$product->product_desc}}" class="cart_product_desc_{{$product->product_id}}">

                            <a id="wishlist_producturl{{$product->product_id}}" href="{{URL::to('chi-tiet-san-pham/'.$product->product_id)}}">
                                <img id="wishlist_productimage{{$product->product_id}}" width="200px" height="250px" src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                                <h2>{{number_format($product->product_price,0,',','.')}} VNĐ</h2>
                                <p>{{ $product->product_name}}</p>
                            </a>
                            <button type="button" class="btn  add-to-cart" id="{{$product->product_id}}" onclick="Addtocart(this.id);"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                        </form>
                    </div>
                    </a>
                </div>

                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li><i class="fa fa-star"></i><button class="button_wishlist" id="{{$product->
                            product_id}}" onclick="add_wistlist(this.id);"><span>Yêu thích</span></button>
                        </li>
                        <li>
                            <a style="cursor: pointer;" onclick="add_compare({{$product->product_id}});">
                                <i class="fa fa-plus-square"></i>So sánh
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="features_items">
        <h2 class="title text-center" style="margin-top : 16px">Sản Phẩm Mua Nhiều</h2>
        @foreach($sold_product as $key => $product)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <form>
                            <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                           
                            <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                           
                            <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                            
                            <input type="hidden" id="wishlist_productprice{{$product->product_id}}" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                           
                            <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">

                            <input type="hidden" value="{{$product->product_quantity}}" class="product_qty_{{$product->product_id}}">

                            <input type="hidden" id="wishlist_productdesc{{$product->product_id}}" value="{{$product->product_desc}}" class="cart_product_desc_{{$product->product_id}}">

                            <a id="wishlist_producturl{{$product->product_id}}" href="{{URL::to('chi-tiet-san-pham/'.$product->product_id)}}">

                                <img id="wishlist_productimage{{$product->product_id}}" width="200px" height="250px" src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                                <h2>{{number_format($product->product_price,0,',','.')}} VNĐ</h2>
                                <p>{{ $product->product_name}}</p>
                            </a>
                            <button type="button" class="btn  add-to-cart" id="{{$product->product_id}}" onclick="Addtocart(this.id);"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                        </form>
                    </div>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
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