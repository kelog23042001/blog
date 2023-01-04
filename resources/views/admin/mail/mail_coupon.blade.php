<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div bgcolor="#f6f6f6" style="color: #333; height: 100%; width: 100%;" height="100%" width="100%">
        <table bgcolor="#f6f6f6" cellspacing="0" style="border-collapse: collapse; padding: 40px; width: 100%;" width="100%">
            <tbody>
                <tr>
                    <td width="5px" style="padding: 0;"></td>
                    <td style="clear: both; display: block; margin: 0 auto; max-width: 600px; padding: 10px 0;">
                        <table width="100%" cellspacing="0" style="border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td style="padding: 0;">
                                        <a href="http://127.0.0.1:8000/" style="color: #348eda;" target="_blank">
                                            <img src="https://res.cloudinary.com/ddnvoenef/image/upload/v1672815961/lk2_wcnpsu.jpg" alt="Bootdey.com" height="100px" width="100px" />
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="5px" style="padding: 0;"></td>
                </tr>
                <tr>
                    <td width="5px" style="padding: 0;"></td>
                    <td bgcolor="#FFFFFF" style="border: 1px solid #000; clear: both; display: block; margin: 0 auto; max-width: 600px; padding: 0;">
                        <table width="100%" style="background: #f9f9f9; border-bottom: 1px solid #eee; border-collapse: collapse; color: #999;">
                            <tbody>
                                <tr>
                                    <!-- <td width="50%" style="padding: 20px;"><strong style="color: #333; font-size: 24px;">$23.95</strong> Paid</td> -->
                                    <td align="right" width="50%" style="padding: 20px;">Cảm ơn khách hàng đã mua hàng tại shop <span class="il">LKShop.com</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="padding: 0;"></td>
                    <td width="5px" style="padding: 0;"></td>
                </tr>
                <tr>
                    <td width="5px" style="padding: 0;"></td>
                    <td style="border: 1px solid #000; border-top: 0; clear: both; display: block; margin: 0 auto; max-width: 600px; padding: 0;">
                        <table cellspacing="0" style="border-collapse: collapse; border-left: 1px solid #000; margin: 0 auto; max-width: 600px;">
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding: 20px;">
                                        <h3 style="
                                            border-bottom: 1px solid #000;
                                            color: #000;
                                            font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
                                            font-size: 18px;
                                            font-weight: bold;
                                            line-height: 1.2;
                                            margin: 0;
                                            margin-bottom: 15px;
                                            padding-bottom: 5px;
                                        ">
                                            Chương trình {{$coupon['coupon_name']}}
                                        </h3>
                                        <table cellspacing="0" style="border-collapse: collapse; margin-bottom: 40px;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 5px 0;">Mã giảm giá: </td>
                                                    <td align="right" style="padding: 5px 0; font-weight: bold;">{{$coupon['coupon_code']}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px 0;">Giảm : </td>
                                                    <td align="right" style="padding: 5px 0; font-weight: bold;">

                                                        @if($coupon['coupon_condition']=='1')
                                                        {{$coupon['coupon_number']}}%
                                                        @else

                                                        {{number_format($coupon['coupon_number'],0,',','.')}}VNĐ
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px 0;">Thời gian: </td>
                                                    <td align="right" style="padding: 5px 0; font-weight: bold;">Từ {{$coupon['start_coupon']}} đến {{$coupon['end_coupon']}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px 0;">Số lượng : </td>
                                                    <td align="right" style="padding: 5px 0; font-weight: bold;">{{$coupon['coupon_time']}}</td>
                                                </tr>
                                                <!-- <tr>
                                                    <td style="border-bottom: 2px solid #000; border-top: 2px solid #000; font-weight: bold; padding: 5px 0;">Amount paid</td>
                                                    <td align="right" style="border-bottom: 2px solid #000; border-top: 2px solid #000; font-weight: bold; padding: 5px 0;">$23.95</td>
                                                </tr> -->
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="5px" style="padding: 0;"></td>
                </tr>

                <tr style="color: #666; font-size: 12px;">
                    <td width="5px" style="padding: 10px 0;"></td>
                    <td style="clear: both; display: block; margin: 0 auto; max-width: 600px; padding: 10px 0;">
                        <table width="100%" cellspacing="0" style="border-collapse: collapse;">
                            <tbody>
                                <td width="10%" style="padding: 10px 0;">&nbsp;</td>
                                <td width="40%" valign="top" style="padding: 10px 0;">
                                    <h4 style="margin: 0;"><span class="il">Mua ngay: </span> <a href="http://127.0.0.1:8000/">LKShop.com</a>
                                    </h4>
                                </td>
                            </tbody>
                        </table>
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
    </style>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>