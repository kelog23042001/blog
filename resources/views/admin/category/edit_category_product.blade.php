@extends('admin_layout')
@section('admin_contend')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cập nhập dah mục sản phẩm
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
                            @foreach($edit_category_product as $key => $cate_value)
                                <div class="position-center">
                                    <form role="form" action="{{URL::to('/update-category-product/'.$cate_value->category_id)}}" method="post">
                                        {{ csrf_field()}}
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tên danh mục</label>
                                            <input type="text" name="category_product_name" value="{{ $cate_value->category_name }}" class="form-control" onkeyup="ChangeToSlug()" id="slug"  placeholder="Nhập tên danh mục">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Từ khoá danh mục</label>
                                            <input type="text" name="category_product_keywords" value="{{ $cate_value->meta_keywords }}" class="form-control"  id="convert_slug" placeholder="Nhập từ khoá danh mục">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Slug</label>
                                            <input type="text" name="category_product_slug" value="{{ $cate_value->slug_category_product }}" class="form-control" id="exampleInputEmail1">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Mô tả danh mục</label>
                                            <textarea style="resize:none" name="category_product_desc" rows="5" class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{ $cate_value->category_desc }} </textarea>
                                        </div>
                                        <button type="submit" name="update_category_product" class="btn btn-info">Cập nhập danh mục </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </section>

            </div>
</div>
@endsection
