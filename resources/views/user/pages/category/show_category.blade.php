@extends('layout')
@section('content')

<div class="features_items"><!--features_items-->

    @foreach($category_name as $key => $category_name)
        <h2 class="title text-center">{{$category_name->category_name}}</h2>
    @endforeach
            <div class="col-md-4">
                <label for="amount">Lọc giá theo</label>
                <form>

                    <div id="slider-range"></div>
                    <div class="style-range" ></div>
                    <!-- <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;"> -->
                    <input type="text" name="amount_start" id="amount_start" readonly style="border:0; color:#f6931f; font-weight:bold;">
                    <input type="text" name="amount_end" id="amount_end" readonly style="border:0; color:#f6931f; font-weight:bold;">
                    <input type="hidden" name="start_price" id="start_price" >
                    <input type="hidden" name="end_price" id="end_price" >
                    <br>
                    <input type="submit" name="filter_price" value="Lọc theo giá" class="btn btn-sm btn-defalut">
                </form>
           </div>
        <div class="row">
            <div class="col-md-4">
                <label for="amount">Sắp xếp theo </label>
                <form>
                    @csrf
                <select name="sort"id="sort"class="form-control">
                    <option value="{{Request::url()}}?sort_by=none">---Lọc---</option>
                    <option value="{{Request::url()}}?sort_by=tang_dan">---Giá tăng dần---</option>
                    <option value="{{Request::url()}}?sort_by=giam_dan">---Giá giảm dần---</option>
                    <option value="{{Request::url()}}?sort_by=kytu_az">---A đến Z---</option>
                    <option value="{{Request::url()}}?sort_by=kytu_za">---Z đến A---</option>
                </select>
                </form>
           </div>
           <div class="col-md-4">
                <label for="amount">Lọc giá theo</label>
                <form>
                    <div id="slider-range"></div>
                </form>
           </div>
    </div>
    @foreach($category_by_id as $key => $product)
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                            <h2>{{ number_format($product->product_price).' '.'VND'}}</h2>
                            <p>{{ $product->product_name}}</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ Hàng</a>
                        </div>
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
