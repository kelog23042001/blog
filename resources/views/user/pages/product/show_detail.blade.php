@extends('layout')
@section('content')
<?php

use Illuminate\Support\Facades\Auth;

$user = Auth::user();

?>

<input type="hidden" id="product_viewed_id" value="{{$detail_product->product_id}}">
<input type="hidden" id="viewed_productname{{$detail_product->product_id}}" value="{{$detail_product->product_name}}">
<input type="hidden" id="viewed_productprice{{$detail_product->product_id}}" value="{{$detail_product->product_price}}">
<input type="hidden" id="viewed_producturl{{$detail_product->product_id}}" value="{{url('chi-tiet-san-pham/'.$detail_product->product_id)}}">
<input type="hidden" id="viewed_productimage{{$detail_product->product_id}}" value="{{$detail_product->product_image}}">
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="{{url('/trang-chu')}}">Trang chủ</a></li>
                    <li><a href="{{url('danh-muc-san-pham/'.$category_id)}}">{{$detail_product->category->category_name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$meta_title}}</li>
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
            <!-- Product main img -->
            <div class="col-md-5 col-md-push-2">
                <div id="product-main-img">
                    @foreach($detail_product->images as $image)
                    <div class="product-preview">
                        <img src="{{$image->imageUrl}}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- /Product main img -->

            <!-- Product thumb imgs -->
            <div class="col-md-2  col-md-pull-5">
                <!-- {{count($detail_product->images)}} -->
                <div id="product-imgs">
                    @foreach($detail_product->images as $image)
                    <div class="product-preview">
                        <img src="{{$image->imageUrl}}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- /Product thumb imgs -->

            <!-- Product details -->

            <form>
                @csrf
            </form>
            <input type="hidden" value="{{$detail_product->product_id}}" class="cart_product_id_{{$detail_product->product_id}}">
            <input type="hidden" value="{{$detail_product->product_name}}" class="cart_product_name_{{$detail_product->product_id}}">
            <input type="hidden" value="{{$detail_product->product_image}}" class="cart_product_image_{{$detail_product->product_id}}">
            <input type="hidden" value="{{$detail_product->product_price}}" class="cart_product_price_{{$detail_product->product_id}}">
            <input type="hidden" value="{{$detail_product->product_quantity}}" class="product_qty_{{$detail_product->product_id}}">
            <input type="hidden" value="{{$detail_product->product_quantity}}" id="soluongcon" class="cart_product_qty_{{$detail_product->product_id}}">

            <div class="col-md-5">
                <div class="product-details">
                    <h2 class="product-name">{{$detail_product->product_name}}</h2>
                    <div>
                        <div class="product-rating avg-rating-stars rating-stars">
                        </div>
                        <a class="review-link" href="#"><span class="ratingLengh"></span> Đánh giá</a>
                    </div>
                    <div>
                        <h3 class="product-price">{{number_format($detail_product->product_price,0,',','.')}} VNĐ<del class="product-old-price">{{number_format($detail_product->product_price,0,',','.')}} VNĐ</del></h3>
                        <span class="product-available">In Stock</span>
                    </div>
                    <div class="add-to-cart">
                        <div class="qty-label">
                            <span>Mua</span>
                            <input oninput="checkQty()" style="width: 100px;" name="qty" id="qty_product" class="quantity_cart" type="number" value="1" min="1" max="{{$detail_product->product_quantity}}" />
                        </div>
                        <!--  onclick="Addtocart(this.id);" -->
                        <button class="add-to-cart-btn" id="{{$product->product_id}}" onclick="Addtocart(this.id)" data-id="{{$product->product_id}}"><i class="fa fa-shopping-cart"></i> add to cart</button>
                        <!-- <button class="add-to-cart-btn " id="add-to-cart" data-id_product="{{$detail_product->product_id}}" name="add-to-cart">
                            <i class="fa fa-shopping-cart"></i>
                            <span>add to cart </span>
                        </button> -->
                    </div>

                    <ul class="product-btns">
                        <li><button class="add-to-wishlist" id="{{$product->product_id}}" data-product_name="{{$product->product_name}}" onclick="add_wistlist(this.id)"><i class="fa fa-heart-o"></i></button></li>
                        <li><button class="add-to-compare" id="{{$product->product_id}}" data-toggle="modal" onclick="add_compare(this.id)" data-target="#compareModal"><i class="fa fa-exchange"></i></button></li>
                        <!--  -->
                        <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                        <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                        <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                        <input type="hidden" id="wishlist_productprice{{$product->product_id}}" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                        <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
                        <input type="hidden" value="{{$product->product_quantity}}" class="product_qty_{{$product->product_id}}">
                        <input type="hidden" id="wishlist_productdesc{{$product->product_id}}" value="{{$product->product_desc}}" class="cart_product_desc_{{$product->product_id}}">
                        <!--  -->
                    </ul>

                    <ul class="product-links">
                        <li>Category:</li>
                        <li><a href="#">{{$detail_product->category->category_name}}</a></li>
                    </ul>

                    <ul class="product-links">
                        <li>Share:</li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                    </ul>

                </div>
            </div>
            <!-- /Product details -->

            <!-- Product tab -->
            <div class="col-md-12">
                <div id="product-tab">
                    <!-- product tab nav -->
                    <ul class="tab-nav">
                        <li class="active"><a data-toggle="tab" href="#description">Mô tả sản phẩm</a></li>
                        <li><a data-toggle="tab" href="#rating">Đánh giá & Bình luận (<span class="ratingLengh"></span>)</a></li>
                    </ul>
                    <!-- /product tab nav -->

                    <!-- product tab content -->
                    <div class="tab-content">
                        <!-- tab2  -->
                        <div id="rating" class="tab-pane fade in">
                            <div class="row">
                                <!-- Rating -->
                                <div class="col-md-3">
                                    <div id="rating">
                                        <div class="rating-avg">
                                            <span id="avgRating"></span>
                                            <div class="rating-stars avg-rating-stars">

                                            </div>
                                        </div>
                                        <ul class="rating">
                                            @for($i = 5; $i > 0; $i--)
                                            <li>
                                                <div class="rating-stars" id="rating-stars_{{$i}}">
                                                </div>
                                                <div class="rating-progress rating-progress_{{$i}}">
                                                    <div id="progressPercent_{{$i}}"></div>
                                                </div>
                                                <span id="rating_total_{{$i}}"></span>
                                            </li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                                <!-- /Rating -->

                                <!-- Reviews -->
                                <div class="col-md-6">
                                    <div id="reviews">
                                        <ul class="reviews rate_content">
                                        </ul>
                                    </div>
                                </div>
                                <!-- /Reviews -->

                                <!-- Review Form -->
                                <div class="col-md-3">
                                    <div id="review-form">
                                        <div class="review-form">
                                            @if (!$user)
                                            <input class="input user_name" type="text" placeholder="Tên">
                                            <input class="input user_email" type="email" placeholder="Email">
                                            @else
                                            <input class="input user_id" type="hidden" value="{{$user->id}}">
                                            <input class="input user_name" type="hidden" value="{{$user->name}}">
                                            <input class="input user_email" type="hidden" value="{{$user->email}}">
                                            <div class="input-rating">
                                                <span>Đánh giá của bạn: </span>
                                                <div class="stars" id="stars">
                                                    <input id="star5" name="rating" value="5" type="radio" checked><label for="star5"></label>
                                                    <input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
                                                    <input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
                                                    <input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
                                                    <input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
                                                </div>
                                            </div>
                                            @endif
                                            <textarea class="input comment_content" placeholder="Bình luận của bạn"></textarea>

                                            <button class="primary-btn send-comment" style="float:right">Gửi đánh giá</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Review Form -->
                            </div>
                        </div>
                        <!-- tab1  -->
                        <div id="description" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="node-inner">
                                        {!!$detail_product->product_desc!!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /tab1  -->
                    </div>
                    <!-- /product tab content  -->
                </div>
            </div>
            <!-- /product tab -->
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
    @csrf
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endsection