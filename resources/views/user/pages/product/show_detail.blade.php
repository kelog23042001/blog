@extends('layout')
@section('content')

@foreach($detail_product as $key=> $value)
<div class="product-details"><!--product-details-->
    <div class="col-sm-5">
        <style>
            .lSSlideOuter .lSPager.lSGallery img {
                display: block;
                height: 50px;
                max-width: 100%;
            }
        </style>
        <ul id="imageGallery">
            <li data-thumb="{{asset('frontend/images/product-details/luffy2.jpg')}}" data-src="{{asset('frontend/images/product-details/luffy2.jpg')}}">
                <img width="100%" src="{{asset('frontend/images/product-details/luffy2.jpg')}}" />
            </li>
            <li data-thumb="{{asset('frontend/images/product-details/luffy3.jpg')}}" data-src="{{asset('frontend/images/product-details/luffy3.jpg')}}">
                <img width="100%"  src="{{asset('frontend/images/product-details/luffy3.jpg')}}" />
            </li>
            <li data-thumb="{{asset('frontend/images/product-details/luffy4.jpg')}}" data-src="{{asset('frontend/images/product-details/luffy4.jpg')}}">
                <img width="100%" src="{{asset('frontend/images/product-details/luffy4.jpg')}}" />
            </li>

        </ul>
        <!-- <div class="view-product">
            <img src="{{URL::to('public/uploads/product/'.$value->product_image)}}" alt="{{URL::to('public/uploads/product/'.$value->product_image)}}" />
        </div>
        <div id="similar-product" class="carousel slide" data-ride="carousel"> -->
                <!-- Wrapper for slides -->
                <!-- <div class="carousel-inner">
                    <div class="item active">
                        <a href=""><img src="{{URL::to('frontend/images/product-details/similar1.jpg')}}" alt=""></a>
                        <a href=""><img src="{{URL::to('frontend/images/product-details/similar2.jpg')}}" alt=""></a>
                        <a href=""><img src="{{URL::to('frontend/images/product-details/similar3.jpg')}}" alt=""></a>
                    </div>
                </div> -->
                <!-- Controls -->
                <!-- <a class="left item-control" href="#similar-product" data-slide="prev">
                <i class="fa fa-angle-left"></i>
                </a>
                <a class="right item-control" href="#similar-product" data-slide="next">
                <i class="fa fa-angle-right"></i>
                </a>
        </div> -->

    </div>

    <div class="col-sm-7">
        <div class="product-information"><!--/product-information-->
            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
            <h2>{{$value->product_name}}</h2>
            <p>Mã Sản Phẩm: {{$value->product_id}}</p>
            <img src="images/product-details/rating.png" alt="" />
            <form>
                @csrf
                <span>
                    <span>{{number_format($value->product_price).' '.'VND'}}</span>
                    <label>Số lượng :</label>
                    <input name = "qty" type="number" value="1" min = "1" max = {{$value->product_quantity}}/>
                    <input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">
                    <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">
                    <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">
                    <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">
                    <input type="hidden" value="1" class="cart_product_qty_{{$value->product_id}}">
                    </br>
                    <button type="button" class="btn btn-default add-to-cart"
                    data-id_product="{{$value->product_id}}" name="add-to-cart">
                    <i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                </span>
            </form>
            @if( $value->product_quantity > 0)
                <p><b>Tình Trạng:</b> Còn Hàng</p>
            @else
                <p><b>Tình Trạng:</b> Hết Hàng</p>
            @endif
            <p><b>Thương Hiệu :</b> {{$value->brand_name}}</p>
            <p><b>Danh Mục :</b> {{$value->category_name}}</p>
            <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->

<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Mô Tả</a></li>
            <li><a href="#reviews" data-toggle="tab">Đánh Giá</a></li>
            <li><a href="#comment" data-toggle="tab">Bình Luận</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="details" >
            <p>{!!$value->product_desc!!}</p>
        </div>

        <div class="tab-pane fade " id="reviews" >
            <div class="col-sm-12">
                <!-- <ul>
                    <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                    <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                    <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                </ul> -->
                <!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p> -->
                <p><b>Viết Đánh Giá Của Bạn</b></p>

                <form action="#">
                    <span>
                        <input type="text" placeholder="Tên"/>
                        <input type="email" placeholder="Gmail"/>
                    </span>
                    <textarea name="" ></textarea>
                    <b>Đánh Giá: </b> <img src="images/product-details/rating.png" alt="" />
                    <button type="button" class="btn btn-default pull-right">
                        Gửi
                    </button>
                </form>
            </div>
        </div>
        <div class="tab-pane fade " id="comment" >
            <div class="col-sm-12">
            <div class="fb-comments" data-href="{{$url_canonical}}" data-width="" data-numposts="5"></div>
            </div>
        </div>
    </div>
</div><!--/category-tab-->
@endforeach
<div class="recommended_items"><!--recommended_items-->
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
</div><!--/recommended_items-->
@endsection
