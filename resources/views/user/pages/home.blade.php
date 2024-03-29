@extends('layout')
@section('content')
<!-- <div id="row_wishlist"></div> -->
<!-- SECTION -->
<div class="section">
    <?php

    use Illuminate\Support\Facades\Session;
    // session::forget('cart');
    // session::forget('cart');
    ?>

    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">hàng mới về</h3>
                    <div class="section-nav">
                        <ul class="section-tab-nav tab-nav">
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /section title -->

            <!-- Products tab & slick -->
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <!-- tab -->
                        <div id="tab1" class="tab-pane active">
                            <div class="products-slick" data-nav="#slick-nav-1">
                                <!-- product -->
                                @foreach($products as $key => $product)
                                <div class="product">
                                    <a class="cart_product_url_{{$product->product_id}}" href="{{URL::to('chi-tiet-san-pham/'.$product->product_id)}}">
                                        <div class="product-img">
                                            <img src="{{$product->product_image}}" alt="">
                                            <div class="product-label">
                                                <span class="sale">-30%</span>
                                                <span class="new">NEW</span>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="product-body">
                                        <p class="product-category">{{$product->category->category_name}}</p>
                                        <h3 class="product-name"><a href="#">{{$product->product_name}}</a></h3>
                                        <h4 class="product-price">{{number_format($product->product_price,0,',','.')}} <del class="product-old-price">{{number_format($product->product_price,0,',','.')}}</del></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="product-btns">
                                            <button class="add-to-wishlist" id="{{$product->product_id}}" onclick="add_wistlist(this.id)">
                                                <i class=" fa fa-heart-o"></i>
                                                <span class="tooltipp">add to wishlist</span>
                                            </button>
                                            <button class="add-to-compare" id="{{$product->product_id}}" data-toggle="modal" onclick="add_compare(this.id)" data-target="#compareModal">
                                                <i class="fa fa-exchange"></i>
                                                <span class="tooltipp">so sánh</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <button class="add-to-cart-btn" id="{{$product->product_id}}" onclick="Addtocart(this.id);"><i class="fa fa-shopping-cart"></i> add to cart</button>
                                    </div>
                                    <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                    <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                    <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                    <input type="hidden" id="wishlist_productprice{{$product->product_id}}" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                    <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
                                    <input type="hidden" value="{{$product->product_quantity}}" class="product_qty_{{$product->product_id}}">
                                    <input type="hidden" id="wishlist_productdesc{{$product->product_id}}" value="{{$product->product_desc}}" class="cart_product_desc_{{$product->product_id}}">
                                </div>
                                @endforeach
                                <!-- /product -->
                            </div>
                            <div id="slick-nav-1" class="products-slick-nav"></div>
                        </div>
                        <!-- /tab -->
                    </div>
                </div>
            </div>
            <!-- Products tab & slick -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- HOT DEAL SECTION -->
<div id="hot-deal" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                @include('user.elements.slider')
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /HOT DEAL SECTION -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">bán nhiều nhất</h3>
                    <div class="section-nav">
                    </div>
                </div>
            </div>
            <!-- /section title -->
            <!-- Products tab & slick -->
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <!-- tab -->
                        <div id="tab2" class="tab-pane fade in active">
                            <div class="products-slick" data-nav="#slick-nav-2">
                                <!-- product -->
                                @foreach ($sold_product as $key => $product)
                                <div class="product">
                                    <a class="cart_product_url_{{$product->product_id}}" href="{{URL::to('chi-tiet-san-pham/'.$product->product_id)}}">
                                        <div class="product-img">
                                            <img src="{{$product->product_image}}" alt="">
                                            <div class="product-label">
                                                <!-- <span class="sale">-30%</span> -->
                                                <span class="new">TOP</span>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="product-body">
                                        <p class="product-category">{{$product->category->category_name}}</p>
                                        <h3 class="product-name"><a href="#">{{$product->product_name}}</a></h3>
                                        <h4 class="product-price">{{number_format($product->product_price,0,',','.')}} <del class="product-old-price">{{number_format($product->product_price,0,',','.')}}</del></h4>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="product-btns">
                                            <button class="add-to-wishlist" id="{{$product->product_id}}" onclick="add_wistlist(this.id)">
                                                <i class=" fa fa-heart-o"></i>
                                                <span class="tooltipp">add to wishlist</span>
                                            </button>
                                            <button class="add-to-compare" id="{{$product->product_id}}" data-toggle="modal" onclick="add_compare(this.id)" data-target="#compareModal">
                                                <i class="fa fa-exchange"></i>
                                                <span class="tooltipp">so sánh</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <button class="add-to-cart-btn" id="{{$product->product_id}}" onclick="Addtocart(this.id);"><i class="fa fa-shopping-cart"></i> add to cart</button>
                                    </div>
                                    <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                    <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                    <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                    <input type="hidden" id="wishlist_productprice{{$product->product_id}}" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                    <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
                                    <input type="hidden" value="{{$product->product_quantity}}" class="product_qty_{{$product->product_id}}">
                                    <input type="hidden" id="wishlist_productdesc{{$product->product_id}}" value="{{$product->product_desc}}" class="cart_product_desc_{{$product->product_id}}">
                                </div>
                                @endforeach
                                <!-- /product -->
                            </div>
                            <div id="slick-nav-2" class="products-slick-nav"></div>
                        </div>
                        <!-- /tab -->
                    </div>
                </div>
            </div>
            <!-- /Products tab & slick -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-4 col-xs-6">
                <div class="section-title">
                    <h4 class="title">ÁO LEN/NỈ</h4>
                    <div class="section-nav">
                        <div id="slick-nav-3" class="products-slick-nav"></div>
                    </div>
                </div>

                <div class="products-widget-slick" data-nav="#slick-nav-3">
                    <div>
                        @php tabCategory(22, $products) @endphp
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xs-6">
                <div class="section-title">
                    <h4 class="title">ÁO KHOÁC</h4>
                    <div class="section-nav">
                        <div id="slick-nav-4" class="products-slick-nav"></div>
                    </div>
                </div>

                <div class="products-widget-slick" data-nav="#slick-nav-4">
                    <div>
                        @php tabCategory(10, $products) @endphp
                    </div>
                </div>
            </div>

            <div class="clearfix visible-sm visible-xs"></div>

            <div class="col-md-4 col-xs-6">
                <div class="section-title">
                    <h4 class="title">ÁO POLO</h4>
                    <div class="section-nav">
                        <div id="slick-nav-5" class="products-slick-nav"></div>
                    </div>
                </div>

                <div class="products-widget-slick" data-nav="#slick-nav-5">
                    <div>
                        @php tabCategory(9, $products) @endphp
                    </div>
                </div>
            </div>

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /SECTION -->

<div class="modal fade" id="compareModal" tabindex="-1" role="dialog" aria-labelledby="compareModalLabel" aria-hidden="true">
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
<?php
function tabCategory($category_id, $products)
{
    $i = 0;
    foreach ($products as $key => $product) {
        if ($i < 3 && $product->category_id == $category_id) {
            $i++;
            echo '
        <div class="product-widget">
            <div class="product-img">
                <img src="' . $product->product_image . '" alt="">
            </div>
            <div class="product-body">
                <p class="product-category">' . $product->category->category_name . '</p>
                <h3 class="product-name"><a href="">' . $product->product_name . '</a></h3>
                <h4 class="product-price">' . number_format($product->product_price, 0, ', ', ' . ') . ' <del class="product-old-price">' . number_format($product->product_price, 0, ', ', ' . ') . '</del></h4>
            </div>
        </div>';
        }
    }
}
?>
@endsection