@extends('admin_layout')
@section('admin_contend')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Sản Phẩm</h3>
            <!-- <p class="text-subtitle text-muted">For user to check they list</p> -->
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <a href="{{URL::to('/add-product')}}" class="btn btn-success">Thêm Sản Phẩm</a>
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
            <!-- <div class="card-header">
                Simple Datatable
            </div> -->
            <div class="card-body">
                <table class="table table-striped" id="table-category">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Thư viện ảnh</th>
                            <th>Số lượng còn</th>
                            <!-- <th>Đã bán</th> -->
                            <th>Slug</th>
                            <th>Giá</th>
                            <th>Danh mục</th>
                            <th>Hển thị</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($all_product as $key => $pro)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $pro->product_name }}</td>
                            <td><img width="100px" src="{{$pro->product_image }}"></td>
                            <td><a href="{{url('/add-gallery/'.$pro->product_id)}}">Thư viện ảnh</a></td>
                            <td>{{ $pro->product_quantity }}</td>
                            <td>{{ $pro->product_slug }}</td>
                            <td>{{ $pro->product_price }}</td>
                            <td>{{ $pro->category_name }}</td>
                            <td><span class="text-ellipsis">
                                    <?php
                                    if ($pro->product_status == 0) {
                                    ?>
                                        <a href="{{URL::to('/active-product/'.$pro->product_id)}} " class="badge bg-danger">Inactive</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="{{URL::to('/unactive-product/'.$pro->product_id)}}" class="badge bg-success">Active</a>
                                    <?php
                                    }
                                    ?>
                                </span></td>
                            <td>
                                <a href="{{URL::to('/edit-product/'.$pro->product_id)}}" style="font-size: 20px;" class="active styling-edit" ui-toggle-class=""><i class="bi bi-eyedropper"></i></i></a>
                                <a onclick="return confirm('Bạn có chắc chắn muốn xoá?')" href="{{URL::to('/delete-product/'.$pro->product_id)}}" style="font-size: 20px;"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection