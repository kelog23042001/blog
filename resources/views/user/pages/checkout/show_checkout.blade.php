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
                    <li><a href="{{url('/gio-hang')}}">Giỏ hàng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$meta_title}}</li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->

<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-7">
                <!-- Billing Details -->
                <div class="billing-details">
                    <div class="section-title">
                        <h3 class="title">thông tin khách hàng</h3>
                    </div>
                    <div class="form-group">
                        @if(!Session::get('customer_id'))
                        <div class="register-req">
                            <p>Bạn chưa đăng nhập. <a style="color:red" href="{{url('/login-checkout')}}">Đăng Nhập</a></p>
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <input class="input shipping_name" type="text" placeholder="Tên" required>
                    </div>
                    <div class="form-group">
                        <input class="input shipping_email" type="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input class="input shipping_phone" type="tel" name="shipping_phone" placeholder="Số điện thoại" required>
                    </div>
                    <div class="form-group">
                        <div class="input-checkbox">
                            <input type="checkbox" id="create-account">
                            <label for="create-account">
                                <span></span>
                                Create Account?
                            </label>
                            <div class="caption">
                                <input class="input" type="password" name="password" placeholder="Điền mật khẩu" required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Billing Details -->

                <!-- Shiping Details -->
                <div class="shiping-details">
                    <div class="section-title">
                        <h3 class="title">Địa chỉ nhận hàng</h3>
                    </div>
                    <div class="form-group">
                        <input class="input shipping_address" type="text" name="address" placeholder="Địa chỉ" required>
                    </div>
                    <div class="form-group">
                        <select name="city" id="city" class="form-control choose">
                            <option value="">Chọn Tỉnh-Thành Phố</option>
                            @foreach($city as $key => $ci)
                            <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="province" id="province" class="form-control choose">
                            <option value="non">Chọn Quận-Huyện</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="wards" id="wards" class="form-control wards">
                            <option value="">Chọn Phường-Xã</option>
                        </select>
                    </div>
                </div>
                <!-- /Shiping Details -->

                <!-- Order notes -->
                <div class="order-notes">
                    <textarea class="input shipping_notes" placeholder="Ghi chú thêm"></textarea>
                </div>
                <!-- /Order notes -->
            </div>

            <!-- Order Details -->
            <div class="col-md-5 order-details">
                <div class="section-title text-center">
                    <h3 class="title">Đơn hàng của bạn</h3>
                </div>
                <div class="order-summary">
                    <div class="order-col">
                        <div><strong>SẢN PHẨM</strong></div>
                        <div><strong>TỔNG TIỀN</strong></div>
                    </div>
                    <div class="order-products">
                        <!-- product cart -->
                        @foreach($cart as $key => $item)
                        <div class="order-col">
                            <div>{{$item['product_qty']}}x {{$item['product_name']}}</div>
                            <?php
                            $subtotal = $item['product_price'] * $item['product_qty'];
                            ?>
                            <div><strong>{{number_format($subtotal,0,',','.')}} <span style="text-decoration: underline;">đ</span></strong></div>
                        </div>
                        @endforeach
                        <!-- end product cart -->
                    </div>
                    <div class="order-col">
                        <div>Phí vận chuyển</div>
                        <div><strong class="order_fee">FREE</strong></div>
                    </div>
                    <div class="order-col">
                        <div><strong>THÀNH TIỀN</strong></div>
                        <div><strong class="order-total">{{number_format($total,0,',','.')}} <span style="text-decoration: underline;">đ</span></strong></div>
                    </div>
                </div>
                <div class="payment-method" id="payment-method">
                    <div class="input-radio">
                        <input type="radio" value="cash" name="payment" id="payment-1" checked>
                        <label for="payment-1">
                            <span></span>
                            Thanh toán khi nhận hàng
                        </label>
                        <div class="caption">
                            <!-- <p>Chuyển qua ngân hàng</p> -->
                        </div>
                    </div>
                    <div class="input-radio">
                        <input type="radio" value="momo" name="payment" id="payment-2">
                        <label for="payment-2">
                            <span></span>
                            Thẻ ATM nội địa
                        </label>
                        <div class="caption">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                    <div class="input-radio">
                        <input type="radio" value="paypal" name="payment" id="payment-3">
                        <label for="payment-3">
                            <span></span>
                            Paypal
                        </label>
                        <div class="caption">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>
                <!-- $total_after_fee = $total + $fee;
                $total_final = $total_after_fee - $total_coupon; -->
                @php
                $vnd_to_usd = $total/23220;
                $total_paypal = round($vnd_to_usd, 2);
                \Session::put('total_paypal', $total_paypal)
                @endphp
                <a href="#" class="primary-btn order-submit send_order">Đặt hàng</a>
            </div>
            <!-- /Order Details -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
@endsection