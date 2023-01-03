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
        <div class="alert alert-success d-none" id="alert-success">
            <span class="alert-update-success"></span>
        </div>
        <div class="alert alert-danger d-none" id="alert-danger">
            <!-- <p>abcsao</p> -->
        </div>
        <div class="table-responsive cart_info">
            <!-- <form action="{{URL::to('/update-cart')}}" method="POST"> -->
            @csrf
            <table class="table table-condensed">
                @if(Session::get('cart'))
                @csrf
                <thead>
                    <td colspan="4"></td>
                    <!-- <td><input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="btn btn-warning check_out"></td> -->
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
                            <span id="cart_price_{{$cart['session_id']}}" data-id="{{$cart['session_id']}}" data-price="{{$cart['product_price']}}">
                                {{number_format($cart['product_price'],0,',','.')}}VNĐ
                            </span>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <input type="hidden" id="soluongcon" value="{{$cart['remain_qty']}}">
                                <input oninput="checkQty()" class="cart_quantity_" id="qty_product" data-id="{{$cart['session_id']}}" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}">
                            </div>
                        </td>
                        <td class="cart_total">
                            <p>
                                <span class="cart_total_price_{{$cart['session_id']}}">
                                    {{number_format($cart['product_price']*$cart['product_qty'],0,',','.')}} VND
                                </span>

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
            <!-- </form> -->
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
                        <li>Tổng tiền: <span class="total_order">{{number_format($total,0,',','.')}} VND</span></li>
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

<script>


    $('.cart_quantity_').change(function() {
        id = $(this).data('id')
        qty = $(this).val()
        if (qty <= 0) {
            // alert(qty)
            $.ajax({
                type: "GET",
                url: "{{url('/del-product/'.$cart['session_id'])}}",
                dataType: "json",
                success: function() {
                    console.log('xoa thanh cong')
                }
            })
        }
        data = {
            'id': id,
            'qty': qty
        }
        $.ajax({
            url: "{{url('/update-cart-qty')}}",
            method: 'POST',
            dataType: 'json',
            data: data,
            success: function(data) {
                // location.reload()
                if (data.status) {
                    alertify.success(data.message);
                    // Alertify.log.success("Success notification");
                    var price = $('#cart_price_' + id).data('price')
                    var totalPrice = formatMoney(price * qty)
                    $('.cart_total_price_' + id).text(totalPrice)
                    $('.total_order').text(formatMoney(data.total))
                } else {
                    console.log(data.message);
                }
            }
        })
    })
</script>
@endsection