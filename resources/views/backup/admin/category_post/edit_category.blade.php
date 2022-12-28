@extends('admin_layout')
@section('admin_contend')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                         Cập nhập danh mục bài viết
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
                                <form role="form" action="{{URL::to('/update-category-post/'.$category_post->cate_post_id)}}" method="post">
                                    {{ csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input type="text" name="cate_post_name" value="{{$category_post->cate_post_name}}" class="form-control" onkeyup="ChangeToSlug()" id="slug" placeholder="Nhập tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text" name="cate_post_slug" value="{{$category_post->cate_post_slug}}" class="form-control" id="convert_slug" placeholder="Nhập tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả danh mục</label>
                                    <textarea style="resize:none" name="cate_post_desc"  rows="5"  class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">
                                    {{$category_post->cate_post_desc}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Trạng thái</label>
                                    <select name="cate_post_status" class="form-control input-sm m-bot15">
                                        @if($category_post->cate_post_status == 0)
                                            <option selected value="0">Ẩn</option>
                                            <option value="1">Hiển thị</option>
                                        @else
                                            <option value="0">Ẩn</option>
                                            <option selected value="1">Hiển thị</option>
                                        @endif

                                    </select>
                                </div>

                                <button type="submit" name="update_post_cate" class="btn btn-info">Cập nhập danh mục bài viết </button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
</div>
@endsection
