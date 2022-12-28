<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{$meta_decs}}">
    <meta name="author" content="">
    <meta name="keywords" content="{{$meta_keyword}} " />
    <meta name="robots" content="INDEX,FOLLOW" />
    <link rel="canonical" href="{{$url_canonical}}" />
    <link rel="icon" type="image/x-icon" href="" />
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="shortcut icon" type="image/ico" href="{{asset('frontend/images/shop/lk2.jpg')}}">
    <title>{{$meta_title}}</title>
    <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/sweetalert.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/lightgallery.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/lightslider.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/prettify.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">


    <link rel="stylesheet" href="{{asset('frontend/css/typography.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<!--/head-->

<body>
    <header id="header">
        <!--header-->
        @include('user.elements.header')
    </header>
    <!--/header-->
    <section>
        <div class="container">
            <div class="row">
                @yield('content')
            </div>
        </div>
    </section>

    <footer id="footer">
        <!--Footer-->
        @include('user.elements.footer')
    </footer>
    <!--/Footer-->
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <!-- <script>
        var USD = document.getElementById("vnd_to_usd").value;
        paypal.Button.render({
            // Configure environment
            env: 'sandbox',
            client: {
                sandbox: 'AduvjquEdM1gF3IXs4bSoOXCDdTZmMB-e_D2FQe6bBJLxotkZ0N9mvqf77_dgYYONgqcSerHvLGESi6w',
                production: 'demo_production_client_id'
            },
            // Customize button (optional)
            locale: 'en_US',
            style: {
                size: 'small',
                color: 'gold',
                shape: 'pill',
            },

            // Enable Pay Now checkout flow (optional)
            commit: true,

            // Set up a payment
            payment: function(data, actions) {
                return actions.payment.create({
                    transactions: [{
                        amount: {
                            total: `${USD}`,
                            currency: 'USD'
                        }
                    }]
                });
            },
            // Execute the payment
            onAuthorize: function(data, actions) {
                return actions.payment.execute().then(function() {
                    // Show a confirmation message to the buyer
                    window.alert('Cảm ơn đã mua hàng!');
                });
            }
        }, '#paypal-button');
    </script> -->
    <script src="{{asset('frontend/js/jquery.js')}}"></script>
    <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('frontend/js/price-range.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('frontend/js/main.js')}}"></script>
    <script src="{{asset('frontend/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('frontend/js/prettify.js')}}"></script>
    <script src="{{asset('frontend/js/lightslider.js')}}"></script>
    <script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{asset('frontend/js/simple.money.format.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <script src="{{asset('frontend/js/slick.min.js')}}"></script>
    <script src="{{asset('frontend/js/slick-animation.min.js')}}"></script>
    <script src="{{asset('frontend/js/custom.js')}}"></script>
    <!-- <script src="{{asset('frontend/js/scroll.js')}}"></script> -->
    <script>
        $('.category-filter').click(function(){
            var category = [], temArray = [];
            $.each($("[data-filters='category']:checked"), function(){
                temArray.push($(this).val())
            });
            temArray.reverse();
            if(temArray.length !==0){
                category+='?cate='+temArray.toString();
            }
            window.location.href = category
        })
        $('.brand-filter').click(function(){
            var brand = [], temArray = [];
            $.each($("[data-filters='brand']:checked"), function(){
                temArray.push($(this).val())
            });
            temArray.reverse();
            if(temArray.length !=0){
                brand+='?brand='+temArray.toString();
            }
            window.location.href = brand
        })
    </script>
     <script>
        load_more_selling_product();
        function load_more_selling_product(id = ''){

            $.ajax({
                url:"{{url('load-more-selling-product')}}",
                method:"POST",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
                },
                data:{
                    id:id
                },
                success: function(data){
                    $('#load_more_selling_button').remove();
                    $('#all_selling_product').append(data);
                }
            });
        }

        $(document).on('click', '#load_more_selling_button', function(){
            var id = $(this).data('id');
            load_more_selling_product(id);
            alert(id);
        })
    </script>
    <script>
        load_more_product();
        function load_more_product(id = ''){
            $.ajax({
                url:"{{url('load-more-product')}}",
                method:"POST",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
                },
                data:{
                    id:id
                },
                success: function(data){
                    $('#load_more_button').remove();
                    $('#all_product').append(data);
                }
            });
        }

        $(document).on('click', '#load_more_button', function(){
            var id = $(this).data('id');
            load_more_product(id);

        })
    </script>
    <script type="text/javascript">
        $('.order_details').on('change', function() {
            var order_status = $(this).val();
            var order_id = $(this).children(":selected").attr("id")
            var _token = $('input[name="_token"]').val();
            quantity = [];
            $("input[name='product_sales_quantity']").each(function() {
                quantity.push($(this).val());
            });
            // lay ra product id
            order_product_id = [];
            $("input[name='order_product_id']").each(function() {
                order_product_id.push($(this).val());
            });

            j = 0;
            for (i = 0; i < order_product_id.length; i++) {
                var order_qty = $('.order_qty_' + order_product_id[i]).val();
                var order_qty_storage = $('.order_qty_storage_' + order_product_id[i]).val();

                if (parseInt(order_qty) > parseInt(order_qty_storage)) {
                    j++;
                    if (j == 1) {
                        alert('Số lượng trong kho không đủ');
                    }
                    $('.color_qty_' + order_product_id[i]).css('background', '#000');
                }
            }

            if (j == 0) {
                alert('Cập nhật trạng thái đơn hàng thành công');
                location.reload();
                $.ajax({
                    url: '{{url('/update-order-quantity')}}',
                    method: 'POST',
                    data: {
                        _token: _token,
                        order_status: order_status,
                        order_id: order_id,
                        quantity: quantity,
                        order_product_id: order_product_id
                    },
                });
            }
        });
    </script>
       <!-- cập nhật số lượng đặt hàng -->
       <script type="text/javascript">
        $('.update_quantity_order').click(function() {
            var order_product_id = $(this).data('product_id');
            var order_qty = $('.order_qty_' + order_product_id).val();
            var order_code = $('.order_code').val();
            var _token = $('input[name="_token"]').val();

            // $.ajax({
            //     url: '{{url('/update-qty')}}',
            //     method: 'POST',
            //     data: {
            //         _token: _token,
            //         order_product_id: order_product_id,
            //         order_qty: order_qty,
            //         order_code: order_code
            //     },

            //     success: function(data) {
            //         alert('Cập nhật số lượng đặt hàng thành công11');
            //         location.reload();
            //     }
            // });

            alert(order_product_id);
            // alert(order_qty);
            // alert(order_code);
        });
    </script>
 <script>
        function show_quick_cart(){
            $.ajax({
                url: '{{url('/show-quick-cart')}}',
                method: 'GET',

                success: function(data) {
                        $('#show_quick_cart').html(data);
                        $('#quick-cart').modal();
                        show_cart();
                        hover_cart();

                }

            });
        }
        function DeleteItemCart($session_id){
            var session_id = $session_id;
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{url('/del-product')}}' +'/'+session_id,
                method: 'GET',
                data: {
                    session_id: session_id,
                    _token: _token
                },
                success: function() {
                    $('#show_quick_cart_alert').append('<p class = "text text-success">Xoá sản phẩm trong giỏ hàng thành công</p>')
                    setTimeout(function(){
                    $('#show_quick_cart_alert').fadeOut(1000);
                   },1000);
                    show_quick_cart();
                        show_cart();
                        hover_cart();
                }

            });
        }
        $(document).on('input', '.cart_qty_update', function(){
            var quantity = $(this).val();
            // var product_quantity = document.getElementById('remain_qty_cart');
            var session_id = $(this).data('session_id');
            // var remain_qty = $(this).data('session_remain_qty');
            var remain_qty;
            var _token = $('input[name="_token"]').val();
            // alert(remain_qty);

            $.ajax({
                url: '{{url('/update-quick-cart')}}' ,
                method: 'POST',
                data: {
                    quantity:quantity,
                    session_id: session_id,
                    _token: _token
                },
                success: function() {
                    show_quick_cart();
                    show_cart();
                    hover_cart();
                }

            });
        })
        function Addtocart($product_id){

            var id = $product_id;

            var cart_product_id = $('.cart_product_id_' + id).val();

            var cart_product_name = $('.cart_product_name_' + id).val();

            var cart_product_image = $('.cart_product_image_' + id).val();

            var cart_product_price = $('.cart_product_price_' + id).val();

            var cart_product_qty = $('.cart_product_qty_' + id).val();

            var remain_qty = $('.product_qty_' + id).val();

            var _token = $('input[name="_token"]').val();
            // alert(cart_product_image);
            // alert(cart_product_qty);
            // alert(cart_product_price);
            // alert(cart_product_name);
            // alert(cart_product_id);
            $.ajax({
                url: '{{url('/add-cart-ajax')}}',
                method: 'POST',
                data: {
                    cart_product_id: cart_product_id,
                    cart_product_name: cart_product_name,
                    cart_product_image: cart_product_image,
                    cart_product_price: cart_product_price,
                    cart_product_qty: cart_product_qty,
                    remain_qty : remain_qty,
                    _token: _token
                },
                success: function() {
                   show_quick_cart();
                    // swal({
                    //         title: "Đã thêm sản phẩm vào giỏ hàng",
                    //         text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                    //         showCancelButton: true,
                    //         cancelButtonText: "Xem tiếp",
                    //         confirmButtonClass: "btn-success",
                    //         confirmButtonText: "Đi đến giỏ hàng",
                    //         closeOnConfirm: false
                    //     },
                    //     function() {
                    //         window.location.href = "{{url('/gio-hang')}}";
                    //     });
                        show_cart();
                        hover_cart();

                }

            });


        }
    </script>
    <script>

        function delete_compare(id){
            if(localStorage.getItem('compare') != null){
                var data = JSON.parse(localStorage.getItem('compare'));
                var index = data.findIndex(item => item.id === id);
                data.splice(index, 1);
                localStorage.setItem('compare', JSON.stringify(data));
                document.getElementById('row_compare'+id).remove();

            }
        }
        sosanh();
        function sosanh(){
            if(localStorage.getItem('compare') != null){
                var data = JSON.parse(localStorage.getItem('compare'));
                for(i=0; i< data.length; i++){
                    var name = data[i].name;
                    var price =  data[i].price;
                    var image  =  data[i].image;
                    var url = data[i].url;
                    var desc = data[i].desc;
                    var id = data[i].id;
                    $('#row_compare').find('tbody').append(
                        '<tr id= "row_compare'+id+'">'+
                            '<td><img height="190px" src = "'+image+'"</td>'+
                            '<td style="width: 150px;" >'+name+'</td>'+
                            '<td style="width: 100px;" >'+price+'</td>'+
                            // '<td></td>'+
                            // '<td></td>'+
                            '<td style="width: 300px;" > <div class ="product_desc">'+desc+'</div></td>'+
                            '<td><a href = "'+url+'"><i class="fa fa-eye text-success text-active"></i></a></td>'+
                            '<td onclick = "delete_compare('+id+')">'+
                                '<a style = "cursor: pointer"><i class="fa fa-times text-danger text"></i></a>'+
                            '</td>'+
                        '</tr>'
                    );
                }
            }

        }


        function add_compare(product_id){

            document.getElementById('title-compare').innerText = 'Chỉ cho phép so sánh tối đa 3 sản phẩm';
            var id = product_id;
            var name = document.getElementById('wishlist_productname'+id).value;
            var desc = document.getElementById('wishlist_productdesc'+id).value;
            var price =   document.getElementById('wishlist_productprice'+id).value;
            var image =  document.getElementById('wishlist_productimage'+id).src;
            var url=  document.getElementById('wishlist_producturl'+id).href;

            var newItem={
                'url':url,
                'id':id,
                'desc' : desc,
                'name':name,
                'price':price,
                'image':image
            }
            if( localStorage.getItem('compare') == null){
                localStorage.setItem('compare','[]');
            }
            var old_data = JSON.parse(localStorage.getItem('compare'));

            var matches = $.grep(old_data,function(obj){
                return obj.id == id;
            })
            if(matches.length){
                // alert('Sản phẩm bạn đã yêu thích,nên không thể thêm');
            }else{
               if(old_data.length <=3){
                   old_data.push(newItem);
                   $('#row_compare').find('tbody').append(
                        '<tr id= "row_compare'+id+'">'+
                            '<td><img height="190px" src = "'+image+'"></td>'+
                            '<td style="width: 150px;">'+newItem.name+'</td>'+
                            '<td style="width: 100px;">'+newItem.price+'</td>'+
                            '<td style="width: 300px;"><div class ="product_desc">'+newItem.desc+'</div></td>'+
                            '<td>'+
                                '<a href = "'+newItem.url+'">'+
                                '<i class="fa fa-eye text-success text-active"></i>'+
                                '</a>'+
                            '</td>'+
                            '<td onclick = "delete_compare('+id+')">'+
                                '<a style = "cursor: pointer">'+
                            '       <i class="fa fa-times text-danger text"></i>'+
                                '</a>'+
                            '</td>'+
                        '</tr>'
                    );
               }
            }
            localStorage.setItem('compare',JSON.stringify(old_data));
            $('#sosanh').modal();

        }

    </script>
      <script>
        $(document).ready(function(){
            $('#sort').on('change', function(){
                var url = $(this).val();
                if(url){
                    window.location = url;
                }
                return false;
            });
            $('.sort_price').on('change', function(){
                var url = $(this).val();
                // if(url){
                //     window.location = url;
                // }
                // return false;
                alert(url);
            });
        })
    </script>

    <script>
        $(document).ready(function(){

            $( "#slider-range" ).slider({
            orientation: "horizontal",
            range: true,
            values: [ {{ $min_price }}, {{ $max_price }} ],
            step: 10000,
            min:{{ $min_price_range }},
            max:{{ $max_price_range }},
            slide: function( event, ui ) {
                $( "#amount_start" ).val(  ui.values[ 0 ] + 'VND' ).simpleMoneyFormat() ;
                $( "#amount_end" ).val( ui.values[ 1 ]  + 'VND').simpleMoneyFormat();
                $( "#start_price" ).val(ui.values[ 0 ]);
                $( "#end_price" ).val(ui.values[ 1 ] );

            },
            location:$(this).val(),
            });
            $( "#amount_start" ).val( $( "#slider-range" ).slider( "values", 0 ) + 'VND'  ).simpleMoneyFormat();
            $( "#amount_end" ).val(  $( "#slider-range" ).slider( "values", 1 ) +  'VND').simpleMoneyFormat();

        })
    </script>

    <script type="text/javascript">
        function remove_backgound(product_id){
            for(var count = 1; count <=5; count++){
                $('#'+product_id+'-'+count).css('color', '#ccc');
            }
        }
        //hover rating start
        $(document).on('mouseenter', '.rating', function(){
            var index = $(this).data("index");
            var product_id = $(this).data("product_id");
            remove_backgound(product_id);

            for(var count = 1; count <= index; count++){
                $('#'+product_id+'-'+count).css('color', '#ffcc00');
            }
        });

        //remove hover rating start
        $(document).on('mouseleave', '.rating', function(){
            var index = $(this).data("index");
            var product_id = $(this).data("product_id");
            var rating = $(this).data("rating");
            remove_backgound(product_id);
            for(var count = 1; count <= rating; count++){
                $('#' + product_id +'-' +count).css('color', '#ffcc00');
            }
        });

        // click rating start
        $(document).on('click', '.rating', function(){
            var index = $(this).data("index");
            var product_id = $(this).data("product_id");
            var _token = $('input[name = "_token"]').val();
            // alert(index);
            $.ajax({
                url:"{{url('insert-rating')}}",
                method:"POST",
                data:{index:index, product_id:product_id, _token:_token},
                success: function(){
                    if(data = 'done'){
                        alert("Bạn đã đánh giá " + index +" sao");
                    }else{
                        alert("Đánh giá lỗi");
                    }
                    location.reload();
                }
            });
        });
    </script>




    <!-- Sản phẩm đã xem -->
    <script>
        function viewed(){
            if(localStorage.getItem('viewed') != null){
                var data = JSON.parse(localStorage.getItem('viewed'));
                data.reverse();
                document.getElementById('row_viewed').style.overflowY = 'scroll';
                document.getElementById('row_viewed').style.overflowX = 'hidden';
                document.getElementById('row_viewed').style.height  =    '300px';
                for(i=0; i<data.length; i++){
                    var name = data[i].name;
                    var price =  data[i].price;
                    var image  =  data[i].image;
                    var url = data[i].url;
                    $("#row_viewed").append(
                        '<a class= "item_viewed">'+
                            '<div class = "row row_viewed" >'+
                                '<div class ="col-md-4">'+
                                    '<img src = "'+image+'" width = "100%">'+
                                '</div>'+
                                '<div class ="col-md-8" info_wishlist >'+
                                    '<p style = "margin: 0;">'+name+'</p>'+
                                    '<p style = "margin: 0;color:#FE980F">'+price+'</p>'+
                                '</div>'+
                            '</div>'+
                        '</a>'
                    );
                }
            }
        }

        product_viewed();
        viewed();

        function product_viewed(){
            var id_product = $('#product_viewed_id').val();

            if(id_product!=undefined){
                var id = id_product;
                var name = document.getElementById('viewed_productname'+id).value;
                var price =   document.getElementById('viewed_productprice'+id).value;
                var image =  document.getElementById('viewed_productimage'+id).value;
                var url=  document.getElementById('viewed_producturl'+id).value;

                var newItem={
                    'url':url,
                    'id':id_product,
                    'name':name,
                    'price':price,
                    'image':image
                }
                if( localStorage.getItem('viewed') == null){
                    localStorage.setItem('viewed','[]');
                }
                var old_data = JSON.parse(localStorage.getItem('viewed'));

                var matches = $.grep(old_data,function(obj){
                    return obj.id == id;
                })
                if(matches.length){

                }else{
                    old_data.push(newItem);
                    $("#row_viewed").append('<div class = "row" style = "margin:10px 0"><div class ="col-md-4"><img src = "'+
                            newItem.image+'" width = "100%"></div><div class ="col-md-8" info_wishlist ><p style = "  margin: 0;">'+newItem.name+'</p><p style = "  margin: 0;color:#FE980F">'+
                            newItem.price+'</p><a href = "'+newItem.url+'">Đặt hàng</a></div></div>');
                }
                localStorage.setItem('viewed',JSON.stringify(old_data));
            }

        }
    </script>
    <!-- Sản phẩm yêu thích -->
    <script>
       function view(){
            if(localStorage.getItem('data') != null){
                var data = JSON.parse(localStorage.getItem('data'));
                data.reverse();
                document.getElementById('row_wishlist').style.overflowY = 'scroll';
                document.getElementById('row_wishlist').style.overflowX = 'hidden';
                document.getElementById('row_wishlist').style.height  =    '300px';
                for(i=0; i<data.length; i++){
                    var name = data[i].name;
                    var price =  data[i].price;
                    var image  =  data[i].image;
                    var url = data[i].url;

                    $("#row_wishlist").append(
                        '<a class= "item_viewed">'+
                            '<div class = "row row_viewed" >'+
                                '<div class ="col-md-4">'+
                                    '<img src = "'+image+'" width = "100%">'+
                                '</div>'+
                                '<div class ="col-md-8" info_wishlist >'+
                                    '<p style = "margin: 0;">'+name+'</p>'+
                                    '<p style = "margin: 0;color:#FE980F">'+price+'</p>'+
                                '</div>'+
                            '</div>'+
                        '</a>'
                    );
                        // $("#row_wishlist").append
                        // ('<div class = "row" style = "margin:10px 0"><div class ="col-md-4"><img src = "'+
                        // image+'" width = "100%"></div><div class ="col-md-8" info_wishlist ><p style = "  margin: 0;">'+name+'</p><p style = "  margin: 0;color:#FE980F">'+
                        //  price+'</p><a href = "'+url+'">Đặt hàng</a></div></div>')
                    }
            }
     }
        view();

        function add_wistlist(clicked_id){
            var id = clicked_id;
            var name = document.getElementById('wishlist_productname'+id).value;
            var price =   document.getElementById('wishlist_productprice'+id).value;
            var image =  document.getElementById('wishlist_productimage'+id).src;
            var url=  document.getElementById('wishlist_producturl'+id).href;

            var newItem={
                'url':url,
                'id':id,
                'name':name,
                'price':price,
                'image':image
            }
            if( localStorage.getItem('data') == null){
                localStorage.setItem('data','[]');
            }
            var old_data = JSON.parse(localStorage.getItem('data'));

            var matches = $.grep(old_data,function(obj){
                return obj.id == id;
            })
            if(matches.length){
                alert('Sản phẩm bạn đã yêu thích,nên không thể thêm');
            }else{
                old_data.push(newItem);
                $("#row_wishlist").append('<div class = "row" style = "margin:10px 0"><div class ="col-md-4"><img src = "'+
                        newItem.image+'" width = "100%"></div><div class ="col-md-8" info_wishlist ><p style = "  margin: 0;">'+newItem.name+'</p><p style = "  margin: 0;color:#FE980F">'+
                         newItem.price+'</p><a href = "'+newItem.url+'">Đặt hàng</a></div></div>')
            }
            localStorage.setItem('data',JSON.stringify(old_data));
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // alert(product_id);
            load_comment()

            function load_comment() {
                var product_id = $('.comment_product_id').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{('/load-comment')}}",
                    method: "POST",
                    data: {
                        product_id: product_id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#comment_show').html(data);
                    }
                });
            }
            $('.send-comment').click(function() {
                var product_id = $('.comment_product_id').val();
                var comment_name =  $('.comment_name').val();
                var comment_content = $('.comment_content').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{('/send-comment')}}",
                    method: "POST",
                    data: {
                        product_id: product_id,
                        comment_name: comment_name,
                        comment_content: comment_content,
                        _token: _token
                    },
                    success: function(data) {
                        // $('#notify_comment').html('<span class="text text-success">Thêm bình luận thành công</span>');

                        load_comment();
                        swal("Gửi bình luận", "Bình luận đang chờ duyệt! Xin cảm ơn", "success");
                        $('.comment_name').val('');
                        $('.comment_content').val('');
                    }
                });
            });
        });
    </script>


    <script>
        hover_cart();
        function hover_cart(){
            $.ajax({
                    url: "{{('/hover-cart')}}",
                    method: "GET",

                    success: function(data) {
                        // $('#notify_comment').html('<span class="text text-success">Thêm bình luận thành công</span>');
                        $('#giohang-hover').html(data);
                    }
                });
        }
        show_cart();
            //show carrt
            function show_cart(){
                $.ajax({
                    url: "{{('/show-cart-qty')}}",
                    method: "GET",

                    success: function(data) {
                        // $('#notify_comment').html('<span class="text text-success">Thêm bình luận thành công</span>');
                        $('#show-cart').html(data);

                    }
                });
            }
        $(document).ready(function() {
            $('.add-to-cart').click(function() {
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.qty').val();
                var remain_qty = $('.product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
                // alert();
                $.ajax({
                    url: '{{url('/add-cart-ajax')}}',
                    method: 'POST',
                    data: {
                        cart_product_id: cart_product_id,
                        cart_product_name: cart_product_name,
                        cart_product_image: cart_product_image,
                        cart_product_price: cart_product_price,
                        cart_product_qty: cart_product_qty,
                        remain_qty: remain_qty,
                        _token: _token
                    },
                    success: function() {
                        swal({
                            title: "Đã thêm sản phẩm vào giỏ hàng",
                            text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                            showCancelButton: true,
                            cancelButtonText: "Xem tiếp",
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "Đi đến giỏ hàng",
                            closeOnConfirm: false
                        },
                        function() {
                            window.location.href = "{{url('/gio-hang')}}";
                        });
                        show_cart();
                        hover_cart();
                    }
                });
            });
        });
    </script>

<script>
    function setDomain() {
        let domain = 300;
        document.getElementById('qty_product').setAttribute('value', domain);
    }
</script>
    <script>
        $(document).ready(function() {
            $('#imageGallery').lightSlider({
                gallery: true,
                item: 1,
                loop: true,
                thumbItem: 9,
                slideMargin: 0,
                enableDrag: false,
                currentPagerPosition: 'left',
                onSliderLoad: function(el) {
                    el.lightGallery({
                        selector: '#imageGallery .lslide'
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.choose').on('change', function() {
                var action = $(this).attr('id');
                var id = $(this).val();
                var _token = $('input[name="_token"]').val();
                var result = '';

                if (action == 'city') {
                    result = 'province';
                } else {
                    result = 'wards';
                }
                $.ajax({
                    url: '{{url('/select-delivery-home')}}',
                    method: 'POST',
                    data: {
                        action: action,
                        id: id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#' + result).html(data);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.wards').click(function() {
                var matp = $('.city').val();
                var maqh = $('.province').val();
                var xaid = $('.wards').val();
                var _token = $('input[name="_token"]').val();
                if (matp == '' && maqh == '' && xaid == '')
                    alert('Làm ơn chọn địa điểm');
                else {
                    $.ajax({
                        url: '{{url('/calculate-fee')}}',
                        method: 'POST',
                        data: {
                            matp: matp,
                            maqh: maqh,
                            xaid: xaid,
                            _token: _token
                        },
                        success: function() {
                            location.reload();
                        }
                    });
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.send_order').click(function() {
                var matp = document.getElementById("wards").value;
                if(matp == ''){
                    alert('Hãy chọn địa chỉ nhận hàng')
                }else{
                    swal({
                        title: "Xác nhận đặt hàng?",
                        text: "Bạn có muốn đặt hàng không?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Có",
                        cancelButtonText: "Không",
                        closeOnConfirm: true,
                        closeOnCancel: true,
                        showLoaderOnConfirm: true
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            var shipping_email = $('.shipping_email').val();
                            var shipping_name = $('.shipping_name').val();
                            var shipping_address = $('.shipping_address').val();
                            var shipping_phone = $('.shipping_phone').val();
                            var shipping_notes = $('.shipping_notes').val();
                            var shipping_method = $('.payment_select').val();
                            var order_fee = $('.order_fee').val();
                            var order_coupon = $('.order_coupon').val();
                            var _token = $('input[name="_token"]').val();
                            $.ajax({
                                url: '{{url('/confirm-order')}}',
                                method: 'POST',
                                data: {
                                    shipping_email: shipping_email,
                                    shipping_name: shipping_name,
                                    shipping_address: shipping_address,
                                    shipping_notes: shipping_notes,
                                    shipping_phone: shipping_phone,
                                    shipping_method: shipping_method,
                                    order_fee: order_fee,
                                    order_coupon: order_coupon,
                                    _token: _token
                                },
                                success: function() {
                                    swal("Đặt hàng!", "Đơn đặt hàng của bạn đã đặt thành công", "success");
                                    location.reload();
                                }
                            });
                            }else{
                                swal("Đóng", "Đơn hàng chưa được gửi, làm ơn hoàn tất đơn hàng", "error");
                            }
                    });
                }
               
            });
        });
    </script>

    <script>
        $('#keywords').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{('/autocomplete-ajax')}}",
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(data) {
                        $('#search_ajax').fadeIn();
                        $('#search_ajax').html(data);
                    }
                });
            } else {
                $('#search_ajax').fadeOut();
            }
        });

        $(document).on('click', '.li_search_ajax', function() {
            $('#keywords').val($(this).text());
            $('#search_ajax').fadeOut();
        });
    </script>

<script>
    function checkQty(){
        // var product_quantity = document.getElementById('soluongcon').getAttribute('value');
        var product_quantity = document.getElementById('soluongcon');
        ele = document.getElementById('qty_product')
        // alert( );
        var quantity = product_quantity.value - ele.value
        if(quantity < 0){
            ele.value = product_quantity.value;
        }
    }
</script>
<script>
    function changMethod(){
        var method = document.getElementById("payment_select").value;
        if(method == 0){
            document.getElementById('PaypalButton').style.display = 'block';
            document.getElementById('PaypalButton').style.float = 'left';
            // document.getElementById('VNPayButton').style.display = 'block';
            document.getElementById('MomoPaylButton').style.display = 'block';
        }else{
            document.getElementById('PaypalButton').style.display = 'none';
            document.getElementById('PaypalButton').style.float = 'left';
            // document.getElementById('VNPayButton').style.display = 'block';
            document.getElementById('MomoPaylButton').style.display = 'none';
        }
    }
</script>
</body>

</html>
