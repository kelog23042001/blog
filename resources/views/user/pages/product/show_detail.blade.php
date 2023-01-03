@extends('layout')
@section('content')
<?php

use Illuminate\Support\Facades\Auth;

$user = Auth::user();

function showRate($rating)
{
    for ($i = 0; $i < 5; $i++) {
        if ($i < $rating) {
            echo '<i class="fa fa-star"></i>';
        } else {
            echo '<i class="fa fa-star-o"></i>';
        }
    }
}
function countStarsRating($stars, $rates)
{
    $count = 0;
    foreach ($rates as $key => $rate) {
        if ($rate->rating == $stars) {
            $count++;
        }
    }
    return $count;
}

function percentageStarsRate($stars, $rates)
{
    $sum = $rates->count('rating_id');
    $count = countStarsRating($stars, $rates);
    if ($count != 0)
        return ($count / $sum) * 100;
    return 0;
}

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
                        <div class="product-rating">
                            @php
                            showRate(round($rating, 0, PHP_ROUND_HALF_DOWN))
                            @endphp
                        </div>
                        <a class="review-link" href="#">10 Review(s) | Add your review</a>
                    </div>
                    <div>
                        <h3 class="product-price">{{number_format($detail_product->product_price,0,',','.')}} VNĐ<del class="product-old-price">{{number_format($detail_product->product_price,0,',','.')}} VNĐ</del></h3>
                        <span class="product-available">In Stock</span>
                    </div>
                    <!-- <div class="product-options">
                        <label>
                            Size
                            <select class="input-select">
                                <option value="0">X</option>
                            </select>
                        </label>
                        <label>
                            Color
                            <select class="input-select">
                                <option value="0">Red</option>
                            </select>
                        </label>
                    </div> -->

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
                        <li><a href="#"><i class="fa fa-heart-o"></i> add to wishlist</a></li>
                        <li><a href="#"><i class="fa fa-exchange"></i> add to compare</a></li>
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
                        <li><a data-toggle="tab" href="#rating">Đánh giá & Bình luận ({{count($rates)}})</a></li>
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
                                            <span>{{$rating}}</span>
                                            <div class="rating-stars">
                                                @php
                                                showRate(round($rating, 0, PHP_ROUND_HALF_DOWN))
                                                @endphp
                                            </div>
                                        </div>
                                        <ul class="rating">
                                            @for($i = 5; $i > 0; $i--) <!-- -->
                                            <li>
                                                <div class="rating-stars">
                                                    <?php echo showRate($i) ?>
                                                </div>
                                                <div class="rating-progress">
                                                    <div style="width: <?php echo percentageStarsRate($i, $rates) ?>%"></div>
                                                </div>
                                                <span class="sum"><?php echo (countStarsRating($i, $rates)) ?></span>
                                            </li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                                <!-- /Rating -->

                                <!-- Reviews -->
                                <div class="col-md-6">
                                    <div id="reviews">
                                        <ul class="reviews">
                                            @foreach ($rates as $key=> $review)
                                            <li>
                                                <div class="review-heading">
                                                    <h5 class="name">{{$review->user->name}}</h5>
                                                    <p class="date">{{$review->created_at}}</p>
                                                    <div class="review-rating">
                                                        @for ($i = 0; $i < $review->rating; $i++) <!-- -->
                                                            <i class="fa fa-star"></i>
                                                            @endfor
                                                            <!-- <i class="fa fa-star-o empty"></i> -->
                                                    </div>
                                                </div>
                                                <div class="review-body">
                                                    <p>
                                                        <?php
                                                        if (empty($review->comment)) {
                                                            echo 'Người dùng không bình luận gì!';
                                                        } else {
                                                            echo $review->comment;
                                                        }
                                                        ?>
                                                    </p>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <!-- {{ $rates->links() }} -->
                                        <!-- <ul class="reviews-pagination">
                                            <li class="active">1</li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                        </ul> -->
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
<style>
    .node-inner ul li {
        list-style-type: disc;
    }
</style>
@endsection