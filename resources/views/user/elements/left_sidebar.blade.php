<div class="left-sidebar">
    <h2>Danh Mục Sản Phẩm</h2>
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

    <div class="brands_products">
        <!--like-range-->
        <h2>Sản phẩm đã xem</h2>
        <div class="brands-name">
            <div id="row_viewed" class="row"></div>
        </div>
    </div>
    <!--/like-range-->
    <div class="brands_products">
        <!--like-range-->
        <h2>Sản phẩm yêu thích</h2>
        <div class="brands-name">
            <div id="row_wishlist" class="row"></div>
        </div>
    </div>
    <!--/like-range-->
</div>