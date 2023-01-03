<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/Backend/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('/Backend/vendors/iconly/bold.css')}}">
    <link rel="stylesheet" href="{{asset('/Backend/vendors/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('/Backend/vendors/bootstrap-icons/bootstrap-icons.css')}}">
    <link rel="stylesheet" href="{{asset('/Backend/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('/Backend/vendors/simple-datatables/style.css')}}">
    <link rel="stylesheet" href="{{asset('/Backend/vendors/toastify/toastify.css')}}">
    <link rel="stylesheet" href="{{asset('/Backend/vendors/choices.js/choices.min.css')}}">
    <link rel="shortcut icon" href="{{asset('/Backend/images/favicon.svg')}}" type="image/x-icon">
</head>

<body>

    <div id="app">
        <div id="sidebar" class="active">
            @include('admin/elements/navbar')
        </div>
        <div id="main">
            <div class="page-content">
                @yield('admin_contend')
            </div>
            <footer>
                @include('admin/elements/footer')
            </footer>
        </div>
    </div>


    <script src="{{asset('Backend/vendors/choices.js/choices.min.js')}}"></script>

    <script src="{{asset('Backend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('Backend/js/main.js')}}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="{{asset('Backend/vendors/simple-datatables/simple-datatables.js')}}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
        const table_category = document.querySelector('#table-category');
        const data_category = new simpleDatatables.DataTable(table_category);
    </script>


    <!-- script -->
    <script src="{{asset('backup/backend/js/bootstrap.js')}}"></script>
    <script src="{{asset('/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
    <script src="{{asset('/backend/js/scripts.js')}}"></script>
    <script src="{{asset('/backend/js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('/backend/js/jquery.nicescroll.js')}}"></script>
    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
    <script src="{{asset('/backend/js/jquery.scrollTo.js')}}"></script>
    <script src="{{asset('/backend/ckeditor/ckeditor.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="//cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <script src="//code.jquery.com/jquery-3.2.1.slim.min.js"></script>

    <!-- //calendar -->
    <!-- //font-awesome icons -->
    <script src="//cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('/backend/js/bootstrap-tagsinput.js')}}"></script>
    <!-- //calendar -->
    <!-- //font-awesome icons -->
    <script src="{{asset('/backend/js/jquery2.0.3.min.js')}}"></script>

    <script src="{{asset('/backend/js/raphael-min.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>



    <script>
        $(document).ready(function() {
            fetch_delivery();

            function fetch_delivery() {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{url('/select-feeship')}}',
                    method: 'POST',
                    data: {
                        _token: _token
                    },
                    success: function(data) {
                        $('#load_delivery').html(data);
                    }
                });
            }

            $(document).on('blur', '.fee_feeship_edit', function() {
                var feeship_id = $(this).data('feeship_id');
                var fee_value = $(this).text();
                var _token = $('input[name="_token"]').val();

                // alert(fee_value);
                // alert(feeship_id);
                $.ajax({
                    url: '{{url('/update-delivery')}}',
                    method: 'POST',
                    data: {
                        feeship_id: feeship_id,
                        fee_value: fee_value,
                        _token: _token
                    },
                    success: function(data) {
                        fetch_delivery();
                    }
                });
            });

            $('.add_delivery').click(function() {
                var city = $('.city').val();
                var province = $('.province').val();
                var wards = $('.wards').val();
                var fee_ship = $('.fee_ship').val();
                var _token = $('input[name="_token"]').val();

                //alert(city);
                //alert(province);
                // alert(wards);
                // alert(fee_ship);
                $.ajax({
                    url: '{{url('/insert-delivery')}}',
                    method: 'POST',
                    data: {
                        city: city,
                        province: province,
                        wards: wards,
                        fee_ship: fee_ship,
                        _token: _token
                    },
                    success: function(data) {
                        fetch_delivery();
                    }
                });
            });
            $('.choose').on('change', function() {
                var action = $(this).attr('id');
                var ma_id = $(this).val();
                var _token = $('input[name="_token"]').val();
                var result = '';
                // alert(action);
                // alert(ma_id);
                // alert(_token);
                if (action == 'city') {
                    result = 'province';
                } else {
                    result = 'wards';
                }
                $.ajax({
                    url: '{{url('/select-delivery')}}',
                    method: 'POST',
                    data: {
                        action: action,
                        ma_id: ma_id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#' + result).html(data);
                    }
                });
            });
        })
    </script>
    <script type="text/javascript">
        $.validate({

        });
    </script>
    <script>
        CKEDITOR.replace('ckeditor');
        CKEDITOR.replace('ckeditor1');
    </script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <script>
        $(function() {
            $("#datepicker1").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "yy-mm-dd",
                dayNamesMin: ["Thứ2", "Thứ3", "Thứ4", "Thứ5", "Thứ6", "Thứ7", "Chủ nhật"],
                duration: "slow"
            });
            $("#datepicker2").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "yy-mm-dd",
                dayNamesMin: ["Thứ2", "Thứ3", "Thứ4", "Thứ5", "Thứ6", "Thứ7", "Chủ nhật"],
                duration: "slow"
            });

            $("#datepicker3").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "dd-mm-yy",
                dayNamesMin: ["Thứ2", "Thứ3", "Thứ4", "Thứ5", "Thứ6", "Thứ7", "Chủ nhật"],
                duration: "slow"
            });
            $("#datepicker4").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "dd-mm-yy",
                dayNamesMin: ["Thứ2", "Thứ3", "Thứ4", "Thứ5", "Thứ6", "Thứ7", "Chủ nhật"],
                duration: "slow"
            });
        });
    </script>
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            chart30daysorder();

            var chart = new Morris.Bar({
                element: 'chart',
                lineColors: ['#819C79', '#fc8710', '#FF6541', '#A4ADD3', '#766856'],
                pointFillColors: ['#ffffff'],
                pointStrokeColors: ['black'],
                fillopacity: 0.6,
                hideHover: 'auto',
                parseTime: false,
                xkey: 'period',
                ykeys: ['order', 'sales', 'profit', 'quantity'],
                behaveLikeLine: true,
                labels: ['đơn hàng', 'doanh số', 'lợi nhuận', 'số lượng']
            });

            function chart30daysorder() {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('/day-order')}}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        _token: _token
                    },
                    success: function(data) {
                        chart.setData(data);
                    }
                });
            }
            $('.dashboard-filter').change(function() {
                var dashboard_value = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('/dashboard-filter')}}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        dashboard_value: dashboard_value,
                        _token: _token
                    },
                    success: function(data) {
                        chart.setData(data);
                    }
                });
            });

            var colorDanger = "#FF1744";
            Morris.Donut({
                element: 'donut',
                resize: true,
                colors: [
                    '#E0F7FA',
                    '#B2EBF2',
                    '#80DEEA',
                    '#4DD0E1',
                ],
                data: [{
                        label: "Sản phẩm",
                        value: <?php echo $product_count ?>
                    },
                    {
                        label: "Blog",
                        value: <?php echo $post_count ?>
                    },
                    {
                        label: "Đơn hàng",
                        value: <?php echo $order_count ?>
                    },
                    {
                        label: "Thành viên",
                        value: <?php echo $customer_count ?>
                    },
                ]
            });


            function chart30daysorder() {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('/day-order')}}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        _token: _token
                    },
                    success: function(data) {
                        chart.setData(data);
                    }
                });
            }

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btn-dashboard-filter').click(function() {
                var _token = $('input[name="_token"]').val();
                var from_date = $('#datepicker1').val();
                var to_date = $('#datepicker2').val();
                $.ajax({
                    url: "{{url('/filter-by-date')}}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        _token: _token
                    },
                    success: function(data) {
                        chart.setData(data);
                    }
                });
            });

        });
    </script>
    <script type="text/javascript">
        $('.comment_duyet_btn').click(function() {
            var comment_status = $(this).data('comment_status');
            var comment_id = $(this).data('comment_id');
            var comment_product_id = $(this).attr('id');
            $.ajax({
                url: "{{url('/allow-comment')}}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    comment_status: comment_status,
                    comment_id: comment_id,
                    comment_product_id: comment_product_id
                },
                success: function(data) {
                    if (comment_status == 0) {
                        alert('Duyệt thành công');
                    } else {
                        alert('Bỏ duyệt thành công');
                    }
                    location.reload();
                }
            });
        });
        $('.btn-reply-comment').click(function() {
            var comment_id = $(this).data('comment_id');
            var comment = $('.reply_comment_' + comment_id).val();
            var comment_product_id = $(this).data('product_id');
            // alert(comment)
            $.ajax({
                url: "{{url('/reply-comment')}}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    comment: comment,
                    comment_id: comment_id,
                    comment_product_id: comment_product_id
                },
                success: function(data) {
                    alert('Trả lời bình luận thành công!');
                    $('.reply_comment_' + comment_id).val('');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            //BOX BUTTON SHOW AND CLOSE
            jQuery('.small-graph-box').hover(function() {
                jQuery(this).find('.box-button').fadeIn('fast');
            }, function() {
                jQuery(this).find('.box-button').fadeOut('fast');
            });
            jQuery('.small-graph-box .box-close').click(function() {
                jQuery(this).closest('.small-graph-box').fadeOut(200);
                return false;
            });

            //CHARTS
            function gd(year, day, month) {
                return new Date(year, month - 1, day).getTime();
            }
            graphArea2 = Morris.Area({
                element: 'hero-area',
                padding: 10,
                behaveLikeLine: true,
                gridEnabled: false,
                gridLineColor: '#dddddd',
                axes: true,
                resize: true,
                smooth: true,
                pointSize: 0,
                lineWidth: 0,
                fillOpacity: 0.85,
                data: [{
                        period: '2015 Q1',
                        iphone: 2668,
                        ipad: null,
                        itouch: 2649
                    },
                    {
                        period: '2015 Q2',
                        iphone: 15780,
                        ipad: 13799,
                        itouch: 12051
                    },
                    {
                        period: '2015 Q3',
                        iphone: 12920,
                        ipad: 10975,
                        itouch: 9910
                    },
                    {
                        period: '2015 Q4',
                        iphone: 8770,
                        ipad: 6600,
                        itouch: 6695
                    },
                    {
                        period: '2016 Q1',
                        iphone: 10820,
                        ipad: 10924,
                        itouch: 12300
                    },
                    {
                        period: '2016 Q2',
                        iphone: 9680,
                        ipad: 9010,
                        itouch: 7891
                    },
                    {
                        period: '2016 Q3',
                        iphone: 4830,
                        ipad: 3805,
                        itouch: 1598
                    },
                    {
                        period: '2016 Q4',
                        iphone: 15083,
                        ipad: 8977,
                        itouch: 5185
                    },
                    {
                        period: '2017 Q1',
                        iphone: 10697,
                        ipad: 4470,
                        itouch: 2038
                    },

                ],
                lineColors: ['#eb6f6f', '#926383', '#eb6f6f'],
                xkey: 'period',
                redraw: true,
                ykeys: ['iphone', 'ipad', 'itouch'],
                labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
                pointSize: 2,
                hideHover: 'auto',
                resize: true
            });
        });
    </script>
    <!-- calendar -->
    <script type="text/javascript" src="{{asset('/backend/js/monthly.js')}}"></script>
    <script type="text/javascript">
        $(window).load(function() {
            $('#mycalendar').monthly({
                mode: 'event',
            });
            $('#mycalendar2').monthly({
                mode: 'picker',
                target: '#mytarget',
                setWidth: '250px',
                startHidden: true,
                showTrigger: '#mytarget',
                stylePast: true,
                disablePast: true
            });

            switch (window.location.protocol) {
                case 'http:':
                case 'https:':
                    // running on a server, should be good.
                    break;
                case 'file:':
                    alert('Just a heads-up, events will not work when run locally.');
            }

        });
    </script>
    <!-- //calendar -->

    <!-- cập nhật số lượng đặt hàng -->
    <script type="text/javascript">
        $('.update_quantity_order').click(function() {
            var order_product_id = $(this).data('product_id');
            var order_qty = $('.order_qty_' + order_product_id).val();
            var order_code = $('.order_code').val();
            var _token = $('input[name="_token"]').val();
            var order_qty_storage = $('.order_qty_storage_' + order_product_id).val();
            if (order_qty_storage - order_qty < 0) {
                alert("Số lượng trong kho không đủ");
            } else {
                $.ajax({
                    url: '{{url(' / update - qty ')}}',
                    method: 'POST',
                    data: {
                        _token: _token,
                        order_product_id: order_product_id,
                        order_qty: order_qty,
                        order_code: order_code
                    },
                    success: function(data) {
                        alert('Cập nhật số lượng đặt hàng thành công');
                        location.reload();
                    }
                });
            }
            // alert(order_product_id);
            // alert(order_qty);
            // alert(order_code);
        });
    </script>

    <script type="text/javascript">
        $('.order_details').on('change', function() {
            var order_status = $(this).val();
            var order_id = $(this).children(":selected").attr("id")
            var _token = $('input[name="_token"]').val();
            quantity = [];
            $("input[name='product_sales_quantity']").each(function() {
                quantity.push($(this).val());
            });
            // lay ra product id
            order_product_id = [];
            $("input[name='order_product_id']").each(function() {
                order_product_id.push($(this).val());
            });

            j = 0;
            for (i = 0; i < order_product_id.length; i++) {
                var order_qty = $('.order_qty_' + order_product_id[i]).val();
                var order_qty_storage = $('.order_qty_storage_' + order_product_id[i]).val();

                if (parseInt(order_qty) > parseInt(order_qty_storage)) {
                    j++;
                    if (j == 1) {
                        alert('Số lượng trong kho không đủ');
                    }
                    $('.color_qty_' + order_product_id[i]).css('background', '#000');
                }
            }

            if (j == 0) {
                alert('Cập nhật trạng thái đơn hàng thành công');
                location.reload();
                $.ajax({
                    url: '{{url(' / update - order - quantity ')}}",
                    method: 'POST',
                    data: {
                        _token: _token,
                        order_status: order_status,
                        order_id: order_id,
                        quantity: quantity,
                        order_product_id: order_product_id
                    },
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script type="text/javascript">
        function ChangeToSlug() {
            var slug;
            //Lấy text từ thẻ input title
            slug = document.getElementById("slug").value;
            slug = slug.toLowerCase();
            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            document.getElementById('convert_slug').value = slug;
        }
    </script>
    <script>
        function checkQty_order() {
            var order_product_id = document.getElementById('order_product_id').getAttribute('value');
            // var product_quantity = document.getElementById('order_qty_storage_' + order_product_id).getAttribute('value');
            alert(order_product_id);
            // alert(order_product_id);
            // ele = document.getElementById('order_qty')
            // alert( );
            // var quantity = product_quantity.value - ele.value
            // if(quantity < 0){
            //     ele.value = product_quantity.value;
            // }
        }
    </script>
</body>

</html>