<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{$meta_decs}}">
    <meta name="author" content="">
    <meta name="keywords" content="{{$meta_keyword}} "/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <link  rel="canonical" href="{{$url_canonical}}" />
    <link  rel="icon" type="image/x-icon" href="" />
    <title>{{$meta_title}}</title>
    <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/sweetalert.css')}}" rel="stylesheet">

    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		@include('user.elements.header')
	</header><!--/header-->
	<section>
		<div class="container">
			<div class="row">
				@yield('content')
			</div>
		</div>
	</section>

	<footer id="footer"><!--Footer-->
		@include('elements.footer')
	</footer><!--/Footer-->

    <script src="{{asset('frontend/js/jquery.js')}}"></script>
	<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('frontend/js/jquery.scrollUp.min.js')}}"></script>
	<script src="{{asset('frontend/js/price-range.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('frontend/js/main.js')}}"></script>

    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script>
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
    </script>
    
    <script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
    <script>
			$(document).ready(function(){
            $('.add-to-cart').click(function(){
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{url('/add-cart-ajax')}}',
                    method: 'POST',
                    data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,cart_product_image:cart_product_image,
                        cart_product_price:cart_product_price,cart_product_qty:cart_product_qty,_token:_token},
                    success:function(){
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

                    }

                });
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $('.choose').on('change',function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';

            if(action == 'city'){
                result = 'province';
            }else{
                result = 'wards';
            }
            $.ajax({
                url: '{{url('/select-delivery-home')}}',
                method: 'POST',
                data:{action:action, ma_id:ma_id, _token:_token},
                success:function(data){
                    $('#'+result).html(data);
                }
            });
        });
        });
    </script>

    <script>
        $(document).ready(function(){
            $('.calculate_delivery').click(function(){
                var matp = $('.city').val();
                var maqh = $('.province').val();
                var xaid = $('.wards').val();
                var _token = $('input[name="_token"]').val();
                if(matp == '' && maqh == '' && xaid == '')
                    alert('Làm ơn chọn địa điểm');
                else{
                    $.ajax({
                    url: '{{url('/calculate-fee')}}',
                    method: 'POST',
                    data:{matp:matp, maqh:maqh,xaid:xaid, _token:_token},
                    success:function(){
                        location.reload();
                    }
                    });
                }

            });
        });
    </script>

	<script type = "text/javascript">
		$(document).ready(function(){
            $('.send_order').click(function(){
				swal({
						title: "Xác nhận đặt hàng?",
						text: "Bạn có muốn đặt hàng không?",
						type: "warning",
						showCancelButton: true,
						confirmButtonClass: "btn-danger",
						confirmButtonText: "Có",
						cancelButtonText: "Không",
						closeOnConfirm: false,
						closeOnCancel: false
					},
					function(isConfirm) {
					if (isConfirm) {
						// swal("Đặt hàng!", "Đơn đặt hàng của bạn đã đặt thành công", "success");

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
							data:{shipping_email:shipping_email,
								shipping_name:shipping_name,
								shipping_address:shipping_address,
								shipping_phone:shipping_phone,
								shipping_method:shipping_method,
								order_fee:order_fee,
								order_coupon:order_coupon,
								_token:_token},
							success:function(){
								swal("Đặt hàng!", "Đơn đặt hàng của bạn đã đặt thành công", "success");
							}
						});
						window.setTimeout(function(){
							location.reload();
						},3000);
					}
				});
            });
        });
	</script>
</body>
</html>
