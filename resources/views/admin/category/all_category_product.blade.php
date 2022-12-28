@extends('admin_layout')
@section('admin_contend')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Danh Mục Sản Phẩm</h3>
            <!-- <p class="text-subtitle text-muted">For user to check they list</p> -->
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <a href="{{URL::to('/add-category-product')}}" class="btn btn-success">Thêm Danh Mục</a>
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
            <div class="card-body">
                <table class="table table-striped" id="table-category">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Thumbnail</th>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th>Hển thị</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($all_category_product as $key => $cate_pro)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><img src="{{ $cate_pro->thumbnail }}" height="100px" width="100px" alt=""></td>
                            <td>{{ $cate_pro->category_name }}</td>
                            <td>{{ $cate_pro->slug_category_product }}</td>
                            <td>
                                <span class="text-ellipsis">
                                    @if ($cate_pro->category_status == 0)
                                    <a href="{{URL::to('/unactive-category-product/'.$cate_pro->category_id)}}" class="badge bg-success">Active</a>
                                    @else
                                    <a href="{{URL::to('/active-category-product/'.$cate_pro->category_id)}}" class="badge bg-danger">Inactive</a>
                                    @endif
                                </span>
                            </td>
                            <td>
                                <a href="{{URL::to('/edit-category-product/'.$cate_pro->category_id)}}" style="font-size: 20px;"><i class="bi bi-eyedropper"></i></a>
                                <a onclick="return confirm('Bạn có chắc chắn muốn xoá?')" href="{{URL::to('/delete-category-product/'.$cate_pro->category_id)}}" style="font-size: 20px;" class="active styling-edit" ui-toggle-class=""><i class="bi bi-trash"></i></a>
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