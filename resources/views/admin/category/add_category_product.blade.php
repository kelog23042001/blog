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
                <a href="{{URL::to('/all-category-product')}}" class="btn btn-success">Quay lại</a>
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
    <form action="{{URL::to('/save-category-product')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field()}}
        <div class="form-group">
            <label for="exampleInputEmail1">Tên danh mục</label>
            <input type="text" name="category_name" data-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 ký tự" class="form-control" onkeyup="ChangeToSlug()" id="slug" placeholder="Nhập tên danh mục" autocomplete="category_name">
        </div>
        @error('category_name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            <label for="exampleInputEmail1">Slug</label>
            <input type="text" name="category_product_slug" class="form-control" id="convert_slug">
        </div>
        <div class="form-group">
            <label for="thumbnail">Thumbnail</label>
            <input type="file" id="thumbnail" name=thumbnail onchange="document.getElementById('image_thumbnail').src = window.URL.createObjectURL(this.files[0])" class="form-control">
            <br>
            <img id="image_thumbnail" src="#" />
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Mô tả danh mục</label>
            <textarea style="resize:none" name="category_product_desc" rows="5" class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục" autocomplete="category_product_desc"></textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Từ khoá danh mục</label>
            <textarea style="resize:none" name="category_product_keywords" rows="5" class="form-control" id="exampleInputPassword1" placeholder="Từ khoá danh mục" autocomplete="category_product_keywords"></textarea>
        </div>
        <button type="submit" name="add_category_product" class="btn btn-info">Thêm danh mục </button>
    </form>
</div>

@endsection