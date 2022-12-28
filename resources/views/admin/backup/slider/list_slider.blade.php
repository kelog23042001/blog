@extends('admin_layout')
@section('admin_contend')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê banner
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên slider</th>
            <th>Hình ảnh</th>
            <th>Mô tả</th>
            <th>Trạng thái</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($all_slide as $key => $slide){ ?>
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{ $slide->slider_name }}</td>
              <td ><img width="200px" src="{{asset('public/uploads/slider/'.$slide->slider_image) }}"></td>
              <td>{{ $slide->slider_desc }}</td>
              <td><span class="text-ellipsis">
              <?php
                if($slide->slider_status == 0){
              ?>
              <a href="{{URL::to('/unactive-slide/'.$slide->slider_id)}}"><span class = "fa-thumb-styling fa fa-thumbs-down"> </span></a>
              <?php }else{ ?>
              <a href="{{URL::to('/active-slide/'.$slide->slider_id)}}"><span class = "fa-thumb-styling fa fa-thumbs-up"> </span></a>
              <?php
              }
              ?>
              </span></td>
              <td>
              <!-- <a style="font-size: 20px;" href="{{URL::to('/edit-slide/'.$slide->slider_id)}}" class="active" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a> -->
              <a  onclick="return confirm('Bạn có chắc chắn muốn xoá?')"  style="font-size: 20px;" href="{{URL::to('/delete-slide/'.$slide->slider_id)}}"><i class="fa fa-times text-danger text"></i></a>
              </td>
            </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
