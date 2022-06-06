@extends('layout')
@section('content')
<?php

use Illuminate\Support\Facades\Session;
?>
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Home</a></li>
                <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div>
        @if(!Session::get('customer_id'))
        <div class="register-req">
            <p>Bạn chưa đăng nhập</p>
        </div>
        @endif

        <div class="shopper-informations">
            <div class="row">
                <div class="col-sm-12 clearfix">
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @elseif (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="table-responsive cart_info">
                <form action="{{URL::to('/update-cart')}}" method="POST">
                    {{ csrf_field() }}
                    <table class="table table-condensed">
                        @if(Session::get('cart'))
                        @csrf
                        @if(!Session::get('pay_success'))
                        <thead>
                            <td colspan="4"></td>
                            <td><input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="btn btn-warning check_out"></td>
                            <td><a class="btn btn-danger check_out" href="{{url('/delete-all-product')}}">Xoá tất cả</a></td>
                        </thead>
                        @endif
                        @endif
                        <thead>
                            <tr class="cart_menu">
                                <td class="image">Hình ảnh</td>
                                <td class="description">Tên sản phẩm</td>
                                <td class="price">Giá sản phẩm</td>
                                <td class="quantity">Số lượng</td>
                                <td class="total">Thành tiền</td>
                                <td></td>
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

                            <?php
                            $total_after_fee = $total + Session::get('fee');
                            ?>
                            <tr>
                                <td class="cart_product">
                                    <img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" width="90" alt="{{$cart['product_name']}}" />
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
                                        @if(!Session::get('pay_success'))
                                        <input class="cart_quantity_" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}">
                                        @else
                                        <input class="cart_quantity_" type="number" readonly min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}">
                                        @endif
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
                </form>
                @if(Session::get('cart'))
                <tr>
                    <!-- <td>
                        <form method="POST" action="{{URL::to('/check-coupon')}}">
                            {{ csrf_field() }}
                            <input type="text" class="form-control" name="coupon" placeholder="Nhập mã giảm giá"><br>
                            <input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Tính mã giảm giá" href="">
                        </form>
                    </td> -->
                    @if(!Session::get('pay_success'))
                    <td>
                        @php
                        $vnd_to_usd = $total_after_fee/23220;
                        $total_paypal = round($vnd_to_usd, 2);
                        \Session::put('total_paypal', $total_paypal)
                        @endphp
                        <!-- <div id="paypal-button"></div> -->
                        <a class="btn btn-default checkout m-3" href="{{ route('processTransaction') }}">Paypal</a>
                        <input type="hidden" id="vnd_to_usd" value="{{round($vnd_to_usd, 2)}}">
                    </td>
                    <td>
                        <form action="{{url('/vnpay_payment')}}" method="POST">
                            @csrf
                            <input type="hidden" name="total_vnpay" value="{{$total_after_fee}}">
                            <button type="submit" class="btn btn-default checkout m-3" name="redirect" href="">VNPay</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{url('/momo_payment')}}" method="POST">
                            @csrf
                            <input type="hidden" name="total_momopay" value="{{$total_after_fee}}">
                            <button type="submit" class="btn btn-default checkout m-3" name="payUrl" href="">MomoPay</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endif
                </table>
            </div>
        </div>
    </div>
</section>
@if(Session::get('cart'))
<section id="do_action" style="margin: 0;">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="total_area" style="margin: 0;">
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
                        <?php $total_coupon = 0 ?>
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
                                @if(!Session::get('pay_success'))
                                <a class="check_out" href="{{url('/unset-coupon')}}">
                                    <i style="font-size: 20px;" class="fa fa-times text-danger text"></i>
                                </a>
                                @endif
                            </span>
                        </li>

                        @endforeach
                        @endif

                        @if(Session::get('fee'))
                        <li>Phí giao hàng :
                            <span class="feeCheckout" style="display: inline;"> + {{number_format(Session::get('fee'),0,',','.')}} VND
                            </span>
                        </li>
                        @endif
                        <li>Thành tiền:
                            @if(!Session::get('pay_success'))
                            <span>{{number_format($total_after_fee - $total_coupon,0,',','.')}} VND</span>
                            @else
                            <span>0 VND</span>
                            @endif
                        </li>
                        <li>Đã thanh toán:
                            @if(Session::get('pay_success'))
                            <span>{{number_format($total_after_fee - $total_coupon,0,',','.')}} VND</span>
                            @else
                            <span>0 VND</span>
                            @endif
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<div class="col-sm-12 clearfix">
    <div class="bill-to">
        <p>Điền thông tin gửi hàng</p>
        <div class="form-one">
            @if(\Session::has('error'))
            <div class="alert alert-danger">{{ \Session::get('error') }}</div>
            {{ \Session::forget('error') }}
            @endif
            @if(\Session::has('success'))
            <div class="alert alert-success">{{ \Session::get('success') }}</div>
            {{ \Session::forget('success') }}
            @endif
            <form method="POST">
                @csrf
                @if(Session::get('customer_id'))
                <input type="text" name="shipping_email" class="shipping_email" placeholder="Email*" required value="{{Session::get('customer_email')}}">
                <input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên" required value="{{Session::get('customer_name')}}">
                <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Phone" required value="{{Session::get('customer_phone')}}">
                @if(Session::get('wards'))
                    <?php 
                        $address = $customer->customer_address.', '.Session::get('wards').', '.Session::get('province').', '.Session::get('city') ;
                    ?>
                    <input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ" value="{{$address}}" required>
                @else
                    <input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ" value="{{$customer->customer_address}}" required>
                @endif
                @else
                <input type="text" name="shipping_email" class="shipping_email" placeholder="Email*" required>
                <input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên" required>
                <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Phone" required>
                <input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ" required>
                @endif

                <textarea name="shipping_notes" class="shipping_notes" placeholder="Ghi chú đơn hàng của bạn" rows="5"></textarea>

                @if(Session::get('fee'))
                <input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
                @else
                <input type="hidden" name="order_fee" class="order_fee" value="20000">
                @endif
                @if(Session::get('coupon'))
                @foreach(Session::get('coupon') as $key=>$cou)
                <input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
                @endforeach
                @else
                <input type="hidden" name="order_coupon" value="non" class="order_coupon">
                @endif
                <div class="">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Phương thức thanh toán</label>
                        @if(!Session::get('pay_success'))
                        <select name="payment_select" class="form-control input-sm m-bot15 payment_select ">
                            <option value="1">Thanh toán khi nhận hàng</option>
                            <option value="0">Thanh toán trực tuyến</option>
                        </select>
                        @else
                        <select name="payment_select" class="form-control input-sm m-bot15 payment_select " disabled>
                            <option value="1">Thanh toán khi nhận hàng</option>
                            <option value="0" selected>Thanh toán trực tuyến</option>
                        </select>
                        @endif
                    </div>
                </div>
                @php
                \Session::forget('pay_success');
                @endphp
                <input value="Xác nhận đơn hàng" type="button" name="send_order" class="btn btn-primary btn-sm send_order">
            </form>
        </div>
        <div class="form-two">
            <form role="form" action="{{URL::to('/save-brand-product')}}" method="post">
                {{ csrf_field()}}
                <div class="form-group">
                    <label for="exampleInputPassword1">Chọn thành phố</label>
                    <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                        <option value="">--- Chọn Tỉnh ---</option>
                        @foreach($city as $key => $ci)
                        <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Chọn quận huyện</label>
                    <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                        <option value="">--- Chọn Quận Huyện ---</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Chọn xã phường</label>
                    <select name="wards" id="wards" class="form-control input-sm m-bot15 wards ">
                        <option value="">--- Chọn Xã-Phường ---</option>
                    </select>
                </div>
                <!-- <input value="Tính phí vận chuyển" type="button" name="calculate_order" class="btn btn-primary btn-sm calculate_delivery"> -->
            </form>
        </div>
    </div>
</div>
<style>
    p {
        margin: 0;
    }
</style>
@endsection