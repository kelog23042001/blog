@extends('layout')
@section('content')
<section id="cart_items">
		<div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Home</a></li>
                <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div>

			<div class="review-payment">
				<h2>Xem lại giỏ hàng</h2>
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
        <h4 style="margin: 40px 0; font-size: 20px;">Chọn hình thức thanh toán</h4>
        <form action="{{URL::to('/order-place')}}" method="POST">
                {{ csrf_field() }}
			<div class="payment-options">
					<span>
						<label><input name="payment_option" value="1" type="checkbox">Trả bằng thẻ ATM</label>
					</span>
					<span>
						<label><input name="payment_option" value="2" type="checkbox">Nhận tiền mặt</label>
					</span>
                    <span>
						<label><input name="payment_option" value="3" type="checkbox">Thanh toán thẻ ghi nợ</label>
					</span>

                    <input type="submit" value="Đặt hàng" name="send_order_place" class="btn btn-primary btn-sm">
				</div>
            </form>
		</div>
	</section> <!--/#cart_items-->
@endsection

