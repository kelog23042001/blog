@extends('admin_layout')
@section('admin_contend')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm dah mục sản phẩm
            </header>
            <div class="panel-body">
                <?php

                use Illuminate\Support\Facades\Session;

                $message = Session::get('message');
                if ($message) {
                    echo $message;
                    Session::put('message', null);
                }
                ?>
                <div class="position-center">
                    <form role="form" action="{{URL::to('/save-category-product')}}" method="post">
                        {{ csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục</label>
                            <input type="text" name="category_name" data-validation="length" data-validation-length="min3" data-validation-error-msg="Làm ơn điền ít nhất 3 ký tự" class="form-control" onkeyup="ChangeToSlug()" id="slug" placeholder="Nhập tên danh mục" required autocomplete="category_name">
                        </div>
                        @error('category_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" name="category_product_slug" class="form-control" id="convert_slug">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả danh mục</label>
                            <textarea style="resize:none" name="category_product_desc" rows="5" class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục" required autocomplete="category_product_desc">
                                    </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Từ khoá danh mục</label>
                            <textarea style="resize:none" name="category_product_keywords" rows="5" class="form-control" id="exampleInputPassword1" placeholder="Từ khoá danh mục" required autocomplete="category_product_keywords">
                                    </textarea>
                        </div>
                        <button type="submit" name="add_category_product" class="btn btn-info">Thêm danh mục </button>
                    </form>
                </div>

            </div>
        </section>

    </div>
</div>
@endsection