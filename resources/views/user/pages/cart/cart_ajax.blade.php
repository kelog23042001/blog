@extends('layout')
@section('content')
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="{{url('/trang-chu')}}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$meta_title}}</li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->
<section id="cart_items">
    <div class="container">

        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @elseif (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
        @endif
        <div class="table-responsive cart_info">
            <form action="{{URL::to('/update-cart')}}" method="POST">
                @csrf
                <table class="table table-condensed">
                    @if(Session::get('cart'))
                    @csrf
                    <thead>
                        <td colspan="4"></td>
                        <td><input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="btn btn-warning check_out"></td>
                        <td><a class="btn btn-danger check_out" href="{{url('/delete-all-product')}}">Xoá tất cả</a></td>
                    </thead>
                    @endif
                    <thead>
                        <tr class="cart_menu">
                            <td class="image" style="padding: 0;">Hình ảnh</td>
                            <td class="description">Tên sản phẩm</td>
                            <td class="price">Giá sản phẩm</td>
                            <td class="quantity">Số lượng</td>
                            <td class="total">Thành tiền</td>
                            <td class="function"></td>
                        </tr>
                    </thead>
                    <tbody>
                        @if($cart)

                        @foreach(Session::get('cart') as $key => $cart)
                        <tr>
                            <td class="cart_product">
                                <img src="{{$cart['product_image']}}" width="90" alt="{{$cart['product_name']}}" />
                            </td>
                            <td class="cart_description">
                                <a href="">{{$cart['product_name']}}</a>
                            </td>
                            <td class="cart_price">
                                <p>{{number_format($cart['product_price'],0,',','.')}} VNĐ</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <input class="cart_quantity_" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}">
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">
                                    {{number_format($cart['product_price']*$cart['product_qty'],0,',','.')}} VND
                                </p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" href="{{url('/del-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                        </tr>
                        @else
                        <tr>
                            <td colspan="5">
                                <center>
                                    @php
                                    echo "Chưa có sản phẩm trong giỏ hàng";
                                    @endphp
                                </center>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</section>
<!--/#cart_items-->
@if($cart)
<section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Tổng tiền: <span>{{number_format($total,0,',','.')}} VND</span></li>
                    </ul>
                    @if(Session::get('customer_id'))
                    <a class="btn btn-warning check_out" href="{{url('/checkout')}}">Đặt hàng</a>
                    @else
                    <a class="btn btn-warning check_out" href="{{url('/checkout')}}">Đặt hàng</a>
                    <!-- <a class="btn btn-warning check_out" href="{{url('/login-checkout')}}">Đặt hàng</a> -->
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<style>
    p {
        margin: 0;
    }
</style>
@endsection