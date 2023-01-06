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
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <h1 style="text-align: center;">Chi Tiết Đơn Hàng</h1>

            <div class="table-agile-info">
                <div class="panel panel-default">
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
                                    <td>
                                        {{$details->product_sale_quantity}}
                                    </td>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="table-agile-info">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Trạng thái đơn hàng
                    </div>
                    <table class="table table-striped b-t b-light">
                        <tbody>
                            <tr>
                                @if($order->order_status == 1)
                                <form>
                                    @csrf
                                    <select class="form-control order_details" id="order_details">
                                        <option id="{{$order->order_id}}" value="1" selected>Chờ xử lý</option>
                                        <option id="{{$order->order_id}}" value="3">Huỷ đơn hàng</option>
                                    </select>
                                </form>
                                @elseif($order->order_status == 2)
                                <form>
                                    @csrf
                                    <select class="form-control order_details" disabled>
                                        <option id="{{$order->order_id}}" value="2" selected>Đã xử lý-Đã giao hàng</option>
                                    </select>
                                </form>
                                @elseif($order->order_status == 3)
                                <select class="form-control order_details" disabled>
                                    <option id="{{$order->order_id}}" value="3" selected>Huỷ đơn hàng</option>
                                </select>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
</div>
<!-- /container -->
</div>
<!-- /SECTION -->

@endsection