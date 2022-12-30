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
                        @if(Session::get('cart'))
                        @php
                        $total = 0;
                        @endphp
                        @foreach(Session::get('cart') as $key => $cart)
                        @php
                        $subtotal = $cart['product_price']*$cart['product_qty'];
                        $total+=$subtotal;
                        @endphp
                        <tr>
                            <td class="cart_product">
                                <img src="{{$cart['product_image']}}" width="90" alt="{{$cart['product_name']}}" />
                            </td>
                            <td class="cart_description">
                                <h4><a href=""></a></h4>
                                <p style="text-align: left; margin-bottom:10px">{{$cart['product_name']}}</p>
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
                                    {{number_format($subtotal,0,',','.')}} VND
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
@if(Session::get('cart'))
<section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li style="background: none;">
                            <form method="POST" action="{{URL::to('/check-coupon')}}">
                                {{ csrf_field() }}
                                @if(!Session::get('coupon'))
                                <td class="td_input_coupon"><input type="text" class="input_coupon" name="coupon" placeholder="Nhập mã giảm giá"></td>
                                <td><input type="submit" class="btn btn-danger check_coupon" name="check_coupon" value="Áp dụng mã giảm giá"></td>
                                @endif
                            </form>
                        </li>
                        <li>Tổng tiền :<span>{{number_format($total,0,',','.')}} VND</span></li>
                        @if(Session::get('coupon'))
                        @foreach(Session::get('coupon') as $key => $cou)
                        @if($cou['coupon_condition'] == 1)
                        @php
                        $total_coupon = ($total*$cou['coupon_number']) / 100;
                        @endphp
                        @else
                        @php
                        $total_coupon = $cou['coupon_number'];
                        @endphp
                        @endif
                        <li>Giảm giá :
                            <span style="display: inline;"> - {{number_format($total_coupon,0,',','.')}} VND
                                <a class="check_out" href="{{url('/unset-coupon')}}"><i style="font-size: 20px;" class="fa fa-times text-danger text"></i></a></span>
                        </li>

                        <li>Thành tiền: <span>{{number_format($total - $total_coupon,0,',','.')}} VND</span></li>
                        @endforeach
                        @endif
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