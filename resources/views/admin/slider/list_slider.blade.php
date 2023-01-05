@extends('admin_layout')
@section('admin_contend')



<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Slider</h3>
      <!-- <p class="text-subtitle text-muted">For user to check they list</p> -->
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <a href="{{URL::to('/add-banner')}}" class="btn btn-success">Thêm Slider</a>
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
              <!-- <th style="width:20px;">
                <label class="i-checks m-b-none">
                  <input type="checkbox"><i></i>
                </label>
              </th> -->
              <th>Tên slider</th>
              <th>Hình ảnh</th>
              <th>Mô tả</th>
              <th>Trạng thái</th>
              <th>Thao tác</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($all_slide as $key => $slide)
            <tr>
              <!-- <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td> -->
              <td>{{ $slide->slider_name }}</td>
              <td><img width="100px" src="{{$slide->slider_image }}"></td>
              <td>{{ $slide->slider_desc }}</td>
              <td>
                @if ($slide->slider_status == 0)
                  <a href="{{URL::to('/active-slide/'.$slide->slider_id)}} " class="badge bg-danger">Unactive</a>
                @else
                  <a href="{{URL::to('/unactive-slide/'.$slide->slider_id)}} " class="badge bg-success">Inactive</a>
                @endif
              </td>
              <td>
                <a href="{{URL::to('/edit-slider/'.$slide->slider_id)}}" style="font-size: 20px;"
                  class="active styling-edit" ui-toggle-class=""><i class="bi bi-eyedropper"></i></i></a>
                <a onclick="return confirm('Bạn có chắc chắn muốn xoá?')"
                  href="{{URL::to('/delete-slider/'.$slide->slider_id)}}" style="font-size: 20px;"><i
                    class="bi bi-trash"></i></a>
              </td>
              <!-- <a style="font-size: 20px;" href="{{URL::to('/edit-slide/'.$slide->slider_id)}}" class="active" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a> -->
 
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
@endsection