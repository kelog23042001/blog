@extends('admin_layout')
@section('admin_contend')
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Mã Giảm Giá</h3>
      <!-- <p class="text-subtitle text-muted">For user to check they list</p> -->
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <a href="{{URL::to('/insert-coupon')}}" class="btn btn-success">Thêm Mã Giảm Giá</a>
        <ol class="breadcrumb">
          <!-- <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li> -->
          <!-- <li class="breadcrumb-item active" aria-current="page">DataTable</li> -->
        </ol>
      </nav>
    </div>
  </div>
  <?php

    use Illuminate\Support\Facades\Session;

    $message = Session::get('message');
    if ($message) {
        echo $message;
        Session::put('message', null);
    }
    ?>
</div>
<div class="page-heading">
  <section class="section">
    <div class="card">
      <div class="card-body">
        <table class="table table-striped" id="table-category">
          <thead>
            <tr>

              <th>Tên mã giảm giá</th>
              <th>Mã giảm giá</th>
              <th>Số lượng</th>
              <th>Điều kiện giảm giá</th>
              <th>Số giảm</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
              <th>Thao tác</th>
              <th>Gửi mail</th>
            </tr>
          </thead>
          <tbody>
            @foreach($coupon as $key => $cou)
            <tr>

              <td>{{ $cou->coupon_name }}</td>
              <td>{{ $cou->coupon_code }}</td>
              <td>{{ $cou->coupon_time }}</td>
              <td>
                <span class="text-ellipsis">
                  <?php
                if ($cou->coupon_condition == 1) {
                ?>
                  Giảm theo phần trăm
                  <?php
                } else {
                ?>
                  Giảm theo tiền
                  <?php
                }
                ?>
                </span>
              </td>
              <td>
                <span class="text-ellipsis">
                  <?php
                if ($cou->coupon_condition == 1) {
                ?>
                  Giảm {{$cou->coupon_number}} %
                  <?php
                } else {
                ?>
                  Giảm {{$cou->coupon_number}} k
                  <?php
                }
                ?>
                </span>
              </td>
              <td>{{ $cou->coupon_date_start }}</td>
              <td>{{ $cou->coupon_date_end }}</td>

              <td>
                <a href="{{URL::to('/edit-coupon/'.$cou->coupon_id)}}" style="font-size: 20px;"><i class="bi bi-eyedropper"></i></a>
                <a onclick="return confirm('Bạn có chắc chắn muốn xoá?')" href="{{URL::to('/delete-coupon/'.$cou->coupon_id)}}" style="font-size: 20px;"
                  class="active styling-edit" ui-toggle-class=""><i class="bi bi-trash"></i></a>
              </td>
              <td>
              <a href="{{URL::to('/send-coupon/'.$cou->coupon_code)}}" class="btn btn-sm btn-danger">Gửi</a>
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