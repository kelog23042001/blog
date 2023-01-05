@extends('admin_layout')
@section('admin_contend')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Cập Nhật Slider</h3>
            <!-- <p class="text-subtitle text-muted">For user to check they list</p> -->
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <!-- <a href="{{URL::to('/add-category-slider')}}" class="btn btn-success">Add Category</a> -->
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
    <form action="{{URL::to('/update-slider/'.$slider->slider_id)}}" method="post" enctype="multipart/form-data">
        {{ csrf_field()}}
        <div class="form-group">
            <label for="exampleInputEmail1">Tên slider</label>
            <input type="text" value="{{$slider->slider_name}}" name="slider_name" date-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 kí tự" class="form-control" onkeyup="ChangeToSlug()" required autocomplete="slider_name" id="slug" placeholder="Nhập tên sản phẩm">
        </div>
        @error('slider_name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror      
        <div class="form-group">
            <label for="slider_image">Hình ảnh</label>
            <a href="">Bộ Sưu Tập</a>
            <br>
            @if(isset($slider))
            <img width="100px" src="{{$slider->slider_image }}" id="image_thumbnail">
            @endif
            <input type="file" id="slider_image" name="slider_image" class="form-control" onchange="document.getElementById('image_thumbnail').src = window.URL.createObjectURL(this.files)">
        </div>
        <div class="form-group">
            <label for="slider_quantity">Mô tả</label>
            <input type="text" name="slider_desc" value="{{$slider->slider_desc  }}" date-validation="length" data-validation-length="min3" data-validation-error-msg="Điền số lượng" class="form-control" id="slider_quantity" placeholder="Nhập số lượng sản phẩm">
        </div>
        <div class="form-group">
            <label for="product_cate">Trạng thái</label>
            <select name="slider_status" class=" form-select">  
                @if($slider->slider_status == "1")
                    <option selected value="1">Hiện thị</option>
                    <option value="0">Ẩn</option>
                @else
                    <option  value="1">Hiện thị</option>
                    <option selected value="0">Ẩn</option>
                @endif
             
            </select>
        </div>
        <!-- <div class="form-group">
            <label for="exampleInputPassword1">Tags sản phẩm</label>
            <input type="text" data-role="tagsinput" name="slider_tags" class="form-control" placeholder="Nhập giá sản phẩm">
        </div> -->
        <button type="submit" class="btn btn-info">Cập Nhật</button>
    </form>
</div>
@endsection
