@extends('admin_layout')
@section('admin_contend')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm màu sắc sản phẩm
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
                                <form role="form" action="{{URL::to('/save-color-product')}}" method="post">
                                    {{ csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên màu sắc</label>
                                    <input type="text" name="color_product_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên màu sắc">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả màu sắc</label>
                                    <textarea style="resize:none" name="color_product_desc" rows="5"  class="form-control" id="exampleInputPassword1" placeholder="Mô tả màu sắc">
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                    <select name="color_product_status" class="form-control input-sm m-bot15">
                                            <option value="0">Ẩn</option>
                                            <option value="1">Hiển thị</option>
                                    </select>
                                </div>

                                <button type="submit" name="add_color_product" class="btn btn-info">Thêm màu sắc </button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
</div>
@endsection
