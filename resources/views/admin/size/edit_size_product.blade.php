@extends('admin_layout')
@section('admin_contend')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cập nhập danh mục size
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
                            @foreach($edit_size_product as $key => $cate_value)
                                <div class="position-center">
                                    <form role="form" action="{{URL::to('/update-size-product/'.$cate_value->size_id)}}" method="post">
                                        {{ csrf_field()}}
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">TSize</label>
                                            <input type="text" name="size_product_name" value="{{ $cate_value->size_name }}" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên danh mục">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Mô tả size</label>
                                            <textarea style="resize:none" name="size_product_desc" rows="5" class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{ $cate_value->size_desc }} </textarea>
                                        </div>

                                        <button type="submit" name="update_size_product" class="btn btn-info">Cập nhập size </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </section>

            </div>
</div>
@endsection
