@extends('layout')
@section('content')
<div class="col-sm-3">
    <div class="left-sidebar">
        @include('user.elements.left_sidebar')
    </div>
</div>
<div class="col-sm-9 padding-right">
    @foreach($category_name as $key => $name)
    <h2 class="title text-center">{{$name->category_name}}</h2>
    @endforeach
    <div class="features_items">
        <!-- <div class="price-range">
            <div class="text-center">
                <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2"><br />
                <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
            </div>
        </div> -->
        <div class="col-md-4">
            <label for="amount">Lọc giá</label>
            <form>
                <div id="slider-range"></div>
                <div class="style-range"></div>
                <!-- <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;"> -->
                <input type="text" name="amount_start" id="amount_start" disabled readonly style="border:0; color:#f6931f;background: none; font-weight:bold; width: 50%; ">
                <input type="text" name="amount_end" id="amount_end" disabled readonly style="border:0;background: none; color:#f6931f; font-weight:bold; width: 40%; float: right;">
                <input type="hidden" name="start_price" id="start_price">
                <input type="hidden" name="end_price" id="end_price">
                <input type="submit" name="filter_price" value="Lọc theo giá" class="btn btn-sm btn-defalut">
            </form>
        </div>
        <div class="col-md-4" style="float: right;">
            <label for="amount">Sắp xếp </label>
            <form>
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
</div>
@endsection