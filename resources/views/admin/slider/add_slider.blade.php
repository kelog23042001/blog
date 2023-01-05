@extends('admin_layout')
@section('admin_contend')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Thêm Danh Mục</h3>
            <!-- <p class="text-subtitle text-muted">For user to check they list</p> -->
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <a href="{{URL::to('/add-category-product')}}" class="btn btn-success">Add Category</a>
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
<div class="card-body">
    <form  action="{{URL::to('/insert-slider')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Tên slider</label>
            <input type="text" name="slider_name" class="form-control" id="exampleInputEmail1"
                placeholder="Nhập tên slide">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Hình ảnh</label>
            <input type="file" name="slide_image" class="form-control" id="exampleInputEmail1" placeholder="hình ảnh">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Mô tả </label>
            <textarea style="resize:none" name="slider_desc" rows="5" class="form-control" id="exampleInputPassword1"
                placeholder="Mô tả slide">
                                    </textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Hiển thị</label>
            <select name="slider_status" class="form-control input-sm m-bot15">
                <option value="1">Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>
        </div>

        <button type="submit" name="add_silder" class="btn btn-info">Thêm slide </button>
    </form>

</div>



@endsection