@extends('admin_layout')
@section('admin_contend')
<div class="table-agile-info">
    <div class="panel panel-default">
        <h1 style="text-align: center;">Chi Tiết Đơn Hàng</h1>
        <div class="panel-heading">
            Thông tin khách hàng
        </div>
        <div class="table-responsive">
            <?php

            use Illuminate\Support\Facades\Session;

            $message = Session::get('message');
            if ($message) {
                echo $message;
                Session::put('message', null);
            }
            ?>
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$shipping->shipping_name}}</td>
                        <td>{{$shipping->shipping_phone}}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<br>
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Thông tin vận chuyển
        </div>

        <div class="table-responsive">
            <?php
            $message = Session::get('message');
            if ($message) {
                echo $message;
                Session::put('message', null);
            }
            ?>
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Nguời nhận hàng</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Hình thức thành toán</th>
                        <th>Ghi Chú</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$shipping->shipping_name}}</td>
                        <td>{{$shipping->shipping_address}}</td>
                        <td>{{$shipping->shipping_phone}}</td>
                        <td>{{$shipping->shipping_method}}</td>
                        <td>{{$shipping->shipping_notes}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<br><br>
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Liệt kê chi tiết đơn hàng
        </div>
        <div class="table-responsive">
            <?php
            $message = Session::get('message');
            if ($message) {
                echo $message;
                Session::put('message', null);
            }
            ?>
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Ảnh sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng đặt</th>
                        <th>Giá sản phẩm</th>
                        <th>Tổng tiền hàng</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $total = 0;
                    @endphp
                    @foreach($order_details as $key=>$details)
                    <tr class="color_qty_{{$details->product->product_id}}" )>
                        <td><img src="{{$details->product->product_image}}" height="100px" alt=""></td>
                        <td><a href="{{URL::to('chi-tiet-san-pham/'.$details->product->product_id)}}">{{$details->product->product_name}}</a></td>
                        <td>{{$details->product_sale_quantity}}</td>
                        <input type="hidden" id="order_product_id" name="order_product_id" class="order_product_id" value="{{$details->product_id}}">
                        <input type="hidden" class="order_qty_{{$details->product_id}}" max="{{$details->product->product_quantity}}" value="{{$details->product_sale_quantity}}" name="product_sales_quantity" id="order_qty_view_order">
                        <td>{{number_format($details->product_price,0,',','.')}} VND</td>
                        @php
                        $subtotal = $details->product_price * $details->product_sale_quantity;
                        $total += $subtotal;
                        @endphp
                        <td>{{number_format($subtotal,0,',','.')}} VND</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"></td>
                        <td>Tổng tiền hàng</td>
                        <td>{{number_format($total,0,',','.')}} VND</td>
                    </tr>

                    <tr>
                        <td colspan="3"></td>
                        <td>Giảm giá</td>
                        <td>- {{number_format($coupon,0,',','.')}} VND</td>
                    </tr>
                    <tr>
                        <td colspan=3></td>
                        <td>Phí giao hàng</td>
                        <td>{{number_format($details->product_feeship,0,',','.')}} VND</td>
                    </tr>
                    <tr>
                        <td colspan=3></td>
                        <td>Thành tiền</td>
                        <td>{{number_format($order->total,0,',','.')}} VND</td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            @if($order->order_status == 1)
                            <form>
                                @csrf
                                <select class="form-control order_details">
                                    <option id="{{$order->order_id}}" value="1" selected>Chờ xử lý</option>
                                    <option id="{{$order->order_id}}" value="2">Đã xử lý-Đang giao hàng</option>
                                    <option id="{{$order->order_id}}" value="3">Huỷ đơn hàng</option>
                                </select>
                            </form>
                            @elseif($order->order_status == 2)
                            <form>
                                @csrf
                                <select class="form-control order_details" disabled>
                                    <option id="{{$order->order_id}}" value="2" selected>Đã xử lý-Đang giao hàng</option>
                                </select>
                            </form>
                            @elseif($order->order_status == 3)
                            <select class="form-control order_details" disabled>
                                <option id="{{$order->order_id}}" value="3" selected>Huỷ đơn hàng</option>
                            </select>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<a href="{{URL::to('/print-order/'.$details->order_code)}}">In hoá đơn</a>
@endsection