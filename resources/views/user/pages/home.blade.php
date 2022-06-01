@extends('layout')
@section('content')
<section id="slider"><!--slider-->
    @include('elements.slider')
</section>
<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Danh Mục Sản Phẩm</h2>
        <!--category-productsr-->
        <div class="panel-group category-products" id="accordian">
            @foreach($category as $key => $cate)
            @if($cate->category_parent == 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordian" href="#{{$cate->slug_category_product}}">
                                <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                    {{$cate->category_name}}
                            </a>
                        </h4>
                    </div>

                    <div id="{{$cate->slug_category_product}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>
                                @foreach($category as $key => $cate_sub)
                                    @if($cate_sub->category_parent == $cate->category_id)
                                        <li><a href="{{URL::to('/danh-muc-san-pham/'.$cate_sub->category_id)}}">{{$cate_sub->category_name}} </a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div><!--/category-products-->

        <div class="brands_products"><!--brands_products-->
            <h2>Thương Hiệu Sản Phẩm</h2>
            @foreach($brand as $key => $brand)
            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_id)}}">{{$brand->brand_name}}</a></li>
                </ul>
            </div>
            @endforeach
        </div><!--/brands_products-->

       <!--price-range-->
        <!-- <div class="price-range">
            <h2>Price Range</h2>
            <div class="well text-center">
                    <input type="text" class="span2" value="" data-    -min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
                    <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
            </div>
        </div>
        /price-range -->
        <div class="brands_products"><!--like-range-->
            <h2>Sản phẩm đã xem</h2>
            <div class="brands-name">
                    <div id="row_viewed" class="row"></div>
            </div>
        </div><!--/like-range-->
        <div class="brands_products"><!--like-range-->
            <h2>Sản phẩm yêu thích</h2>
            <div class="brands-name">
                    <div id="row_wishlist" class="row"></div>
            </div>
        </div><!--/like-range-->
    </div>
</div>

<div class="col-sm-9 padding-right">
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center" style="margin-top : 16px">Sản Phẩm Mới Nhất</h2>
         <div id="all_product"></div>
        <div class="modal fade" id="quick-cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Giỏ hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                            <div id="show_quick_cart_alert"></div>
                    <div id="show_quick_cart">

                    </div>
                </div>
        <div id="fb-root"></div>
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
    </div><!--features_items-->
</div>
@endsection
