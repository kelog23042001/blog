    <?php

    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;

    $message = Session::get('message');
    // if ($message) {
    //     dd($message);
    //     Session::put('message', null);
    // }
    // if (Auth::user()) {
    //     dd(Auth::user()->role_id);
    // }
    ?>
    <!-- HEADER -->
    <header>
        <!-- TOP HEADER -->
        <div id="top-header">
            <div class="container">
                <ul class="header-links pull-left">
                    <li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
                    <li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
                </ul>
                <ul class="header-links pull-right">
                    <li><a href="#"><i class="fa fa-dollar"></i> USD</a></li>
                    @if (Auth::user()) {
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="text-uppercase">
                            <i class="fa fa-user-o"></i>
                            <span>{{Auth::user()->name}}</span>
                        </a>
                        <div class="cart-dropdown " style="width: max-content">
                            <div class="wish-list ">
                                <a href="{{route('logout')}}" style="color: black; display:block; margin-bottom:15px">Đăng xuất</a>
                                <a href="{{route('view_his_orders')}}" style="color: black; display:block; margin-bottom:15px">Lịch sử mua hàng</a>
                                @if (Auth::user()->role_id == 1)
                                <a href="{{route('dashboard')}}" style="color: black; display:block; margin-bottom:15px">Dashboard</a>
                                @endif
                            </div>
                        </div>
                    </li>
                    @else
                    <li>
                        <i class="fa fa-user-o"></i>
                        <a href="{{route('login')}}">Đăng nhập</a>
                    </li>
                    @endif

                </ul>
            </div>
        </div>
        <!-- /TOP HEADER -->

        <!-- MAIN HEADER -->
        <div id="header">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-3">
                        <div class="header-logo">
                            <a href="#" class="logo">
                                <img src="{{asset('Frontend/img/logo.png')}}" alt="">
                            </a>
                        </div>
                    </div>
                    <!-- /LOGO -->

                    <!-- SEARCH BAR -->
                    <div class="col-md-6">
                        <div class="header-search">
                            <form autocomplete="off">
                                <!-- @csrf -->
                                <input type="text" name="keywords_submit" id="keywords" class="input" placeholder="Tìm kiếm sản phẩm" style=" border-radius: 25px 0 0 25px;">
                                <div id="search_ajax" style="display: none; position: absolute; z-index: 9999;"></div>
                                <button class="search-btn">Search</button>
                            </form>
                        </div>
                    </div>
                    <!-- /SEARCH BAR -->

                    <!-- ACCOUNT -->
                    <div class="col-md-3 clearfix">
                        <div class="header-ctn">

                            <!-- Wishlist -->
                            <div class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-heart-o"></i>
                                    <span>Yêu thích</span>
                                    <div class="qty qty_wishlist">0</div>
                                </a>
                                <div class="cart-dropdown">
                                    <div class="wish-list">
                                        <p>Hiện chưa có sản phẩm nào!</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /Wishlist -->

                            <!-- Cart -->
                            <div class="dropdown">
                                <!-- <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"> -->
                                <a href="{{route('cart')}}">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>Giỏ hàng</span>
                                    <div class="qty qty_cart_list">
                                        @php
                                        if(Session::get('cart'))
                                        echo count(Session::get('cart'));
                                        else
                                        echo 0;
                                        @endphp
                                    </div>
                                </a>
                                <div class="cart-dropdown">
                                    <div class="cart-list">
                                        <div class="product-widget">
                                            <div class="product-img">
                                                <img src="" alt="">
                                            </div>
                                            <div class="product-body">
                                                <h3 class="product-name"><a href="#">product name goes here</a></h3>
                                                <h4 class="product-price"><span class="qty">1x</span>$980.00</h4>
                                            </div>
                                            <button class="delete"><i class="fa fa-close"></i></button>
                                        </div>
                                    </div>
                                    <div class="cart-summary">
                                        <small>3 Item(s) selected</small>
                                        <h5>SUBTOTAL: $2940.00</h5>
                                    </div>
                                    <div class="cart-btns">
                                        <a href="#">View Cart</a>
                                        <a href="#">Checkout <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Cart -->

                            <!-- Menu Toogle -->
                            <div class="menu-toggle">
                                <a href="#">
                                    <i class="fa fa-bars"></i>
                                    <span>Menu</span>
                                </a>
                            </div>
                            <!-- /Menu Toogle -->
                        </div>
                    </div>
                    <!-- /ACCOUNT -->
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- /MAIN HEADER -->
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    <nav id="navigation">
        <!-- container -->
        <div class="container">
            <!-- responsive-nav -->
            <div id="responsive-nav">
                <!-- NAV -->
                <ul class="main-nav nav navbar-nav" id="category_tabs">
                    <li style="text-transform: uppercase;" id="hometab"><a href="/">Trang chủ</a></li>
                    @foreach($categories as $key=> $category )
                    <li style="text-transform: uppercase;" id="{{$category->category_id}}">
                        <a href="{{route('category_products', $category->category_id)}}">{{$category->category_name}}</a>
                    </li>
                    @endforeach
                </ul>
                <!-- /NAV -->
            </div>
            <!-- /responsive-nav -->
        </div>
        <!-- /container -->
    </nav>
    <!-- /NAVIGATION -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        const activePage = window.location.pathname.split('/danh-muc-san-pham/')[1];
        if (!activePage) {
            $('li#hometab').attr('class', 'active')
        };

        const navLinks = document.querySelectorAll('ul li a')
        navLinks.forEach(link => {
            if (link.href.split('/danh-muc-san-pham/').includes(`${activePage}`)) {
                $('li#' + activePage).attr('class', 'active');
            }
        })
    </script>
    <script>
        function view() {
            if (localStorage.getItem('data') != null) {
                var data = JSON.parse(localStorage.getItem('data'));
                data.reverse();
                for (i = 0; i < data.length; i++) {
                    var name = data[i].name;
                    var price = data[i].price;
                    var image = data[i].image;
                    var url = data[i].url;
                    $("#row_wishlist").append(
                        '<a class= "item_viewed">' +
                        '<div class = "row row_viewed" >' +
                        '<div class ="col-md-4">' +
                        '<img src = "' + image + '" width = "100%">' +
                        '</div>' +
                        '<div class ="col-md-8" info_wishlist >' +
                        '<p style = "margin: 0;">' + name + '</p>' +
                        '<p style = "margin: 0;color:#FE980F">' + price + '</p>' +
                        '</div>' +
                        '</div>' +
                        '</a>'
                    );
                }
            }
        }
        view();
    </script>