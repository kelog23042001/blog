@extends('layout')
@section('content')

@foreach($detail_product as $key=> $value)
            <input type="hidden" id="product_viewed_id" value="{{$value->product_id}}">
            <input type="hidden" id="viewed_productname{{$value->product_id}}" value="{{$value->product_name}}">
            <input type="hidden" id="viewed_productprice{{$value->product_id}}" value="{{$value->product_price}}" >
            <input type="hidden" id="viewed_producturl{{$value->product_id}}" value="{{url('chi-tiet-san-pham/'.$value->product_id)}}">
            <input type="hidden" id="viewed_productimage{{$value->product_id}}" value="{{asset('public/uploads/product/'.$value->product_image)}}" >
<div class="product-details">
    <!--product-details-->
    <div class="col-sm-5">
        <style>
            .lSSlideOuter .lSPager.lSGallery img {
                display: block;
                height: 50px;
                max-width: 100%;
            }
        </style>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background:none ;">
                <li class="breadcrumb-item"><a href="{{url('/trang-chu')}}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{url('danh-muc-san-pham/'.$category_id)}}">{{$product_cate}}</a></li>
                <li class="breadcrumb-item"><a href="{{url('thuong-hieu-san-pham/'.$brand_id)}}">{{$product_brand}}</a></li>

                <li class="breadcrumb-item active" aria-current="page">{{$meta_title}}</li>
            </ol>
        </nav>
        <ul id="imageGallery">
            @if($gallery->isEmpty())
                <li data-thumb="{{asset('public/uploads/product/'.$value->product_image)}}" data-src="{{asset('public/uploads/product/'.$value->product_image)}}">
                <img width="100%" alt="{{$value->product_name}}" src="{{asset('public/uploads/product/'.$value->product_image)}}" />
             </li>
            @else
                @foreach($gallery as $key => $gal)
                <li data-thumb="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}" data-src="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}">
                    <img width="100%" alt="{{$gal->gallery_name}}" src="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}" />
                </li>
                @endforeach
            @endif

        </ul>
    </div>

    <div class="col-sm-7">
        <div class="product-information">
            <!--/product-information-->
            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
            <h2>{{$value->product_name}}</h2>
            <p>Mã Sản Phẩm: {{$value->product_id}}</p>
            <img src="images/product-details/rating.png" alt="" />
            <form>
                @csrf
                <span>
                    <span>{{number_format($value->product_price).' '.'VND'}}</span>
                    <label>Số lượng :</label>
                    <input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">
                    
                    <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">
                    
                    <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">
                    
                    <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">
                    
                    <input type="hidden" value="{{$value->product_quantity}}" class="product_qty_{{$value->product_id}}">
                    
                    <input oninput="checkQty()" style="width: 100px;" name="qty" id="qty_product" class="qty" type="number" value="1" min="1" max="{{$value->product_quantity}}"/>

                    <!-- <input type="hidden" value="1" class="cart_product_qty_{{$value->product_id}}"> -->

                    <input type="hidden" value="{{$value->product_quantity}}" id="soluongcon" class="cart_product_qty_{{$value->product_id}}">

                    </br>

                    <button type="button" class="btn add-to-cart" data-id_product="{{$value->product_id}}" name="add-to-cart">
                        <i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                </span>
            </form>
            @if( $value->product_quantity > 0)
            <p><b>Tình Trạng:</b> Còn Hàng( {{$value->product_quantity}} sản phẩm)</p>
            @else
            <p><b>Tình Trạng:</b> Hết Hàng</p>
            @endif
            <p><b>Thương Hiệu :</b> {{$value->brand_name}}</p>
            <p><b>Danh Mục :</b> {{$value->category_name}}</p>

            <fieldset>
                <legend>Tags</legend>
                <p><i class="fa fa-tag"></i>
                    @php
                    $tags = $value->product_tags;
                    $tags = explode(",", $tags);
                    @endphp
                    @foreach($tags as $tag)
                    <a href="{{url('/tag/'.$tag)}}" class="tags_style">{{$tag}}</a>
                    @endforeach
                </p>
            </fieldset>
            <a href=""><img src="images/product-details/share.png" class="share img-responsive" alt="" /></a>
        </div>
        <!--/product-information-->
    </div>
</div>
<!--/product-details-->

<div class="category-tab shop-details-tab">
    <!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li><a href="#details" data-toggle="tab">Mô Tả</a></li>
            <li class="active"><a href="#reviews" data-toggle="tab">Đánh Giá</a></li>
            <li><a href="#comment" data-toggle="tab">Bình Luận</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade " id="details">
            <p>{!!$value->product_desc!!}</p>
        </div>

        <div class="tab-pane fade active in" id="reviews">
            <div class="col-sm-12">
                <!-- <ul>
                    <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                    <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                    <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                </ul> -->
                <style type="text/css">
                    .style_comment {
                        border: 1px solid #ddd;
                        border-radius: 10px;
                        background: #F0F0E9;
                    }
                </style>
                <form>
                    @csrf
                    <input type="hidden" name="comment_product_id" class="comment_product_id" value="{{$value->product_id}}">
                    <div id="comment_show"></div>
                </form>

                <div id="notify_comment">
                </div>

                <p><b>Viết Đánh Giá Của Bạn</b></p>


                <ul class="list-inline rating" title="Average Rating">
                    @for($count = 1; $count<=5; $count++) @php if($count <=$rating) { $color='color:#ffcc00;' ; } else{ $color='color:#ccc;' ; } @endphp <li title="Đánh giá theo sao" id="{{$value->product_id}}-{{$count}}" data-index="{{$count}}" data-product_id="{{$value->product_id}}" data-rating="{{$rating}}" class="rating" style="cursor: pointer;{{$color}} font-size:30px;">&#9733;
                        </li>
                        @endfor
                        <li>({{$rating}}/5)</li>
                </ul>

                <form action="#">
                    <span>
                        <input class="comment_name" type="text" style="width:100%; margin-left: 0px" placeholder="Tên" />
                    </span>
                    <textarea class="comment_content" name="comment" placeholder="Nội dung"></textarea>
                    <b>Đánh Giá: </b> <img src="images/product-details/rating.png" alt="" />
                    <button type="button" class="btn btn-default pull-right send-comment">
                        Gửi
                    </button>
                </form>
            </div>
        </div>
        <div class="tab-pane fade " id="comment">
            <div class="col-sm-12">
                <div class="fb-comments" data-href="{{$url_canonical}}" data-width="" data-numposts="5"></div>
            </div>
        </div>
    </div>
</div>
<!--/category-tab-->
@endforeach
<div class="recommended_items">
    <!--recommended_items-->
    <h2 class="title text-center" style="margin-top:10px">Sản Phẩm Liên Quan</h2>
    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($related_product as $key => $related_product)
            <div class="item active">
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{URL::to('public/uploads/product/'.$related_product->product_image)}}" alt="" />
                                <h2>{{$related_product->product_price}}</h2>
                                <p>{{$related_product->product_name}}</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>
<!--/recommended_items-->
@endsection
