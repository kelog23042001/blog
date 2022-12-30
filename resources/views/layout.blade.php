<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Electro</title>

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
        $(document).ready(function() {
            $('.send_order').click(function() {
                data = {
                    shipping_email: $('.shipping_email').val(),
                    shipping_name: $('.shipping_name').val(),
                    shipping_phone: $('.shipping_phone').val(),
                    shipping_notes: $('.shipping_notes').val(),
                    shipping_address: $('.shipping_address').val(),
                    shipping_method: $('input[name=payment]:checked', '#payment-method').val(),
                    order_fee: $('.order_fee').text(),
                    order_coupon: $('.order_coupon').val(),
                }
                window.localStorage.setItem("data", JSON.stringify(data));

                var paymentMethod = $('input[name=payment]:checked', '#payment-method').val()
                if (paymentMethod == 'paypal') {
                    // alert();
                    window.location.href = "{{route('processTransaction')}}";
                }
                // swal({
                //         title: "Xác nhận đặt hàng?",
                //         text: "Bạn có muốn đặt hàng không?",
                //         type: "warning",
                //         showCancelButton: true,
                //         confirmButtonClass: "btn-danger",
                //         confirmButtonText: "Có",
                //         cancelButtonText: "Không",
                //         closeOnConfirm: true,
                //         closeOnCancel: true,
                //         showLoaderOnConfirm: true
                //     },
                //     function(isConfirm) {
                //         if (isConfirm) {
                //             $.ajax({
                //                 url: "{{url('/confirm-order')}}",
                //                 method: 'POST',
                //                 data: {
                //                     shipping_email: $('.shipping_email').val(),
                //                     shipping_name: $('.shipping_name').val(),
                //                     shipping_phone: $('.shipping_phone').val(),
                //                     shipping_notes: $('.shipping_notes').val(),
                //                     shipping_address: $('.shipping_address').val(),
                //                     shipping_method: $('input[name=payment]:checked', '#payment-method').val(),
                //                     order_fee: $('.order_fee').text(),
                //                     order_coupon: $('.order_coupon').val(),
                //                 },
                //                 success: function() {
                //                     swal("Đặt hàng!", "Đơn đặt hàng của bạn đã đặt thành công", "success");
                //                 }
                //             });
                //         } else {
                //             swal("Đóng", "Đơn hàng chưa được gửi, làm ơn hoàn tất đơn hàng", "error");
                //         }
                //     });
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
                                const fee = new Intl.NumberFormat('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND',
                                });
                                // console.log(response)
                                $('.order_fee').text(fee.format(response))
                                // location.reload();
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
</body>

</html>