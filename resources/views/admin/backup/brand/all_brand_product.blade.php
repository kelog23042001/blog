@extends('admin_layout')
@section('admin_contend')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê thương hiệu sản phẩm
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
    <div class="table-responsive">

      <table id="mytable" class="table table-striped b-t b-light">
        <thead>
          <tr>

            <td>Tên danh mục</td>
            <!-- <td>Slug</td>
            <td>Hển thị</td>

            <td style="width:30px;"></td> -->
          </tr>
        </thead>
        <tbody>
            @foreach($all_brand_product as $key => $cate_pro)
              <tr>

            <td>{{ $cate_pro->brand_name }}</td>
            <td>{{ $cate_pro->brand_slug }}</td>
            <td><span class="text-ellipsis">
               <?php
                    if($cate_pro->brand_status == 0){
                ?>
                       <a href="{{URL::to('/unactive-brand-product/'.$cate_pro->brand_id)}}"><span class = "fa-thumb-styling fa fa-thumbs-down"> </span></a>
                <?php
                    }else{
                ?>
                     <a href="{{URL::to('/active-brand-product/'.$cate_pro->brand_id)}}"><span class = "fa-thumb-styling fa fa-thumbs-up"> </span></a>
                <?php
                    }
                ?>
            </span></td>
            <td>
                <a style="font-size: 20px;" href="{{URL::to('/edit-brand-product/'.$cate_pro->brand_id)}}" class="active" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i></a>
                <a  onclick="return confirm('Bạn có chắc chắn muốn xoá?')"  style="font-size: 20px;" href="{{URL::to('/delete-brand-product/'.$cate_pro->brand_id)}}"><i class="fa fa-times text-danger text"></i></a>
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
            {!! $all_brand_product->links("pagination::bootstrap-4") !!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection
