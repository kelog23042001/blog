@extends('admin_layout')
@section('admin_contend')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê bài viết
    </div>

    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <?php
      use Illuminate\Support\Facades\Session;

      $message = Session::get('message');
      if($message){
          echo $message;
          Session::put('message',null);
      }
    ?>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên bài viết</th>
            <th>Hình ảnh</th>
            <th>Slug</th>
            <th>Mô tả bài viết</th>
            <th>Từ khoá bào viết</th>
            <th>Danh mục bài viết</th>
            <th>Status</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach($all_post as $key => $cate_post)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{ $cate_post->post_title }}</td>
            <td ><img width="100px" src="{{asset('public/uploads/post/'.$cate_post->post_image) }}"></td>
            <td>{{ $cate_post->post_slug }}</td>
            <td>{{ $cate_post->post_desc }}</td>
            <td>{{ $cate_post->post_meta_desc }}</td>

            <td>{{ $cate_post->cate_post_name }}</td>
            <td><span class="text-ellipsis">
            <?php
                        if($cate_post->post_status == 0){
                    ?>
                        Ẩn
                    <?php
                        }else{
                    ?>
                        Hiển thị
                    <?php
                        }
                    ?>
            </span></td>
            <td>
            <a href="{{URL::to('/edit-post/'.$cate_post->post_id)}}" style="font-size: 20px;" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
            <a  onclick="return confirm('Bạn có chắc chắn muốn xoá?')" href="{{URL::to('/delete-post/'.$cate_post->post_id)}}"  style="font-size: 20px;" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        <div class="col-sm-5 text-center">
        </div>
        <div class="col-sm-7 text-right text-center-xs">
          <ul class="pagination pagination-sm m-t-none m-b-none">
            {!! $all_post->links("pagination::bootstrap-4") !!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection
