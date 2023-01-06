@extends('admin_layout')
@section('admin_contend')
<?php

use Illuminate\Support\Facades\Session;

$message = Session::get('message');
if ($message) {
    echo $message;
    Session::put('message', null);
}
?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Danh sách đơn đặt hàng</h3>
            <!-- <p class="text-subtitle text-muted">For user to check they list</p> -->
        </div>
    </div>
</div>
<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped" id="table-category">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ngày đặt hàng</th>
                            <th>Mã đơn hàng</th>
                            <th>Tình trạng đơn hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order as $key => $ord)
                        <tr>


                            <td>{{$key+1}}</td>
                            <td>{{ $ord->created_at }}</td>
                            <td>{{ $ord->order_code }}</td>
                            <td>@if($ord->order_status == 1)
                                Chờ xử lý
                                @elseif($ord->order_status == 3)
                                Đã huỷ
                                @else
                                Đã xử lý - Đã giao hàng
                                @endif
                            </td>
                            <td>
                                <a style="font-size: 20px;" href="{{URL::to('/view-order/'.$ord->order_code)}}" class="active style-edit" ui-toggle-class="">
                                    Xem
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection