@extends('admin_layout')
@section('admin_contend')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm thư viện ảnh
                        </header>
                        <div class="panel-body">
                        <?php
                            use Illuminate\Support\Facades\Session;

                            $message = Session::get('message');
                            if($message){
                                echo $message;
                                Session::put('message',null);
                            }
                        ?>
                        <form action="{{url('/insert-gallery/'.$pro_id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3" align ="right">

                                </div>
                                <div class="col-md-6">
                                    <input type="file" id="file" class="form-control" name="file[]" accept="image/*" multiple >
                                    <span id="error_gallery"></span>
                                </div>
                                <div class="col-md-3">
                                    <input type="submit" name="upload" name="taianh" value="Tải ảnh" class="btn btn-success">
                                </div>
                        </form>
                        <div class="panel-body"></div>
                            <input type="hidden" value="{{$pro_id}}" name="pro_id" class="pro_id">
                        <form>
                                @csrf
                           <div id="gallery_load">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Thứ tự</th>
                                        <th>Tên hình ảnh</th>
                                        <th>Hình ảnh</th>
                                        <th>Quản lý</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </form>
                    </section>

            </div>
</div>
@endsection
