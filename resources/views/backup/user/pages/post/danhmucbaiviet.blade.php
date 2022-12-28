@extends('layout')
@section('content')
<div class="col-sm-3">
    <div class="left-sidebar">
        @include('user.elements.left_sidebar')
    </div>
</div>
<div class="col-sm-9">
    <h2 class="title text-center" style="margin-top: 10px">Tin tức - {{$meta_title}}</h2>
    @foreach($post as $key => $val)
    <div class="post_row">
        <div class="geeks">
            <a href="{{URL::to('bai-viet/'.$val->post_slug)}}">
                <img class="img_post" src="{{URL::to('public/uploads/post/'.$val->post_image)}}" alt="{{$val->post_slug}}" />
            </a>
        </div>
        <div class="desc_post">
            <a href="{{URL::to('bai-viet/'.$val->post_slug)}}" class="a_post_title">
                <h4 class="post_title">{{$val->post_title}}</h4>
            </a>
            <div class="post_desc">
                <div class="block-post_desc">
                    <p>{{$val->post_desc}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    @endforeach
    {!! $post->links("pagination::bootstrap-4") !!}
</div>
<style>
    .post_row {
        transition: transform .3s;
    }

    .post_row:hover {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.19), 0 6px 20px 0 rgba(0, 0, 0, 0.312);
    }
</style>
@endsection