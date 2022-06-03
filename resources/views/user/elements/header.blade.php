<div class="header_top">
    <!--header_top-->
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="contactinfo">
                    <ul class="nav nav-pills">
                        <li><a href="#"><i class="fa fa-phone"></i> +84 036822362</a></li>
                        <li><a href="#"><i class="fa fa-envelope"></i> admin@domain.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="social-icons pull-right">
                    <ul class="nav navbar-nav">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/header_top-->

<div class="header-middle">
    <!--header-middle-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="logo pull-left">
                    <a href="index.html"><img src="images/home/logo.png" alt="" /></a>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="shop-menu pull-right">

                    <ul class="nav navbar-nav">

                        <li><a href="#"> <i class="fa fa-star"></i>Yêu thích</a></li>
                        <?php

                        use Illuminate\Support\Facades\Session;

                        $customer_id = Session::get('customer_id');
                        if ($customer_id != NULL) {

                        ?>
                            <li><a href="{{URL::to('/checkout')}}"> <i class="fa fa-crosshairs"></i>Thanh toán</a></li>

                        <?php
                        } else {
                        ?>
                            <li><a href="{{URL::to('/checkout')}}"> <i class="fa fa-crosshairs"></i>Thanh toán</a></li>

                            <!-- <li><a href="{{URL::to('/login-checkout')}}"> <i class="fa fa-crosshairs"></i>Thanh toán</a></li> -->
                        <?php
                        }
                        ?>
                        <style>
                            span#show-cart li {
                                margin-top: 9px;
                            }
                        </style>
                        <li class="cart-hover" style="position:relative ;"><a href="{{URL::to('/gio-hang')}}"><i class="fa fa-shopping-cart"></i>
                                Giỏ hàng
                                <span id="show-cart"></span>
                                <div class="clearfix"></div>
                                <span id="giohang-hover"></span>
                            </a>

                        </li>


                        <?php

                        $customer_id = Session::get('customer_id');
                        if ($customer_id != NULL) {

                        ?>
                            <li><a href="{{URL::to('/history-order')}}"><i class="fa fa-bell" aria-hidden="true"></i></i>Lịch sử mua hàng</a></li>
                            <li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-lock"></i>Đăng xuất</a></li>
                            <br>
                            <!-- <img width="15%" src="{{Session::get('customer_picture')}}"> <p style="float:right ;">{{Session::get('customer_name') }}</p> -->

                        <?php
                        } else {
                        ?>
                            <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i>Đăng nhập</a></li>
                        <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/header-middle-->
<div class="header-bottom">
    <!--header-bottom-->
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="mainmenu pull-left">
                    <ul class="nav navbar-nav collapse navbar-collapse">
                        <li><a href="{{ URL::to('/trang-chu') }}" class="active">Trang Chủ</a></li>
                        <li class="dropdown"><a href="#">Sản Phẩm<i class="fa fa-angle-down"></i></a>
                            <ul role="menu" class="sub-menu">
                                @foreach($category as $key => $cate)
                                @if($cate->category_parent == 0)
                                <li><a href="{{URL::to('/danh-muc-san-pham/'.$cate->category_id)}}">{{$cate->category_name}}</a></li>
                                @foreach($category as $key => $cate_sub)
                                @if($cate_sub->category_parent == $cate->category_id )
                                <ul>
                                    <li><a href="{{URL::to('/danh-muc-san-pham/'.$cate_sub->category_id)}}">{{$cate_sub->category_name}}</a></li>
                                </ul>
                                @endif
                                @endforeach
                                @endif
                                @endforeach
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#">BLog<i class="fa fa-angle-down"></i></a>
                            <ul role="menu" class="sub-menu">
                                @foreach($category_post as $key =>$cate_post)
                                <li><a href="{{URL::to('/danh-muc-bai-viet/'.$cate_post->cate_post_slug)}}">{{$cate_post->cate_post_name}}</a></li>
                                @endforeach
                            </ul>
                        <li><a href="">Liên Hệ</a></li>
                        </li>

                        <!-- <li><a href="{{URL::to('/login-checkout')}}"><i  class="fa fa-user"></i>Tài khoản</a></li>
                        <li><a href="#"> <i  class="fa fa-start"></i>Yêu thích</a></li>
                        <li><a href="{{URL::to('/checkout')}}">  <i  class="fa fa-crosshairs"></i>Thanh toán</a></li>
                        <li><a href="{{URL::to('/show_cart')}}">Giỏ Hàng</a></li>
                        <li><a href="{{URL::to('/login-checkout')}}"><i  class="fa fa-lock"></i>Đăng Nhập</a></li> -->
                    </ul>
                </div>
            </div>
            <div class="col-sm-4">
                <form action="{{URL::to('/tim-kiem')}}" autocomplete="off" method="POST">
                    {{ csrf_field() }}
                    <div class="">
                        <input type="text" style="width: 100%; " name="keywords_submit" id="keywords" placeholder="Tìm kiếm sản phẩm" />
                        <div id="search_ajax" style="display: none; position: absolute; z-index: 2;"></div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!--/header-bottom-->