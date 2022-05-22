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

        <div class="price-range"><!--price-range-->
            <h2>Price Range</h2>
            <div class="well text-center">
                    <input type="text" class="span2" value="" data-    -min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
                    <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
            </div>
        </div><!--/price-range-->
    </div>
</div>

<div class="col-sm-9 padding-right">
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center" style="margin-top : 16px">Sản Phẩm Mới Nhất</h2>
        @foreach($product as $key => $product)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                        <div class="productinfo text-center">
                            <form>
                                @csrf
                                <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">

                                <a href="{{URL::to('chi-tiet-san-pham/'.$product->product_id)}}">

                                    <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                                    <h2>{{ number_format($product->product_price).' '.'VND'}}</h2>
                                    <p>{{ $product->product_name}}</p>
                                </a>
                                <button type="button" class="btn btn-default add-to-cart"
                                    data-id_product="{{$product->product_id}}" name="add-to-cart">Thêm giỏ hàng</button>
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
    </div><!--features_items-->
</div>
@endsection
