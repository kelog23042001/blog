@extends('layout')
@section('content')
<div class="col-sm-3">
  @include('user.elements.left_sidebar')
</div>
<div class="col-sm-9 padding-right">
  <div class="features_items">
    <h2 class="title text-center" style="margin-top : 16px">lịch sử đơn hàng</h2>
    <div class="table-agile-info">
      <div class="panel panel-default">

        <div class="row w3-res-tb">
        </div>
        <div class="table-responsive">
          <table class="table table-striped b-t b-light">
            <thead>
              <tr>
                <!-- <th style="width:20px;">
                  <label class="i-checks m-b-none">
                    <input type="checkbox"><i></i>
                  </label>
                </th> -->
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
@endsection