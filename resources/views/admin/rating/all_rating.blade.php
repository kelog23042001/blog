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
                            <th>Đánh giá (sao)</th>
                            <th>Bình luận</th>
                            <th>Hiển thị</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rates as $key => $rate)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $rate->rating }}</td>
                            <td>{{ $rate->comment }}</td>
                        
                            <td><span class="text-ellipsis">
                                    <?php
                                    if ($rate->visible == 0) {
                                    ?>
                                        <a href="{{URL::to('/active-rating/'.$rate->rating_id)}} " class="badge bg-danger">Inactive</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="{{URL::to('/unactive-rating/'.$rate->rating_id)}}" class="badge bg-success">Active</a>
                                    <?php
                                    }
                                    ?>
                                </span>
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