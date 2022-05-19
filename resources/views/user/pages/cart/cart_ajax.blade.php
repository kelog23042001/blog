@extends('layout')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Home</a></li>
                <li class="active">Giỏ hàng của bạn</li>
            </ol>
        </div>
        @if(session()->has('message'))

                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
        @elseif (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
        @endif

        <div class="table-responsive cart_info">
        <form action="{{URL::to('/update-cart')}}" method="POST">
        {{ csrf_field() }}
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Hình ảnh</td>
							<td class="description">Tên sản phẩm</td>
							<td class="price">Giá sản phẩm</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Thành tiền</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
                        @if(Session::get('cart')==true)
						@php
								$total = 0;
						@endphp
						@foreach(Session::get('cart') as $key => $cart)
							@php
								$subtotal = $cart['product_price']*$cart['product_qty'];
								$total+=$subtotal;
							@endphp

						<tr>
							<td class="cart_product">
								<img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" width="90" alt="{{$cart['product_name']}}" />
							</td>
							<td class="cart_description">
								<h4><a href=""></a></h4>
								<p>{{$cart['product_name']}}</p>
							</td>
							<td class="cart_price">
								<p>{{number_format($cart['product_price'],0,',','.')}}đ</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">


									<input class="cart_quantity_" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}"  >

								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
									{{number_format($subtotal,0,',','.')}}đ

								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{url('/del-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>

						@endforeach
                        <tr>
                            <td>
                                    <input type="submit" value="Cập nhật" name="update_qty" class="check_out btn-default btn-sm">
                            </td>
                            <td>
                                <a class="btn btn-default check_out" href="{{url('/delete-all-product')}}">Xoá tất cả</a>

                            </td>
                            @if(Session::get('coupon'))
                                <td>
                                <a class="btn btn-default check_out" href="{{url('/unset-coupon')}}">Xoá mã giảm giá</a>

                                </td>
                            @endif
                            <td>
                                <li>Tổng: <span>{{number_format($total,0,',','.')}}đ</span></li>
                                @if(Session::get('coupon'))
                                <li>


                                        @foreach(Session::get('coupon') as $key => $cou)
                                            @if($cou['coupon_condition'] == 1)
                                                Mã giảm :{{$cou['coupon_number']}} %
                                            <p>
                                                @php
                                                    $total_coupon = ($total*$cou['coupon_number']) / 100;
                                                    echo '<p><li>Tổng giảm: '.number_format($total_coupon,0,',','.').'đ</li></p>';
                                                @endphp
                                            </p>
                                            <p><li>Tổng đã giảm: {{number_format($total - $total_coupon,0,',','.')}}</li></p>
                                            @else
                                            Mã giảm :{{number_format($cou['coupon_number'],0,',','.')}}đ
                                            <p>
                                                @php
                                                $total_coupon = $total - $cou['coupon_number'];

                                                @endphp
                                            </p>
                                            <p><li>Tổng đã giảm: {{number_format($total_coupon,0,',','.')}}đ</li></p>
                                            @endif
                                        @endforeach


                                </li>
                                @endif
                                <!-- <li>Thuế: <span></span></li>
                                <li>Phi Vận Chuyển: <span>Free</span></li> -->
                                <!-- <li>Thành Tiền: <span></span></li> -->
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="5">
                            <center>
                            @php
                                echo "Chưa có sản phẩm trong giỏ hàng";
                            @endphp
                            </center>

                            </td>
                        </tr>
                        @endif
					</tbody>

                </form>
                @if(Session::get('cart'))
                <tr>
                    <td>
                        <form method="POST" action="{{URL::to('/check-coupon')}}">
                        {{ csrf_field() }}
                            <input type="text" class="form-control" name="coupon" placeholder="Nhập mã giảm giá"><br>
                            <input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Tính mã giảm giá" href="">
                        </form>
                    </td>
                </tr>
                @endif
                </table>

			</div>

    </div>
</section> <!--/#cart_items-->

<!-- <section id="do_action">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="total_area">
						<ul>

						</ul>
							<a class="btn btn-default update" href="">Update</a>





					</div>
				</div>
			</div>
		</div>
	</section>/#do_action -->
@endsection
