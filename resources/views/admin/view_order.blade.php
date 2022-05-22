@extends('admin_layout')
@section('admin_contend')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
     Thông tin khách hàng
    </div>

    <div class="table-responsive">
                        <?php
                            use Illuminate\Support\Facades\Session;

                            $message = Session::get('message');
                            if($message){
                                echo $message;
                                Session::put('message',null);
                            }
                        ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{$customer->customer_name}}</td>
            <td>{{$customer->customer_phone}}</td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<br>

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
     Thông tin vận chuyển
    </div>

    <div class="table-responsive">
        <?php
            $message = Session::get('message');
            if($message){
                echo $message;
                Session::put('message',null);
            }
        ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Nguời nhận hàng</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Hình thức thành toán</th>
            <th>Ghi Chú</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{$shipping->shipping_name}}</td>
            <td>{{$shipping->shipping_address}}</td>
            <td>{{$shipping->shipping_phone}}</td>
            <td>
              @if($shipping->order_status == 0)
                Trực tuyến
              @else
                Khi nhận hàng
              @endif
            </td>
            <td>{{$shipping->shipping_notes}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<br><br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê chi tiết đơn hàng
    </div>
    <div class="table-responsive">
      <?php
          $message = Session::get('message');
          if($message){
              echo $message;
              Session::put('message',null);
          }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên sản phẩm</th>
            <th>Số lượng trong kho</th>
            <th>Số lượng đặt</th>
            <th>Giá sản phẩm</th>
            <!-- <th>Phí giao hàng</th> -->
            <th>Tổng tiền</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php 
            $i= 0;
            $total = 0;
          @endphp
          @foreach($order_details as $key=>$details)
            @php 
              $i++;
              $subTotal = $details->product_price * $details->product_sale_quantity;
              $total += $subTotal;
            @endphp
          <tr class = "color_qty_{{$details->product->product_id}}")>
            <td><?php $i ?></td>
            <td>{{$details->product_name}}</td>
            <td>{{$details->product->product_quantity}}</td>
            <td>
              <input type="number" {{$order_status == 2 ?'disabled' : ''}} class="order_qty_{{$details->product_id}}" max = "{{$details->product->product_quantity}}"  min = "1" value = "{{$details->product_sale_quantity}}" name = "product_sales_quantity">
              
              <input type="hidden"name="order_qty_storage" class="order_qty_storage_{{$details->product_id}}" value="{{$details->product->product_quantity}}">
              
              <input type="hidden"name="order_code"class="order_code" value="{{$details->order_code}}">

              <input type="hidden"name="order_product_id"class="order_product_id"value="{{$details->product_id}}">
              @if($order_status != 2)
                <button class="btn btn-danger update_quantity_order" data-product_id="{{$details->product_id}}" name = "update_quantity_order">Cập nhật</button>
              @endif
            </td>
            <td>{{number_format($details->product_price,0,',','.')}}VND</td>
            <td>{{number_format($subTotal,0,',','.')}}VND</td>
          </tr>
          @endforeach
          <tr>
            <td></td>
            <td >Tổng tiền</td>
            <td colspan = 3>{{number_format($total,0,',','.')}} VND</td>
          </tr>
          <tr>
            <td></td>
            <td >Giảm giá</td>
            <td colspan = 3>
              <?php $coupon = 0?>
              @if ($coupon_condition == 1) 
                <?php $coupon = $total * $coupon_number/100 ?>
                -{{number_format($coupon,0,',','.')}} VND
                
              @else
                <?php $coupon = $coupon_number ?>
                -{{number_format($coupon,0,',','.')}} VND
              @endif
            </td>
          </tr>
          <tr>
            <td></td>
            <td>Phí giao hàng</td>
            <td colspan = 3>{{number_format($details->product_feeship - $coupon ,0,',','.')}} VND</td>
          </tr>
          <tr>
            <td></td>
            <td>Thành tiền</td>
            <td colspan = 3>{{number_format($total - $coupon + $details->product_feeship ,0,',','.')}} VND</td>
          </tr>
          <tr>
            <td colspan="6">
              @foreach($order as $key => $or)
              @if($or->order_status == 1)
                <form>
                @csrf
                  <select class="form-control order_details">
                    <option id="{{$or->order_id}}" value="1" selected >Chờ xử lý</option>
                    <option id="{{$or->order_id}}" value="2">Đã xử lý-Đã giao hàng</option>
                    <option id="{{$or->order_id}}" value="3">Hủy đơn hàng-tạm giữa</option>
                  </select>
                </form>
              @elseif($or->order_status == 2)
                <form>
                @csrf
                    <select class="form-control order_details">
                      <option id="{{$or->order_id}}" value="1">Chờ xử lý</option>
                      <option id="{{$or->order_id}}" value="2"selected >Đã xử lý-Đã giao hàng</option>
                      <option id="{{$or->order_id}}" value="3">Hủy đơn hàng-tạm giữa</option>
                    </select>
                  </form>
                @else
                  <form>
                    @csrf
                      <select class="form-control order_details">
                        <option id="{{$or->order_id}}" value="1">Chờ xử lý</option>
                        <option id="{{$or->order_id}}" value="2">Đã xử lý-Đã giao hàng</option>
                        <option id="{{$or->order_id}}" value="3" selected >Hủy đơn hàng-tạm giữa</option>
                      </select>
                    </form>
              @endif
              @endforeach
            </td>
          </tr>
        </tbody>
      </table>
      <a href="{{URL::to('/print-order/'.$details->order_code)}}">In đơn hàng</a>
    </div>
  </div>
</div>
@endsection
