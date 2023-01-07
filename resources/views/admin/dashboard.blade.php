@extends('admin_layout')
@section('admin_contend')
<div class="container-fluid">
    <style>
        p.title_thongke {
            text-align: center;
            font-size: 20px;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
    <div class="row">
        <p class="title_thongke">
            Thống kê đơn hàng doanh số
        </p>
        <form autocomplete="off">
            @csrf
            <div class="col-md-2">
                Lọc theo:
                <select class="dashboard-filter form-control">
                    <option>-- Chọn --</option)>
                    <option value="7ngay">7 ngày qua</option>
                    <option value="thangtruoc">Tháng trước</options>
                    <option value="thangnay">Tháng này</option>
                    <option value="365ngayqua">1 năm</option>
                </select>
            </div>
        </form>
        <div class="col-md-12">
            <div id="chart" style="height:250px;"></div>
        </div>
    </div>

    <div class="row">
        <p class="title_thongke">Thống kê truy cập</p>
        <table class="table table-bordered table-dark">
            <thead>
                <tr>
                    <th scope="col">Đang hoạt động</th>
                    <th scope="col">Tổng tháng trước</th>
                    <th scope="col">Tổng tháng này</th>
                    <th scope="col">Tổng 1 năm</th>
                    <th scope="col">Tổng lượt truy cập</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$visitor_count}}</td>
                    <td>{{$visitor_last_month_count}}</td>
                    <td>{{$visitor_this_month_count}}</td>
                    <td>{{$visitor_year_count}}</td>
                    <td>{{$visitors_total}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-md-4 col-xs-12">
            <p class="title_thongke"> Thống kê số lượng </p>
            <div class="morris-donut-inverse" id="donut"></div>
        </div>
        <div class="col-md-4 col-xs-12">
            <style type="text/css">
                ol.list_views {
                    color: #fff;
                }

                ol.list_views a {
                    color: orange;
                    font-weight: 400;
                }
            </style>
            <p class="title_thongke">Sản phẩm xem nhiều</p>
            <ol class="list_views">
                @foreach($product_views as $key=> $pro)
                <li>
                    <a target="_blank" href="{{url('/chi-tiet-san-pham/'.$pro->product_id)}}">
                        {{$pro->product_name}}
                        <span style="color:black">({{$pro->product_views}} view)</span>
                    </a>
                </li>
                <hr>
                @endforeach
            </ol>
        </div>

        <div class="col-md-4 col-xs-12">
            <style type="text/css">
                ol.list_views {
                    color: #fff;
                }

                ol.list_views a {
                    color: orange;
                    font-weight: 400;
                }
            </style>
            <p class="title_thongke">Bài viết xem nhiều</p>
            <ol class="list_views">
                @foreach($post_views as $key=> $pro)
                <li>
                    <a target="_blank" href="{{url('/bai-viet/'.$pro->post_slug)}}">
                        {{$pro->post_title}}
                        <span style="color:black">({{$pro->post_views}} view)</span>
                    </a>
                </li>
                <hr>
                @endforeach
            </ol>
        </div>
    </div>
    @endsection