@extends('layout')
@section('content')
<?php
$max_price = $products->max('product_price') / 1000;
$min_price = $products->min('product_price') / 1000;
$maxRange /= 1000;
$minRange /= 1000;
if ($maxRange == 0) {
    $maxRange = $max_price;
}
?>
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="{{url('/trang-chu')}}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$meta_title}} ({{count($category->products)}} Sản phẩm)</li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- ASIDE -->
            <div id="aside" class="col-md-3">
                <div class="aside">
                    <h3 class="aside">Sắp xếp</h3>
                    <div class="store-sort">
                        <label>
                            <select class="input-select" name="sort" id="sort">
                                <option value="{{Request::url()}}">Mặc định</option>
                                <option value="{{Request::url()}}?sort_by=a_z" <?php if ($sort_by == 'a_z') echo 'selected' ?>>A-Z</option>
                                <option value="{{Request::url()}}?sort_by=z_a" <?php if ($sort_by == 'z_a') echo 'selected' ?>>Z-A</option>
                                <option value="{{Request::url()}}?sort_by=gia_giam_dan" <?php if ($sort_by == 'gia_giam_dan') echo 'selected' ?>>Giá giảm dần</option>
                                <option value="{{Request::url()}}?sort_by=gia_tang_dan" <?php if ($sort_by == 'gia_tang_dan') echo 'selected' ?>>Giá tăng dần</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="aside">
                    <h3 class="aside">Khoảng giá (VNĐ)</h3>
                    <form>
                        <!-- @csrf -->
                        <div class="price-filter">
                            <div id="price-slider"></div>
                            <div class="input-number price-min">
                                <input id="price-min" type="number" name="price-min">
                                <span class="qty-up">+</span>
                                <span class="qty-down">-</span>
                            </div>
                            <span>-</span>
                            <div class="input-number price-max">
                                <input id="price-max" type="number" name="price-max">
                                <span class="qty-up">+</span>
                                <span class="qty-down">-</span>
                            </div>
                        </div>
                        <em>Lọc theo đơn vị chục ngàn(x.000) VNĐ</em>
                        <input type="hidden" value="{{$minRange}}" id="min-price">
                        <input type="hidden" value="{{$maxRange}}" id="max-price">
                        <input type="submit" value="Lọc theo giá" class="primary-btn" style="width: -webkit-fill-available; margin-top: 15px">
                    </form>
                </div>
            </div>
            <!-- /ASIDE -->

            <!-- STORE -->
            <div id="store" class="col-md-9">
                <!-- store products -->
                <div class="row">
                    <!-- product -->
                    @foreach ($products as $key => $product)
                    <div class="col-md-4 col-xs-6">
                        <div class="product">
                            <a class="cart_product_url_{{$product->product_id}}" href="{{URL::to('chi-tiet-san-pham/'.$product->product_id)}}">
                                <div class="product-img">
                                    <img src="{{$product->product_image}}" alt="{{$product->product_name}}" height="">
                                    <div class="product-label">
                                        <!-- <span class="sale">-30%</span>
                                        <span class="new">NEW</span> -->
                                    </div>
                                </div>
                            </a>
                            <div class="product-body">
                                <p class="product-category">{{$product->category->category_name}}</p>
                                <h3 class="product-name"><a href="#">{{$product->product_name}}</a></h3>
                                <h4 class="product-price">{{number_format($product->product_price,0,',','.')}} <del class="product-old-price">{{number_format($product->product_price,0,',','.')}}</del></h4>
                                <!-- rating vote -->
                                <div class="product-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <!-- end rating vote -->
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
                    </div>
                    @endforeach
                    <!-- /product -->
                </div>
                <!-- /STORE -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
    @endsection