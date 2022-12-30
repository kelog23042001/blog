@extends('admin_layout')
@section('admin_contend')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm thông tin Website
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
                            <div class="position-center">
                                @foreach($contact as $key => $val)
                                <form role="form" action="{{URL::to('/update-info/'.$val->info_id)}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field()}}

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Thông tin liên hệ</label>
                                    <textarea style="resize:none" name="info_contact" rows="5" class="form-control"  date-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 kí tự"  id="ckeditor1">
                                    {{$val->info_contact}}
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Bản đồ</label>
                                    <textarea style="resize:none" name="info_map" rows="5"  date-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 kí tự"  class="form-control"  id="exampleInputPassword1">
                                    {{$val->info_map}}
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Fanpage</label>
                                    <textarea style="resize:none" name="info_fanpage" rows="5"  date-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 kí tự"  class="form-control" id="exampleInputPassword1">
                                    {{$val->info_fanpage}}
                                    </textarea>
                                </div>
                                <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh logo</label>
                                <input type="file" name="info_image" class="form-control" id="exampleInputEmail1">
                                @if(isset($val))
                                <img width="20%" src="{{asset('public/uploads/contact/'.$val->info_logo)  }}">
                                @endif <br>
                            </div>
                                <button type="submit" name="add_info" class="btn btn-info">Cập nhập thông tin</button>
                            </form>
                            @endforeach
                            </div>

                        </div>
                    </section>

            </div>
</div>
@endsection
