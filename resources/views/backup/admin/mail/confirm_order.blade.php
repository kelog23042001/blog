<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div>
        <table class="container" bgcolor="#f6f6f6" cellspacing="0" style="border-collapse: collapse; padding: 40px; width: 100%;" width="100%">
            <tbody>
                <tr>
                    <td width="5px" style="padding: 0;"></td>
                    <td style="clear: both; display: block; margin: 0 auto;  padding: 10px 0;">
                        <table width="100%" cellspacing="0" style="border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td style="padding: 0;">
                                        <a href="#" style="color: #348eda;" target="_blank">
                                            <img src="//ssl.gstatic.com/accounts/ui/logo_2x.png" alt="LKShop.com" style="height: 50px; max-width: 100%; width: 157px;" height="50" width="157" />
                                        </a>
                                    </td>
                                    <td style="color: #999; font-size: 12px; padding: 0; text-align: right;" align="right">
                                        Đà Nẵng<br />
                                        <?php

                                        use Carbon\Carbon;

                                        echo $now = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i:s d-m-Y ');
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="5px" style="padding: 0;"></td>
                </tr>

                <tr>
                    <td width="5px" style="padding: 0;"></td>
                    <td bgcolor="#FFFFFF" style="border: 1px solid #000; clear: both; display: block; margin: 0 auto;  padding: 0;">
                        <table width="100%" style="background: #f9f9f9; border-bottom: 1px solid #eee; border-collapse: collapse; color: #999;">
                            <tbody>
                                <tr>
                                    <td style="padding: 20px;"><strong style="color: #333; font-size: 24px;">LKShop</strong></td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px;">Chào {{$shipping_array['customer_name']}}, Cảm ơn bạn đã mua hàng tại shop <span class="il"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td width="5px" style="padding: 0;"></td>
                    <td style="border: 1px solid #000; border-top: 0; clear: both; display: block; margin: 0 auto;  padding: 0;">
                        <table cellspacing="0" style="border-collapse: collapse; border-left: 1px solid #000; margin: 0 auto; ">
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding: 0  20px;">
                                        <h3>
                                            Thông tin đơn hàng
                                        </h3>
                                        <table cellspacing="0" style="border-collapse: collapse;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 5px 0;">Mã đơn hàng: </td>
                                                    <td align="right" style="padding: 5px 0;">{{$code['order_code']}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px 0;">Ngày đặt: </td>
                                                    <td align="right" style="padding: 5px 0;">{{$now}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="border-bottom: 2px solid #000; width: 100%; padding: 5px 0;"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding:0  20px;">
                                        <h3>
                                            Sản phẩm đã đặt
                                        </h3>
                                        <table cellspacing="0" style="border-collapse: collapse; text-align: center;">
                                            <thead>
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>&nbsp;</th>
                                                    <th>Giá tiền</th>
                                                    <th>&nbsp;</th>
                                                    <th>Số lượng</th>
                                                    <th>&nbsp;</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $subTotal = 0;
                                                $total = 0;
                                                @endphp
                                                @foreach($cart_array as $cart)
                                                @php
                                                $subTotal = $cart['product_qty'] * $cart['product_price'];
                                                $total += $subTotal;
                                                @endphp
                                                <tr>
                                                    <td style="margin-right: 10px;">{{$cart['product_name']}}</td>
                                                    <td></td>
                                                    <td style="padding: 5px 0;">{{number_format($cart['product_price'],0,',','.')}} VND</td>
                                                    <td></td>
                                                    <td style="padding: 5px 0;">{{$cart['product_qty']}}</td>
                                                    <td></td>
                                                    <td style="padding: 5px 0; ">{{number_format($subTotal,0,',','.')}} VND</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td>Tổng Cộng :</td>
                                                    <td></td>
                                                    <td>{{number_format($total,0,',','.')}} VND</td>
                                                </tr>

                                                @if($code['coupon_code'])
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <!-- <td></td>
                                                    <td></td>
                                                    <td></td> -->
                                                    <td>Giảm giá :</td>
                                                    <td></td>
                                                    @if($code['coupon_condition'] == 1)
                                                    @php
                                                    $total_coupon = ($total*$code['coupon_number']) / 100;
                                                    @endphp
                                                    @else
                                                    @php
                                                    $total_coupon = $code['coupon_number'];
                                                    @endphp
                                                    @endif
                                                    <td>{{number_format($total_coupon,0,',','.')}} VND</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <!-- <td></td>
                                                    <td></td>
                                                    <td></td> -->
                                                    <td>Phí giao hàng :</td>
                                                    <td></td>
                                                    <td>{{number_format($shipping_array['feeShip'],0,',','.')}} VND</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <!-- <td></td>
                                                    <td></td>
                                                    <td></td> -->
                                                    <td>Tổng Cộng</td>
                                                    <td></td>
                                                    <td>{{number_format($total - $total_coupon +$shipping_array['feeShip'] ,0,',','.')}} VND</td>
                                                </tr>

                                                <tr>
                                                    <td  colspan="7" style="border-bottom: 2px solid #000; width: 100%; padding: 5px 0;"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>


                                <tr>
                                    <td valign="top" style="padding: 0 20px;">
                                        <h3>
                                            Thông tin người nhận
                                        </h3>
                                        <table cellspacing="0" style="border-collapse: collapse; ">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 5px 0;">Tên khách hàng: </td>
                                                    <td align="right" style="padding: 5px 0;">{{$shipping_array['shipping_name']}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px 0;">Số điện thoại</td>
                                                    <td align="right" style="padding: 5px 0;">{{$shipping_array['shipping_phone']}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px 0;">Địa chỉ: </td>
                                                    <td align="right" style="padding: 5px 0;">{{$shipping_array['shipping_address']}}, Cẩm Lệ, Đà Nẵng</td>
                                                </tr>

                                            </tbody>

                                            <tr>
                                                <td colspan="2" style="border-bottom: 2px solid #000; width: 100%"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="5px" style="padding: 0;"></td>
                </tr>

                <tr style="color: #666; font-size: 12px;">
                    <td width="5px"></td>
                    <td style="clear: both; display: block; margin: 0 auto;  padding: 10px 0;">
                        <table width="100%" cellspacing="0" style="border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td width="40%" valign="top">
                                        <h4 style="margin: 0;"></h4>
                                        <p style="color: #666; font-size: 12px; font-weight: normal;">
                                            Xem lại lịch sử mua hàng 
                                            <a style="color: red;" target="_blank" href="{{URL::to('/history-order')}}">
                                                Tại đây
                                            </a>
                                            .
                                        </p>
                                    </td>
                                    <td width="10%">&nbsp;</td>
                                    <td width="40%" valign="top">
                                        <!-- <h4 style="margin: 0;"><span class="il">Bootdey</span> Technologies</h4>
                                        <p style="color: #666; font-size: 12px; font-weight: normal;">
                                            <a href="#">535 Mission St., 14th Floor San Francisco, CA 94105</a>
                                        </p> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="5px" style="padding: 10px 0;"></td>
                </tr>
            </tbody>
        </table>
    </div>


    <style type="text/css">
        body {
            margin-top: 20px;
        }

        h3 {
            border-bottom: 1px solid #000;
            color: #000;
            font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
            font-size: 20px;
            font-weight: bold;
            line-height: 1.2;
            margin: 0;
            margin-bottom: 15px;
            padding-bottom: 5px;
            text-align: center;
        }
    </style>

    <script type="text/javascript">

    </script>
</body>

</html>