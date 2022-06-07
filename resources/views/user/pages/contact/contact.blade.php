@extends('layout')
@section('content')
<div class="col-sm-3">
    <div class="left-sidebar">
        @include('user.elements.left_sidebar')
    </div>
</div>
        <div>

        <h2 class="title text-center">Liên hệ với chúng tôi</h2>
             @foreach($contact as $key => $val)
                <div class="row">
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
