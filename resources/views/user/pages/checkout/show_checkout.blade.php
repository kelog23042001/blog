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

                            @if(Session::get('cart')==true)
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
                                    <img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" width="90" alt="{{$cart['product_name']}}" />
                                </td>
                                <td class="cart_description">
                                    <h4><a href=""></a></h4>
                                    <p>{{$cart['product_name']}}</p>
                                </td>
                                <td class="cart_price">
                                    <p>{{number_format($cart['product_price'],0,',','.')}}đ</p>
                                </td>
                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        <input class="cart_quantity_" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}">
                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">
                                        {{number_format($subtotal,0,',','.')}}đ

                                    </p>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete" href="{{url('/del-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>

                            @endforeach
                            <tr>
                                <td>
                                    <input type="submit" value="Cập nhật" name="update_qty" class="check_out btn-default btn-sm">
                                </td>
                                <td>
                                    <a class="btn btn-default check_out" href="{{url('/delete-all-product')}}">Xoá tất cả</a>

                                </td>
                                @if(Session::get('coupon'))
                                <td>
                                    <a class="btn btn-default check_out" href="{{url('/unset-coupon')}}">Xoá mã giảm giá</a>

                                </td>
                                @endif
                                <td>
                                    <li>Tổng: <span>{{number_format($total,0,',','.')}}đ</span></li>
                                    @if(Session::get('coupon'))
                                    <li>
                                        @foreach(Session::get('coupon') as $key => $cou)
                                        @if($cou['coupon_condition'] == 1)
                                        Mã giảm :{{$cou['coupon_number']}} %
                                        <p>
                                            @php
                                            $total_coupon = ($total*$cou['coupon_number']) / 100;

                                            @endphp
                                        </p>
                                        <p>@php
                                            $total_after_coupon = $total - $total_coupon;
                                            @endphp</p>
                                        @else
                                        Mã giảm :{{number_format($cou['coupon_number'],0,',','.')}}đ
                                        <p>
                                            @php
                                            $total_coupon = $total - $cou['coupon_number'];
                                            @endphp
                                        </p>
                                        @php
                                        $total_after_coupon = $total_coupon;
                                        @endphp
                                        @endif
                                        @endforeach
                                    </li>
                                    @endif

                                    <!-- <li>Thuế: <span></span></li> -->
                                    @if(Session::get('fee'))

                                    <li>
                                        <a class="cart_quantity_delete" href="{{url('/del-fee')}}"><i class="fa fa-times"></i></a>

                                        Phí Vận Chuyển: <span>{{number_format(Session::get('fee'),0,',','.')}}</span>
                                    </li>

                                    <?php

                                    $total_after_fee = $total - Session::get('fee');
                                    ?>
                                    @endif

                                    <li>
                                        Tổng số tiền:
                                        @php
                                        if(Session::get('fee') && !Session::get('coupon')){
                                        $total_after = $total_after_fee;
                                        echo number_format($total_after,0,',','.').' VND';
                                        }else if(!Session::get('fee') && Session::get('coupon')){
                                        $total_after = $total_after_coupon + Session::get('fee');
                                        echo number_format($total_after,0,',','.').' VND';

                                        }else if(Session::get('fee') && Session::get('coupon')){
                                        $total_after = $total_after_coupon;
                                        $total_after = $total_after + Session::get('fee');
                                        echo number_format($total_after,0,',','.').' VND';

                                        }else if(!Session::get('fee') && !Session::get('coupon')){
                                        $total_after = $total;
                                        echo number_format($total_after,0,',','.').' VND';

                                        }
                                        @endphp
                                    </li>


                                </td>

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
                    <td>
                        <form method="POST" action="{{URL::to('/check-coupon')}}">
                            {{ csrf_field() }}
                            <input type="text" class="form-control" name="coupon" placeholder="Nhập mã giảm giá"><br>
                            <input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Tính mã giảm giá" href="">
                        </form>
                    </td>
                    <td>
                        <div class="col-md-12">
                            @php
                            $vnd_to_usd = $total_after/23220;
                            $total_paypal = round($vnd_to_usd, 2);
                            \Session::put('total_paypal', $total_paypal)
                            @endphp
                            <!-- <div id="paypal-button"></div> -->
                            <a class="btn btn-default checkout m-3" href="{{ route('processTransaction') }}">Paypal</a>
                            <input type="hidden" id="vnd_to_usd" value="{{round($vnd_to_usd, 2)}}">
                        </div>
                    </td>
                    <td>
                        <form action="{{url('/vnpay_payment')}}" method="POST">
                            @csrf
                            <input type="hidden" name="total_vnpay" value="{{$total_after}}">
                            <button type="submit" class="btn btn-default checkout m-3" name="redirect" href="">VNPay</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{url('/momo_payment')}}" method="POST">
                            @csrf
                            <input type="hidden" name="total_momopay" value="{{$total_after}}">
                            <button type="submit" class="btn btn-default checkout m-3" name="payUrl" href="">MomoPay</button>
                        </form>
                    </td>
                </tr>
                @endif
                </table>
            </div>
        </div>
    </div>
    </div>
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
                    <input type="text" name="shipping_email" class="shipping_email" placeholder="Email*" value="{{Session::get('customer_email')}}">
                    <input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên" value="{{Session::get('customer_name')}}">
                    <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Phone" value="{{Session::get('customer_phone')}}">
                    @else
                    <input type="text" name="shipping_email" class="shipping_email" placeholder="Email*">
                    <input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên">
                    <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Phone">
                    @endif
                    <input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ">
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
                            <select name="payment_select" class="form-control input-sm m-bot15 payment_select ">
                                <option value="1">Thanh toán khi nhận hàng</option>
                                <option value="0">Thanh toán trực tuyến</option>
                            </select>
                        </div>
                    </div>
                    <input value="Xác nhận đơn hàng" type="button" name="send_order" class="btn btn-primary btn-sm send_order">
                </form>
            </div>
            <div class="form-two">
                <form role="form" action="{{URL::to('/save-brand-product')}}" method="post">
                    {{ csrf_field()}}
                    <div class="form-group">
                        <label for="exampleInputPassword1">Chọn thành phố</label>
                        <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                            <option value="">---Chọn tỉnh thành phố---</option>
                            @foreach($city as $key => $ci)
                            <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Chọn quận huyện</label>
                        <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                            <option value="">---Chọn quận huyện---</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Chọn xã phường</label>
                        <select name="wards" id="wards" class="form-control input-sm m-bot15 wards ">
                            <option value="">---Chọn xã phường---</option>
                        </select>
                    </div>
                    <input value="Tính phí vận chuyển" type="button" name="calculate_order" class="btn btn-primary btn-sm calculate_delivery">
                </form>
            </div>
        </div>
    </div>
    <!-- <div class="review-payment">
        <h2>Xem lại giỏ hàng</h2>
    </div>
    <div class="payment-options">
        <span>
            <label><input type="checkbox"> Direct Bank Transfer</label>
        </span>
        <span>
            <label><input type="checkbox"> Check Payment</label>
        </span>
        <span>
            <label><input type="checkbox"> Paypal</label>
        </span>
    </div>
    </div> -->
</section>
<!--/#cart_items-->
@endsection