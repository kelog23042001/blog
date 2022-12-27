@extends('layout')
@section('content')
<div class="col-sm-3">
    <div class="left-sidebar">
        @include('user.elements.left_sidebar')
        @include('user.elements.left_sidebar.viewed')
        @include('user.elements.left_sidebar.wishlist')
    </div>
</div>

<div class="col-sm-9 padding-right">
    <div class="features_items">
        <!--features_items-->
        <h2 class="title text-center" style="margin-top : 16px">TAG TÌM KIẾM : {{$product_tag}}</h2>
        @foreach($pro_tag as $key => $product)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <form>
                            @csrf
                            <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                            <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                            <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                            <input type="hidden" id="wishlist_productprice{{$product->product_id}}" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                            <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">

                            <a id="wishlist_producturl{{$product->product_id}}" href="{{URL::to('chi-tiet-san-pham/'.$product->product_id)}}">

                                <img id="wishlist_productimage{{$product->product_id}}" width="200px" height="250px" src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                                <h2>{{ number_format($product->product_price).' '.'VND'}}</h2>
                                <p>{{ $product->product_name}}</p>
                            </a>
                            <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">Thêm giỏ hàng</button>
                        </form>
                        </form>
                    </div>
                    </a>
                </div>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#"><i class="fa fa-plus-square"></i>Xem Sau</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!--features_items-->
</div>
@endsection