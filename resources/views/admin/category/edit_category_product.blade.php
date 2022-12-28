@extends('admin_layout')
@section('admin_contend')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Cập Nhật Danh Mục</h3>
            <!-- <p class="text-subtitle text-muted">For user to check they list</p> -->
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <!-- <a href="{{URL::to('/add-category-product')}}" class="btn btn-success">Add Category</a> -->
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
    <form action="{{URL::to('/update-category-product/'.$category->category_id)}}" method="post" enctype="multipart/form-data">
        {{ csrf_field()}}
        <div class=" form-group">
            <label for="exampleInputEmail1">Tên danh mục</label>
            <input type="text" name="category_product_name" value="{{ $category->category_name }}" class="form-control" onkeyup="ChangeToSlug()" id="slug" placeholder="Nhập tên danh mục">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Slug</label>
            <input type="text" name="category_product_slug" value="{{ $category->slug_category_product }}" class="form-control" id="convert_slug" placeholder="Nhập từ khoá danh mục">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Từ khoá danh mục</label>
            <input type="text" name="category_product_keywords" value="{{ $category->meta_keywords }}" class="form-control" id="exampleInputEmail1">
        </div>
        <div class="form-group">
            <label for="thumbnail">Thumbnail</label>
            <input type="file" id="thumbnail" name=thumbnail onchange="document.getElementById('image_thumbnail').src = window.URL.createObjectURL(this.files[0])" class="form-control">
            <br>
            <img id="image_thumbnail" src="{{$category->thumbnail}}" alt="{{$category->category_name}}" width="100" height="100" />
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Mô tả danh mục</label>
            <textarea style="resize:none" name="category_product_desc" rows="5" class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{ $category->category_desc }} </textarea>
        </div>
        <button type="submit" class="btn btn-info">Cập nhập danh mục </button>
    </form>
</div>

@endsection