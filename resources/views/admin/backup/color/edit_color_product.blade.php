@extends('admin_layout')
@section('admin_contend')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cập nhập màu sắc màu sắc
                        </header>
                        <?php
                            use Illuminate\Support\Facades\Session;

                            $message = Session::get('message');
                            if($message){
                                echo $message;
                                Session::put('message',null);
                            }
                        ?>
                        <div class="panel-body">
                            @foreach($edit_color_product as $key => $cate_value)
                                <div class="position-center">
                                    <form role="form" action="{{URL::to('/update-color-product/'.$cate_value->color_id)}}" method="post">
                                        {{ csrf_field()}}
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tên màu sắc</label>
                                            <input type="text" name="color_product_name" value="{{ $cate_value->color_name }}" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên màu sắc">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Mô tả màu sắc</label>
                                            <textarea style="resize:none" name="color_product_desc" rows="5" class="form-control" id="exampleInputPassword1" placeholder="Mô tả màu sắc">{{ $cate_value->color_desc }} </textarea>
                                        </div>

                                        <button type="submit" name="update_color_product" class="btn btn-info">Cập nhập màu sắc </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </section>

            </div>
</div>
@endsection
