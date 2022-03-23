@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Mới Nhất</h2>
    @foreach($product as $key => $product)
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                <a href="{{URL::to('chi-tiet-san-pham/'.$product->product_id)}}">
                    <div class="productinfo text-center">
                        <img src="{{URL::to('uploads/product/'.$product->product_image)}}" alt="" />
                        <h2>{{ $product->product_price}}</h2>
                        <p>{{ $product->product_name}}</p>
                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ Hàng</a>
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
</div><!--features_items-->

@endsection