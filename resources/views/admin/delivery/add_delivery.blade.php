@extends('admin_layout')
@section('admin_contend')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Thêm Phí Vận Chuyển</h3>
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
    <form action="{{URL::to('/insert-delivery')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field()}}
        <div class="form-group">
                                        <label for="exampleInputPassword1">Chọn thành phố</label>
                                        <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                                <option value="">---Chọn tỉnh thành phố---</option>
                                                @foreach($city as $key => $ci)

                                                    <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Chọn quận huyện</label>
                                        <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                                        <option value="">---Chọn quận huyện---</option>

                                        @foreach($Province as $key => $prov)

                                            <option value="{{$prov->maqh}}">{{$prov->name_quanhuyen}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Chọn xã phường</label>
                                        <select name="wards" id="wards" class="form-control input-sm m-bot15 wards ">
                                                <option value="">---Chọn xã phường---</option>
                                                @foreach($ward as $key => $war)

                                                    <option value="{{$war->maqh}}">{{$war->name_xaphuong}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    <label for="exampleInputEmail1">Phí vận chuyển</label>
                                    <input type="text" name="fee_ship" class="form-control fee_ship" id="exampleInputEmail1" placeholder="Nhập tên danh mục">
                                </div>
                                <button type="button" name="add_delivery" class="btn btn-info add_delivery">Thêm phí vận chuyển </button>
    </form>
    <br>
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Danh sách phí vận chuyển</h3>
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
            <div id="load_delivery">
                                    
            </div>
</div>

@endsection
