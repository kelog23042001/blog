@extends('admin_layout')
@section('admin_contend')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm bài viết
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
                                <form role="form" action="{{URL::to('/save-post')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên bài viết</label>
                                    <input type="text" name="post_title" data-validation="length" data-validation-length="min3"
                                    data-validation-error-msg="Làm ơn điền ít nhất 10 ký tự" class="form-control" value="{{old('post_title')}}" onkeyup="ChangeToSlug()" id="slug" placeholder="Nhập tên danh mục" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text"  name="post_slug" class="form-control" id="convert_slug" placeholder="Nhập tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh bài viết</label>
                                    <input type="file" name="post_image" class="form-control" id="exampleInputEmail1">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả bài viết</label>
                                    <textarea style="resize:none"  name="post_desc" data-validation="length" data-validation-length="min10"
                                    data-validation-error-msg="Làm ơn điền ít nhất 10 ký tự" rows="5"  class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung bài viết</label>
                                    <textarea style="resize:none" name="post_content" rows="5"  class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Meta bài từ khoá</label>
                                    <textarea style="resize:none" name="post_meta_keywords" rows="5"  class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Meta nội dung</label>
                                    <textarea style="resize:none" name="post_meta_desc" rows="5"  class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Danh mục bài viết</label>
                                    <select name="cate_post_id" class="form-control input-sm m-bot15">
                                            @foreach($cate_post as $key => $cate)
                                            <option value="{{$cate->cate_post_id}}">{{$cate->cate_post_name}}</option>

                                            @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                    <select name="post_status" class="form-control input-sm m-bot15">
                                            <option value="0">Ẩn</option>
                                            <option value="1">Hiển thị</option>
                                    </select>
                                </div>

                                <button type="submit" name="add_post" class="btn btn-info">Thêm bài viết </button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
</div>
@endsection
