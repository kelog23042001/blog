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
    <!-- 
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css" /> -->
</head>

<body>
    @include('user.elements.header')
    @yield('content')
    @include('user.elements.snipping_loading')
    @include('user.elements.footer')
    <!-- jQuery Plugins -->
    <script src="{{asset('Frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('Frontend/js/slick.min.js')}}"></script>
    <script src="{{asset('Frontend/js/nouislider.min.js')}}"></script>
    <script src="{{asset('Frontend/js/jquery.zoom.min.js')}}"></script>
    <script src="{{asset('Frontend/js/main.js')}}"></script>
    <script src="{{asset('Frontend/js/sweetalert.min.js')}}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{asset('Backend/vendors/choices.js/choices.min.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


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

        $('#sort').on('change', function() {
            var url = $(this).val();
            // alert(url)
            if (url) {
                window.location = url;
            }
            // return false;
        });

        function delete_compare(id) {
            if (localStorage.getItem('compare') != null) {
                var data = JSON.parse(localStorage.getItem('compare'));
                var index = data.findIndex(item => item.id === id);
                data.splice(index, 1);
                localStorage.setItem('compare', JSON.stringify(data));
                document.getElementById('row_compare' + id).remove();
            }
        }
        sosanh();

        function sosanh() {
            if (localStorage.getItem('compare') != null) {
                var data = JSON.parse(localStorage.getItem('compare'));
                for (i = 0; i < data.length; i++) {
                    var name = data[i].name;
                    var price = data[i].price;
                    var image = data[i].image;
                    var url = data[i].url;
                    var desc = data[i].desc;
                    var id = data[i].id;
                    $('#row_compare').find('tbody').append(
                        '<tr id= "row_compare' + id + '">' +
                        '<td><img height="190px" src = "' + image + '"</td>' +
                        '<td style="width: 150px;" >' + name + '</td>' +
                        '<td style="width: 100px;" >' + price + '</td>' +
                        // '<td></td>'+
                        // '<td></td>'+
                        '<td style="width: 300px;" > <div class ="product_desc">' + desc + '</div></td>' +
                        '<td><a href = "' + url + '"><i class="fa fa-eye text-success text-active"></i></a></td>' +
                        '<td onclick = "delete_compare(' + id + ')">' +
                        '<a style = "cursor: pointer"><i class="fa fa-times text-danger text"></i></a>' +
                        '</td>' +
                        '</tr>'
                    );
                }
            }
        }

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

        function add_wistlist(clicked_id) {
            var id = clicked_id;
            // alert(id);
            var name = document.getElementById('wishlist_productname' + id).value;
            var price = document.getElementById('wishlist_productprice' + id).value;
            var image = $('.cart_product_image_' + id).val();
            var url = $('.cart_product_url_' + id).attr('href');;
            var newItem = {
                'url': url,
                'id': id,
                'name': name,
                'price': price,
                'image': image
            }
            if (localStorage.getItem('data') == null) {
                localStorage.setItem('data', '[]');
            }
            var old_data = JSON.parse(localStorage.getItem('data'));
            var matches = $.grep(old_data, function(obj) {
                return obj.id == id;
            })
            if (matches.length) {
                console.log('Sản phẩm bạn đã yêu thích,nên không thể thêm');
            } else {
                old_data.push(newItem);
                $(".wish-list").append('<div class="product-widget">\
                <div class="product-img">\
                        <img src="' + newItem.image + '" alt="">\
                    </div>\
                    <div class="product-body">\
                        <h3 class="product-name"><a href="' + newItem.url + '">' + newItem.name + '</a></h3>\
                        <h4 class="product-price"><span class="qty">1x</span>' + newItem.price + '</h4>\
                    </div>\
                    <button class="delete"><i class="fa fa-close"></i></button>\
                </div>')
                $(".qty_wishlist").text(old_data.length)
            }
            localStorage.setItem('data', JSON.stringify(old_data));
        }


        function add_compare(product_id) {
            document.getElementById('title-compare').innerText = 'Bảng so sánh sản phẩm';
            var id = product_id;
            var name = document.getElementById('wishlist_productname' + id).value;
            var desc = document.getElementById('wishlist_productdesc' + id).value;
            var price = document.getElementById('wishlist_productprice' + id).value;
            var image = $('.cart_product_image_' + id).val();
            var url = $('.cart_product_url_' + id).attr('href');;
            var newItem = {
                'id': id,
                'desc': desc,
                'name': name,
                'price': price,
                'url': url,
                'image': image
            }
            if (localStorage.getItem('compare') == null) {
                localStorage.setItem('compare', '[]');
            } {
                var old_data = JSON.parse(localStorage.getItem('compare'));
                var matches = $.grep(old_data, function(obj) {
                    return obj.id == id;
                })
                console.log(matches);

                if (matches.length) {} else {
                    if (old_data.length <= 3) {
                        old_data.push(newItem);
                        $('#row_compare').find('tbody').append(
                            '<tr id= "row_compare' + id + '">' +
                            '<td><img height="190px" src = "' + newItem.image + '"></td>' +
                            '<td style="width: 150px;">' + newItem.name + '</td>' +
                            '<td style="width: 100px;">' + newItem.price + '</td>' +
                            '<td style="width: 300px;"><div class ="product_desc">' + newItem.desc + '</div></td>' +
                            '<td>' +
                            '<a href = "' + newItem.url + '">' +
                            '<i class="fa fa-eye text-success text-active"></i>' +
                            '</a>' +
                            '</td>' +
                            '<td onclick = "delete_compare(' + id + ')">' +
                            '<a style = "cursor: pointer">' +
                            '       <i class="fa fa-times text-danger text"></i>' +
                            '</a>' +
                            '</td>' +
                            '</tr>'
                        );
                    }
                }
                localStorage.setItem('compare', JSON.stringify(old_data));
            }

        }

        function formatMoney(x) {
            x = x.toLocaleString('it-IT', {
                style: 'currency',
                currency: 'VND'
            })
            return x;
        }
        <?php

        use Illuminate\Support\Facades\Session;
        ?>

        function Addtocart($product_id) {
            var id = $product_id;
            // alert(id)
            var cart_product_id = $('.cart_product_id_' + id).val();
            var cart_product_name = $('.cart_product_name_' + id).val();
            var cart_product_image = $('.cart_product_image_' + id).val();
            var cart_product_price = $('.cart_product_price_' + id).val();
            var cart_product_qty = $('.quantity_cart').val();
            if (!cart_product_qty)
                cart_product_qty = 1
            var remain_qty = $('.product_qty_' + id).val();
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
                },
                success: function(response) {
                    // show_quick_cart();
                    $('.qty_cart_list').text(response.cartLength)
                    console.log(response.cartLength);
                    swal({
                            title: "Đã thêm sản phẩm vào giỏ hàng",
                            text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành đặt hàng",
                            showCancelButton: true,
                            cancelButtonText: "Xem tiếp",
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "Đi đến giỏ hàng",
                            closeOnConfirm: false
                        },
                        function() {
                            window.location.href = "{{url('/gio-hang')}}";
                        });
                    // show_cart();
                    // hover_cart();
                }
            });
        }
        var spinner = '<div class="lds-dual-ring"></div>';

        $('.order_details').on('change', function() {
            var order_status = $(this).val();
            var order_code = $(this).children(":selected").attr("id");
            // $('#loading').removeAttr('class');
            // alert(order_code)
            $.ajax({
                url: "{{url('/destroy-order')}}",
                method: 'POST',
                data: {
                    order_status: order_status,
                    order_id: order_code,
                },
            }).done(
                document.getElementById("order_details").disabled = true,
                alertify.success("Trạng thái đơn hàng đã được cập nhật!")
            );
        });

        $(document).ready(function() {
            $('.send-comment').click(function() {
                var product_id = $('#product_viewed_id').val();
                var user_id = $('.user_id').val();
                // var comment_name = $('.user_name').val();
                // var comment_email = $('.user_email').val();
                var comment_content = $('.comment_content').val();
                var rating = $('input[name=rating]:checked', '#stars').val();
                // alert(rating)
                $.ajax({
                    url: "{{('/rating')}}",
                    method: "POST",
                    data: {
                        product_id: product_id,
                        user_id: user_id,
                        // comment_name: comment_name,
                        // comment_email: comment_email,
                        comment_content: comment_content,
                        rating: rating,
                    },
                    success: function(data) {
                        // $('#notify_comment').html('<span class="text text-success">Thêm bình luận thành công</span>');
                        // load_comment();
                        swal("Gửi bình luận", "Bình luận đang chờ duyệt! Xin cảm ơn", "success");
                        $('.comment_name').val('');
                        $('.comment_content').val('');
                    }
                });
            })
            $('.tabs_new_products').click(function() {
                var category_id = $(this).data('id');
                // alert(id)
                $.ajax({
                    url: "{{url('/tab-new-product')}}",
                    method: 'POST',
                    data: {
                        'category_id': category_id,
                    },
                    success: function(data) {
                        $('#new-products-tabs').html(data);
                    }
                });
            });
            $('.check_coupon').click(function() {
                getDataOrder();
                // alert('Please select')
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
                window.localStorage.setItem("data-checkout", JSON.stringify(data));
            }

            function sendOrder() {
                data = JSON.parse(window.localStorage.getItem("data-checkout"));
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
                    order_total = $('#order_total').val()
                    alert(order_total);
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
                var id = $(this).data('id');
                // alert('Add to cart')
                // Addtocart(id);
                // var cart_product_id = $('.cart_product_id_' + id).val();
                // var cart_product_name = $('.cart_product_name_' + id).val();
                // var cart_product_image = $('.cart_product_image_' + id).val();
                // var cart_product_price = $('.cart_product_price_' + id).val();
                // var cart_product_qty = $('.quantity_cart').val();
                // var remain_qty = $('.product_qty_' + id).val();
                // console.log(cart_product_qty)
                // var _token = $('input[name="_token"]').val();
                // // console.log(cart_product_id);
                // // alert();
                // $.ajax({
                //     url: "{{url('/add-cart-ajax')}}",
                //     method: 'POST',
                //     data: {
                //         cart_product_id: cart_product_id,
                //         cart_product_name: cart_product_name,
                //         cart_product_image: cart_product_image,
                //         cart_product_price: cart_product_price,
                //         cart_product_qty: cart_product_qty,
                //         remain_qty: remain_qty,
                //         _token: _token
                //     },
                //     success: function() {
                //         swal({
                //                 title: "Đã thêm sản phẩm vào giỏ hàng",
                //                 text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                //                 showCancelButton: true,
                //                 cancelButtonText: "Xem tiếp",
                //                 confirmButtonClass: "btn-success",
                //                 confirmButtonText: "Đi đến giỏ hàng",
                //                 closeOnConfirm: false
                //             },
                //             function() {
                //                 window.location.href = "{{url('/gio-hang')}}";
                //             });
                //         show_cart();
                //         hover_cart();
                //     }
                // });
            });
        });

        function checkQty() {
            var product_quantity = document.getElementById('soluongcon');
            // alert(product_quantity.value)
            ele = document.getElementById('qty_product')
            var quantity = product_quantity.value - ele.value
            if (quantity < 0) {
                ele.value = product_quantity.value;
            }
        }
    </script>
    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

</body>

</html>