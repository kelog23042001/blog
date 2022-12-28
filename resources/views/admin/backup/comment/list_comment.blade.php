@extends('admin_layout')
@section('admin_contend')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Quản lý bình luận sản phẩm
        </div>
        <?php

        use Illuminate\Support\Facades\Session;

        $message = Session::get('message');
        if ($message) {
            echo $message;
            Session::put('message', null);
        }
        ?>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <!-- <th>Tên sản phẩm</th> -->
                        <th>Tên khách hàng</th>
                        <th>Ngày gửi</th>
                        <th>Nội dung</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comment as $key => $comm)
                    <tr>
                        <td>
                            <style>
                                .comment_product_name:hover {
                                    color: red;
                                }

                                .list_rep li {
                                    list-style-type: decimal;
                                    color: green;
                                    margin: 5px 40px;
                                }
                            </style>
                            <a class="comment_product_name" href="{{URL::to('chi-tiet-san-pham/'.$comm->comment_product_id)}}">
                                {{$comm->product->product_name}}
                            </a>
                        </td>
                        <td>{{$comm->comment_name}}</td>
                        <td>{{$comm->comment_date}}</td>
                        <td>{{$comm->comment}}
                            <ul class="list_rep">
                                @foreach($comment_rep as $key => $comm_reply)
                                @if($comm_reply->comment_parent_comment == $comm->comment_id)
                                <li>
                                    Trả lời: {{$comm_reply->comment}}
                                </li>
                                @endif
                                @endforeach
                            </ul>
                            @if($comm->comment_status == 0)
                            <br /><textarea class="form-control reply_comment_{{$comm->comment_id}}" rows="3"></textarea>

                            <br /> <button class="btn btn-warning btn-xs btn-reply-comment" data-product_id="{{$comm->comment_product_id}}" data-comment_id="{{$comm->comment_id}}" href="#"> Trả lời </button>
                            @endif
                        </td>
                        <td>
                            @if($comm->comment_status == 1)
                            <input type="button" data-comment_status="0" data-comment_id="{{$comm->comment_id}}" id="{{$comm->comment_product_id}}" class="btn btn-danger btn-xs comment_duyet_btn" value="Chờ Duyệt">
                            @else
                            <input type="button" data-comment_status="1" data-comment_id="{{$comm->comment_id}}" id="{{$comm->comment_product_id}}" class="btn btn-success btn-xs comment_duyet_btn" value="Bỏ Duyệt ">
                            @endif
                        </td>
                        <td>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection