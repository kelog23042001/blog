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
    <center>
        <table bgcolor="#f6f6f6">
            <tbody>
                <tr>
                    <td width="5px" style="padding: 0;"></td>
                    <td bgcolor="#FFFFFF" style="border: 1px solid #000; clear: both; display: block; margin: 0 auto;  padding: 0;">
                        <center>
                            <table style="border-bottom: 1px solid #eee; border-collapse: collapse; color: #999;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <center>
                                                <a href="http://127.0.0.1:8000/" target="_blank">
                                                    <img src="https://res.cloudinary.com/ddnvoenef/image/upload/v1672832706/logo_kdn5z0.png" alt="LKShop.com" height="100" width="100" style="background: black;" />
                                                </a>
                                            </center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <center>
                                                <p style="font-size: 24px;color: #0f146d">Chào <strong>{{$shipping_array['customer_name']}}</strong>, Cảm ơn bạn đặt hàng tại LKShop</p>
                                            </center>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>

                    </td>
                </tr>

                <tr>
                    <td width="5px" style="padding: 0;"></td>
                    <td style="border: 1px solid #000; border-top: 0; clear: both; display: block; margin: 0 auto;  padding: 0;">
                        <table style="border-collapse: collapse;">
                            <tbody>
                                <tr style="border-bottom: 1px solid #000;">
                                    <td style="padding: 0  20px;">
                                        <h3>Thông tin đơn hàng</h3>
                                        <table cellspacing="0" style="border-collapse: collapse;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 5px 0;">Mã đơn hàng: </td>
                                                    <td align="right" style="padding: 5px 0;">
                                                        <a href="http://127.0.0.1:8000/view-history-order/{{$checkout_code}}">{{$checkout_code}}</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px 0;">Ngày đặt: </td>
                                                    <td align="right" style="padding: 5px 0;">{{$now}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="padding: 0 20px;">
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
                                        </table>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td style="margin-left: 200px; display:block">
                                        <h3>Sản phẩm đã đặt</h3>
                                        <table cellspacing="0" style="border-collapse: collapse;">
                                            <thead style="text-align: center;">
                                                <th>#</th>
                                                <th>Sản phẩm</th>
                                                <th>Giá tiền</th>
                                                <th>Số lượng</th>
                                                <th>Thành tiền</th>
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
                                                    <td><img src="{{$cart['product_image']}}" alt="{{$cart['product_name']}}" height="100" width="100"></td>
                                                    <td style="width:max-content"><span>{{$cart['product_name']}}</span></td>
                                                    <td style="width: 100px">
                                                        <span style="float:right; color: #f27c24"> {{number_format($cart['product_price'],0,',','.')}} VNĐ</span>
                                                    </td>
                                                    <td style="width: 100px; text-align:center">
                                                        {{$cart['product_qty']}}
                                                    </td>
                                                    <td style="width: 100px">
                                                        <span style="float:right">{{number_format($subTotal,0,',','.')}} VNĐ</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td style="float:left">Tổng Cộng :</td>
                                                    <td>
                                                        <span style="float:right">{{number_format($total,0,',','.')}} VNĐ</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td style="float:left">Phí giao hàng :</td>
                                                    <td>
                                                        <span style="float:right">
                                                            {{number_format($shipping_array['shipping_feeShip'],0,',','.')}} VNĐ</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td style="float:left">Giảm giá :</td>
                                                    <td>
                                                        <span style="float:right">
                                                            {{number_format($coupon,0,',','.') }} VNĐ
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td style="float:left; width: max-content;">Tổng tiền đơn hàng: </td>
                                                    <td><span style="float:right; color: #f27c24; font-weight: bold">{{number_format( $total - $coupon +$shipping_array['shipping_feeShip'],0,',','.')}} VNĐ</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="5px" style="padding: 0;"></td>
                </tr>
            </tbody>
        </table>
    </center>

    <script type="text/javascript">

    </script>
</body>

</html>