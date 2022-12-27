@extends('layout')
@section('content')
<div class="col-sm-3">
    <div class="left-sidebar">
        @include('user.elements.left_sidebar')
        <label for="amount">Lọc giá</label>
        <form>
            <div id="slider-range"></div>
            <div class="style-range"></div>
            <input type="text" name="amount_start" id="amount_start" disabled readonly style="border:0; color:#f6931f;background: none; font-weight:bold; width: 50%; ">
            <input type="text" name="amount_end" id="amount_end" disabled readonly style="border:0;background: none; color:#f6931f; font-weight:bold; width: 40%; float: right; padding: 0;">
            <input type="hidden" name="start_price" id="start_price">
            <input type="hidden" name="end_price" id="end_price">
            <input type="submit" style="border: 1px solid black; width: auto; height: auto" name="filter_price" value="Lọc theo giá" class="btn btn-sm btn-defalut">
        </form>
    </div>
</div>
<div class="col-sm-9 padding-right">
    @foreach($category_name as $key => $name)
    <h2 class="title text-center">{{$name->category_name}}</h2>
    @endforeach
    <div class="features_items">
        <div class="col-md-3">

        </div>
        <div class="col-md-3" style="float: right; margin-bottom: 10px">
            <form style=" border: 1px solid black;">
                @csrf
                <select name="sort" id="sort" class="form-control">
                    <option value="{{Request::url()}}?sort_by=none">---Lọc---</option>
                    <option value="{{Request::url()}}?sort_by=tang_dan">---Giá tăng dần---</option>
                    <option value="{{Request::url()}}?sort_by=giam_dan">---Giá giảm dần---</option>
                    <option value="{{Request::url()}}?sort_by=kytu_az">---A đến Z---</option>
                    <option value="{{Request::url()}}?sort_by=kytu_za">---Z đến A---</option>
                </select>
            </form>
        </div>
    </div>
    <div class="features_items">
        <!--features_items-->
        <div class="row">
            @foreach($category_by_id as $key => $product)
            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <a id="wishlist_producturl{{$product->product_id}}" href="{{URL::to('chi-tiet-san-pham/'.$product->product_id)}}">
                                <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" width="200px" height="250px" alt="" />
                                <h2>{{ $product->product_name}}</h2>
                                <p>{{ number_format($product->product_price).' '.'VND'}}</p>
                            </a>

                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ Hàng</a>
                        </div>
                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <!--features_items-->
    </div>

    <!-- <div class="row">
            <div class="col-md-12">
                   <label for="amount">Lọc danh mục theo</label><br>
                   @php
                        $category_id =  [];
                        $category_arr = [];
                        if(isset($_GET['cate'])){
                            $category_id = $_GET['cate'];
                        }else{
                            $category_id = $name->category_id.",";
                        }
                        $category_arr = explode(",", $category_id);
                   @endphp

                   @foreach($category   as $key => $cate)
                        <label class="checkbox-inline">
                            <input type="checkbox"
                            {{in_array($cate->category_id,$category_arr) ? 'checked' : ''}}
                            data-filters = "category" name="category-filter" value="{{$cate->category_id}}" class="category-filter">
                                {{$cate->category_name  }}
                        </label>

                   @endforeach<br>
               </div>
        </div> -->
    {!! $category_by_id->links("pagination::bootstrap-4") !!}
    @endsection