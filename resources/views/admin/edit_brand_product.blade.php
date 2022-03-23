@extends('admin_layout')
@section('admin_contend')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cập nhập danh mục thương hiệu
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
                            @foreach($edit_brand_product as $key => $cate_value)
                                <div class="position-center">
                                    <form role="form" action="{{URL::to('/update-brand-product/'.$cate_value->brand_id)}}" method="post">
                                        {{ csrf_field()}}
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tên thương hiệu</label>
                                            <input type="text" name="brand_product_name" value="{{ $cate_value->brand_name }}" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên danh mục">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                                            <textarea style="resize:none" name="brand_product_desc" rows="5" class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{ $cate_value->brand_desc }} </textarea>
                                        </div>

                                        <button type="submit" name="update_brand_product" class="btn btn-info">Cập nhập thương hiệu </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </section>

            </div>
</div>
@endsection
