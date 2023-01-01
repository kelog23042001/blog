<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{$meta_title}}</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{asset('Frontend/css/bootstrap.min.css')}}" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{asset('Frontend/css/slick.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('Frontend/css/slick-theme.css')}}" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{asset('Frontend/css/nouislider.min.css')}}" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{asset('Frontend/css/font-awesome.min.css')}}">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{asset('Frontend/css/style.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('Frontend/css/sweetalert.css')}}" />
    <link rel="stylesheet" href="{{asset('/Backend/vendors/choices.js/choices.min.css')}}">

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />

    <!-- RTL version -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css" />
</head>

<body>
    @include('user.elements.header')
    @yield('content')
    @include('user.elements.footer')
    <!-- jQuery Plugins -->
    <script src="{{asset('Frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('Frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('Frontend/js/slick.min.js')}}"></script>
    <script src="{{asset('Frontend/js/nouislider.min.js')}}"></script>
    <script src="{{asset('Frontend/js/jquery.zoom.min.js')}}"></script>
    <script src="{{asset('Frontend/js/main.js')}}"></script>
    <script src="{{asset('Frontend/js/sweetalert.min.js')}}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="{{asset('Backend/vendors/choices.js/choices.min.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.order_details').on('change', function() {
            var order_status = $(this).val();
            var order_code = $(this).children(":selected").attr("id")
            quantity = [];
            $.ajax({
                url: "{{url('/destroy-order')}}",
                method: 'POST',
                data: {
                    order_status: order_status,
                    order_id: order_code,
                },
            });
        });

        $(document).ready(function() {
            $('.check_coupon').click(function() {
                getDataOrder();
            })

            function getDataOrder() {
                // save data to local storage
                data = {
                    shipping_email: $('.shipping_email').val(),
                    shipping_name: $('.shipping_name').val(),
                    shipping_phone: $('.shipping_phone').val(),
                    shipping_notes: $('.shipping_notes').val(),
                    shipping_address: $('.shipping_address').val(),
                    shipping_method: $('input[name=payment]:checked', '#payment-method').val(),
                    order_fee: $('.order_fee').val(),
                    order_discount: $('.order_coupon').val(),
                    coupon_code: $('.coupon_code').val(),
                    total_order: $('#order_total').val()
                }
                window.localStorage.setItem("data", JSON.stringify(data));
            }

            function sendOrder() {
                data = JSON.parse(window.localStorage.getItem("data"));
                $.ajax({
                    url: "{{url('/confirm-order')}}",
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        swal({
                                title: "Đặt hàng thành công!",
                                // text: "",
                                icon: "success",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Xem đơn hàng",
                                cancelButtonText: "Trang chủ",
                                closeOnConfirm: true,
                                closeOnCancel: true,
                                showLoaderOnConfirm: true
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    window.location.href = `{{url('/view-history-order/${response.order_code}')}}`;
                                } else {
                                    window.location.href = `{{url('/')}}`;
                                }
                            });
                    },
                    // error: function(xhr, status, error) {
                    //     
                    // }
                    error: function(xhr) {
                        var err = JSON.parse(xhr.responseText).errors;
                        for (const [key, value] of Object.entries(err)) {
                            // console.log(`${key}: ${value}`);
                            alertify.error(`${value}`);
                            // alertify.error('Error notification message.');
                        }
                        // swal(err.errors);
                    }
                });
            }

            $('.send_order').click(function() {
                getDataOrder()
                var paymentMethod = $('input[name=payment]:checked', '#payment-method').val()

                if (paymentMethod == 'paypal') {
                    window.location.href = "{{route('processTransaction')}}";
                } else if (paymentMethod == 'momo') {
                    // payment by momo
                    order_total = $('#order-total').val()
                    if (order_total < 10000) {
                        // alert(order_total)
                        swal({
                            title: "Cảnh Báo",
                            text: "Yêu cầu bị từ chối vì số tiền giao dịch nhỏ hơn số tiền tối thiểu cho phép là 10.000 VND hoặc lớn hơn số tiền tối đa cho phép là 50.000.000 VND",
                            type: "warning",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Đóng",
                            // cancelButtonText: "Không",
                            closeOnConfirm: false,
                            closeOnCancel: false,
                            showLoaderOnConfirm: true
                        })
                    } else {
                        $.ajax({
                            url: "{{url('/momo_payment')}}",
                            method: 'POST',
                            data: {
                                // 'total_momopay': 99999
                                'total_momopay': order_total
                            },
                            success: function(response) {
                                window.location.href = response
                            }
                        })
                    }
                } else {
                    sendOrder();
                }
            });

            $('.choose').on('change', function() {
                var action = $(this).attr('id');
                var id = $(this).val();
                // alert(action)
                var result = '';
                $.ajax({
                    url: "{{url('/select-delivery-home')}}",
                    method: 'POST',
                    data: {
                        action: action,
                        id: id,
                    },
                    success: function(response) {
                        // $('#province').html();
                        if (action == 'city') {
                            $('#province').html(response);
                        } else {
                            $('#wards').html(response);
                        }
                    }
                });
            });

            $('.wards').change(function() {
                var matp = $('#city').val();
                var maqh = $('#province').val();
                var xaid = $('#wards').val();
                // alert(xaid);
                if (xaid != "non") {
                    // alert(maqh);
                    if (matp == '' && maqh == '' && xaid == '')
                        alert('Làm ơn chọn địa điểm');
                    else {
                        $.ajax({
                            url: "{{url('/calculate-fee')}}",
                            method: 'POST',
                            data: {
                                matp: matp,
                                maqh: maqh,
                                xaid: xaid,
                            },
                            success: function(response) {
                                // const fee = new Intl.NumberFormat('vi-VN', {
                                //     style: 'currency',
                                //     currency: 'VND',
                                // });
                                // console.log(response)
                                // $('.order_fee').text(fee.format(response))
                                getDataOrder()
                                location.reload();
                            }
                        });
                    }
                }

            });
            hover_cart();

            function hover_cart() {
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
            function show_cart() {
                $.ajax({
                    url: "{{('/show-cart-qty')}}",
                    method: "GET",
                    success: function(data) {
                        // $('#notify_comment').html('<span class="text text-success">Thêm bình luận thành công</span>');
                        $('#show-cart').html(data);
                    }
                });
            }

            $('#add-to-cart').click(function() {
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.quantity_cart').val();
                var remain_qty = $('.product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
                // console.log(cart_product_id);
                // alert();
                $.ajax({
                    url: "{{url('/add-cart-ajax')}}",
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
    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

</body>

</html>