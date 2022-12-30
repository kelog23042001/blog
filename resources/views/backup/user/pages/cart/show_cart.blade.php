@extends('layout')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <?php
                $content = Cart::content();
            ?>
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình Ảnh</td>
                        <td class="description">Tên Sản Phẩm</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số Lượng</td>
                        <td class="total">Thành Tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($content as $v_content)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{URL::to('public/uploads/product/'.$v_content->options->image)}}" width = "80px" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$v_content->name}}</a></h4>
                            <p>Web ID: {{$v_content->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($v_content->price).' '.'VND'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{URL::to('/update-cart-qty')}}" method="POST">
                                    {{csrf_field()}}
                                    <input class="cart_quantity_input" type="number" name="quantity_cart" value="{{$v_content->qty}}">
                                    <input class="" type="submit" name="update_qty" value="Cập Nhật">
                                    <input class="" type="hidden" name="rowId_cart" value="{{$v_content->rowId}}">
                                </form>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">{{(Cart::subtotal(0)).' '.'VND'}}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/detele-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li>Tổng <span>{{(Cart::total(0)).' '.'VND'}}</span></li>
							<li>Thuế <span>{{(Cart::tax(0)).' '.'VND'}}</span></li>
							<li>Phi Vận Chuyển <span>Free</span></li>
							<li>Thành Tiền <span>{{(Cart::total(0)).' '.'VND'}}</span></li>
						</ul>
							<!-- <a class="btn btn-default update" href="">Update</a> -->
                            <?php

                                use Illuminate\Support\Facades\Session;

                                $customer_id = Session::get('customer_id');
                                if($customer_id != NULL){

                                ?>

                                    <a class="btn btn-default check_out" href="{{URL::to('/checkout')}}">Thanh toán</a>
                                <?php
                                }else{
                                ?>

                                    <a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}">Thanh toán</a>
                                <?php
                                }
                            ?>


					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->
@endsection
