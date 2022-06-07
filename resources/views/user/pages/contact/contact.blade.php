@extends('layout')
@section('content')
<section id="slider">
    <!--slider-->
    @include('user.elements.slider')
</section>
<div class="col-sm-3">
    <div class="left-sidebar">
        @include('user.elements.left_sidebar')
        @include('user.elements.left_sidebar.viewed')
        @include('user.elements.left_sidebar.wishlist')
    </div>
</div>
        <div>

        <h2 class="title text-center">Liên hệ với chúng tôi</h2>
             @foreach($contact as $key => $val)
                <div class="col-sm-9 padding-right ">
                    <div class="col-md-12">

                        <h4>Thông tin liên hệ</h4>
                        {!!$val->info_contact!!}

                            {!!$val->info_fanpage!!}
                        </p>
                    </div>
                    <div class="col-md-12">
                        <h4>Bản đồ</h4>
                        {!!$val->info_map!!}
                    </div>

                </div>
                @endforeach
        </div>

@endsection
