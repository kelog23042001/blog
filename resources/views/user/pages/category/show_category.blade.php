 @extends('layout')
@section('content')

<div class="features_items"><!--features_items-->

    @foreach($category_name as $key => $category_name)
        <h2 class="title text-center">{{$category_name->category_name}}</h2>
    @endforeach

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
                </form>
           </div>
           <div class="col-md-4">
                <label for="amount">Lọc giá theo</label>
                <form>
                    <div id="slider-range"></div>
                </form>
           </div>
    </div>
</div><!--features_items-->


@endsection
