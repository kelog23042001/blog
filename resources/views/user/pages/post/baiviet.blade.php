@extends('layout')
@section('content')
<section id="slider">
    <!--slider-->
    @include('elements.slider')
</section>
<div class="col-sm-3">
    <div class="left-sidebar">
        <h2 class="title text-center">Danh mục sản phẩm</h2>
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
    <h2 style=" position: inherit; margin-top: 10px" class="title text-center">{{$meta_title}}</h2>
    @foreach($post as $key => $val)

    <div class="single-products" style="margin: 10px 0px">
        {!!$val->post_content!!}

    </div>
    <div class="clearfix"></div>
    @endforeach
</div>
<h2 style=" position: inherit" class="title text-center">Bài viết liên quan</h2>
<ul>
    @foreach($related as $key => $post_related)
    <li><a href="{{url('/bai-viet/'.$post_related->post_slug)}}">{{$post_related->post_title}}</a></li>
    @endforeach
</ul>


@endsection