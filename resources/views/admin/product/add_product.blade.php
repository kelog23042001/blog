@extends('admin_layout')
@section('admin_contend')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Thêm Sản Phẩm</h3>
            <!-- <p class="text-subtitle text-muted">For user to check they list</p> -->
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <a href="{{URL::to('/all-product')}}" class="btn btn-success">Quay lại</a>
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
    <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field()}}
        <div class="form-group">
            <label for="exampleInputEmail1">Tên sản phẩm</label>
            <input type="text" name="product_name" date-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 kí tự" class="form-control" onkeyup="ChangeToSlug()" required autocomplete="product_name" id="slug" placeholder="Nhập tên sản phẩm">
        </div>
        @error('product_name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            <label for="exampleInputEmail1">Slug</label>
            <input type="text" name="product_slug" date-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 kí tự" class="form-control" id="convert_slug" placeholder="Slug">
        </div>
        <div class="form-group">
            <label for="product_image">Hình ảnh sản phẩm</label>
            <input type="file" id="product_image" name="product_image[]" class="form-control" multiple>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Số lượng sản phẩm</label>
            <input type="text" name="product_quantity" date-validation="length" data-validation-length="min3" data-validation-error-msg="Điền số lượng" class="form-control" id="exampleInputEmail1" placeholder="Nhập số lượng sản phẩm">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Giá bán</label>
            <input type="text" name="product_price" class="form-control price_format" id="exampleInputEmail1" placeholder="Nhập giá sản phẩm">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Giá nhập</label>
            <!-- <input type="text" class="money" value="20000"/> -->
            <input type="text" name="price_cost" class="form-control price_format" id="exampleInputEmail1" placeholder="Nhập giá sản phẩm">
        </div>
        <div class="form-group">
            <label for="editor">Mô tả sản phẩm</label>
            <textarea name="description" id="editor" cols="30" rows="5" class="form-control" placeholder="Enter Description..."></textarea>
        </div>
        <div class="form-group">
            <label for="product_cate">Danh mục sản phẩm</label>
            <select name="product_cate" class=" choices form-select">
                @foreach($cate_product as $key => $cate)
                <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                @endforeach
            </select>
        </div>
        <!-- <div class="form-group">
            <label for="exampleInputPassword1">Tags sản phẩm</label>
            <input type="text" data-role="tagsinput" name="product_tags" class="form-control" placeholder="Nhập giá sản phẩm">
        </div> -->
        <button type="submit" class="btn btn-info">Thêm sản phẩm</button>
    </form>
</div>
<script src="{{asset('Backend/vendors/choices.js/choices.min.js')}}"></script>
@endsection