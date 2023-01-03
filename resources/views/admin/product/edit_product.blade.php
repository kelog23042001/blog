@extends('admin_layout')
@section('admin_contend')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Cập Nhật Sản Phẩm</h3>
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
    <form action="{{URL::to('/update-product/'.$product->product_id)}}" method="post" enctype="multipart/form-data">
        {{ csrf_field()}}
        <div class="form-group">
            <label for="exampleInputEmail1">Tên sản phẩm</label>
            <input type="text" value="{{$product->product_name}}" name="product_name" date-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 kí tự" class="form-control" onkeyup="ChangeToSlug()" required autocomplete="product_name" id="slug" placeholder="Nhập tên sản phẩm">
        </div>
        @error('product_name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="form-group">
            <label for="exampleInputEmail1">Slug</label>
            <input type="text" value="{{$product->product_slug}}" name="product_slug" date-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 kí tự" class="form-control" id="convert_slug" placeholder="Slug">
        </div>
        <div class="form-group">
            <label for="product_image">Hình ảnh sản phẩm</label>
            <a href="">Bộ Sưu Tập</a>
            <br>
            @if(isset($product))
            <img width="100px" src="{{$product->product_image }}" id="image_thumbnail">
            @endif
            <input type="file" id="product_image" name="product_image" class="form-control" onchange="document.getElementById('image_thumbnail').src = window.URL.createObjectURL(this.files[0])">
        </div>
        <div class="form-group">
            <label for="product_quantity">Số lượng sản phẩm</label>
            <input type="text" name="product_quantity" value="{{$product->product_quantity  }}" date-validation="length" data-validation-length="min3" data-validation-error-msg="Điền số lượng" class="form-control" id="product_quantity" placeholder="Nhập số lượng sản phẩm">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Giá bán</label>
            <input type="text" value="{{ $product->product_price }}" name="product_price" class="form-control price_format" id="exampleInputEmail1" placeholder="Nhập giá sản phẩm">
        </div>
        <div class="form-group">
            <label for="price_cost">Giá nhập</label>
            <input type="text" value="{{$product->price_cost}}" name="price_cost" class="form-control price_format" id="price_cost" placeholder="Nhập giá sản phẩm">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
            <textarea name="description" id="ckeditor_product" cols="30" rows="5" class="form-control" placeholder="Enter Description...">{!! $product->product_desc !!}</textarea>
        </div>
        <div class="form-group">
            <label for="product_cate">Danh mục sản phẩm</label>
            <select name="product_cate" class="choices form-select">
                @foreach($categories as $key => $category)
                @if($category->category_id == $product->category_id)
                <option selected value="{{$category->category_id}}">{{$category->category_name}}</option>
                @else
                <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <!-- <div class="form-group">
            <label for="exampleInputPassword1">Tags sản phẩm</label>
            <input type="text" data-role="tagsinput" name="product_tags" class="form-control" placeholder="Nhập giá sản phẩm">
        </div> -->
        <button type="submit" class="btn btn-info">Cập Nhật</button>
    </form>
</div>
@endsection