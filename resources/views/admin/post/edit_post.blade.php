@extends('admin_layout')
@section('admin_contend')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Cập nhập bài viết
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

                                    <form role="form" action="{{URL::to('/update-post/'.$post->post_id)}}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field()}}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên bài viết</label>
                                        <input type="text" name="post_title"  onkeyup="ChangeToSlug()" id="slug" class="form-control" id="exampleInputEmail1" value="{{ $post->post_title }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Slug</label>
                                        <input type="text" name="post_slug" id="convert_slug" class="form-control" id="exampleInputEmail1" value="{{ $post->post_slug }}">

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Hình ảnh bài viết</label>
                                        <input  type="file" name="post_image" class="form-control" id="exampleInputEmail1">
                                        @if(isset($post))
                                            <img width="20%" src="{{asset('public/uploads/post/'.$post->post_image)  }}">
                                        @endif <br>
                                       <!-- <img width="100px" src="{{URL::to('public/uploads/post/'.$post->post_image) }}"> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mô tả bài viết</label>
                                        <textarea style="resize:none" name="post_desc"  class="form-control" id="exampleInputPassword1" >
                                            {{ $post->post_desc }}
                                        </textarea>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nôi dung bài viết</label>
                                        <textarea style="resize:none" name="post_content"  class="form-control" id="exampleInputPassword1" >
                                            {{ $post->post_content }}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Meta bài từ khoá</label>
                                        <textarea style="resize:none" name="post_meta_keywords"  class="form-control" id="exampleInputPassword1" >
                                            {{ $post->post_meta_keywords }}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Meta nội dung</label>
                                        <textarea style="resize:none" name="post_meta_desc"  class="form-control" id="exampleInputPassword1" >
                                            {{ $post->post_meta_desc }}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Hiển thị</label>
                                        <select name="post_status" class="form-control input-sm m-bot15">
                                                @if($post->post_status == 0)
                                                    <option selected value="0">Ẩn</option>
                                                    <option value="1">Hiển thị</option>
                                                @else
                                                    <option  value="0">Ẩn</option>
                                                    <option selected value="1">Hiển thị</option>
                                                @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                        <select name="cate_post_id" class="form-control input-sm m-bot15">
                                            @foreach($cate_post as $key => $cate)
                                                @if($cate->cate_post_id == $post->cate_post_id)
                                                    <option selected value="{{$cate->cate_post_id}}">{{$cate->cate_post_name}}</option>
                                                @else
                                                    <option value="{{$cate->cate_post_id}}">{{$cate->cate_post_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" name="add_post" class="btn btn-info">Cập nhập bài viết</button>
                                </form>

                            </div>

                        </div>
                    </section>

            </div>
</div>
@endsection
