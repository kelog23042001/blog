    <h2 style="margin-top: 13px;">Danh Mục Sản Phẩm</h2>
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
                        <li class="category" style="margin: 0 5px">
                            <a href="{{URL::to('/danh-muc-san-pham/'.$cate_sub->category_id)}}">{{$cate_sub->category_name}} </a>
                        </li>
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

    <!--/brands_products-->
    <!--price-range-->
    <!-- <div class="price-range">
        <div class="text-center">
            <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2"><br />
            <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
        </div>
    </div> -->
    <!--/price-range-->
