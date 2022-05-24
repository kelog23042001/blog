@extends('layout')
@section('content')
<section id="slider">
    <!--slider-->
    @include('elements.slider')
</section>
<div class="col-sm-3">
    <div class="left-sidebar">
        <h2 class="title text-center">Danh Mục Sản Phẩm</h2>
        <!--category-productsr-->
        <div class="panel-group category-products" id="accordian">
            @foreach($category as $key => $cate)
            @if($cate->category_parent == 0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#{{$cate->slug_category_product}}">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            {{$cate->category_name}}
                        </a>
                    </h4>
                </div>

                <div id="{{$cate->slug_category_product}}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            @foreach($category as $key => $cate_sub)
                            @if($cate_sub->category_parent == $cate->category_id)
                            <li><a href="{{URL::to('/danh-muc-san-pham/'.$cate_sub->category_id)}}">{{$cate_sub->category_name}} </a></li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        <!--/category-products-->

        <div class="brands_products">
            <!--brands_products-->
            <h2>Thương Hiệu Sản Phẩm</h2>
            @foreach($brand as $key => $brand)
            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_id)}}">{{$brand->brand_name}}</a></li>
                </ul>
            </div>
            @endforeach
        </div>
        <!--/brands_products-->

        <!-- <div class="price-range">
            <h2>Price Range</h2>
            <div class="well text-center">
                    <input type="text" class="span2" value="" data-    -min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
                    <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
            </div>
        </div> -->
    </div>
</div>
<div class="product-image-wrapper">
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
@endsection