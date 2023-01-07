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
            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <div class="table-agile-info">
                        <div class="panel panel-default">
                            <div class="table-responsive">
                                <table class="table table-striped b-t b-light" id="table-orders">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Mã đơn hàng</th>
                                            <th>Tình trạng đơn hàng</th>
                                            <th style="width:30px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        ?>
                                        <?php foreach ($order as $key => $ord) { ?>
                                            <tr>
                                                <!-- <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td> -->

                                                <td>{{$i}}</td>
                                                <td>{{ $ord->created_at }}</td>
                                                <td>{{ $ord->order_code }}</td>

                                                <td>@if($ord->order_status == 1)
                                                    Chờ xử lý
                                                    @elseif($ord->order_status == 2)
                                                    Đã xử lý - Đã giao hàng
                                                    @else
                                                    Đã huỷ
                                                    @endif
                                                </td>
                                                <td>
                                                    <a style="font-size: 20px;" href="{{URL::to('/view-history-order/'.$ord->order_code)}}" class="active style-edit" ui-toggle-class="">
                                                        <i class="fa fa-eye text-success text-active"></i>
                                                    </a>
                                                    <!-- <a  onclick="return confirm('Bạn có chắc chắn muốn xoá?')"  style="font-size: 20px;" href="{{URL::to('/delete-order/'.$ord->order_code)}}"><i class="fa fa-times text-danger text"></i></a> -->
                                                </td>
                                            </tr>

                                        <?php $i++;
                                        } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
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