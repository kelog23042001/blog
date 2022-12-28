@extends('admin_layout')
@section('admin_contend')
<div class="page-title">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Thư viện ảnh</h3>
            <!-- <p class="text-subtitle text-muted">For user to check they list</p> -->
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <!-- <a href="{{URL::to('/add-category-product')}}" class="btn btn-success">Add Category</a> -->
                <ol class="breadcrumb">
                    <!-- <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li> -->
                    <!-- <li class="breadcrumb-item active" aria-current="page">DataTable</li> -->
                </ol>
            </nav>
        </div>
    </div>
    <?php

    use Illuminate\Support\Facades\Session;

    $message = Session::get('message');
    if ($message) {
        echo $message;
        Session::put('message', null);
    }
    ?>
</div>
<div class="page-heading">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="{{url('/insert-gallery/'.$product_id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3" align="right">
                        </div>
                        <div class="col-md-6">
                            <input type="file" id="file" class="form-control" name="file[]" accept="image/*" multiple>
                            <span id="error_gallery"></span>
                        </div>
                        <div class="col-md-3">
                            <input type="submit" value="Tải ảnh" class="btn btn-success">
                        </div>
                </form>
                <div class="panel-body">
                    <input type="hidden" value="{{$product_id}}" name="product_id" class="product_id">
                    <form>
                        @csrf
                        <div id="gallery_load">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        load_gallery();

        function load_gallery() {
            var product_id = $('.product_id').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{url('/select-gallery')}}",
                method: "POST",
                data: {
                    product_id: product_id,
                    _token: _token,
                },

                success: function(data) {
                    $('#gallery_load').html(data);
                }
            });
        }

        $('#file').change(function() {
            var error = '';
            var files = $('#file')[0].files;
            if (files.length > 7) {
                error += '<p>Chỉ được chọn tối đa 7 ảnh</p>'
            } else if (files.length == '') {
                error += '<p>Không được bỏ trống ảnh</p>'
            } else if (files.size > 2000000) {
                error += '<p>File ảnh không được lớn hơn 2MB</p>'
            }
            if (error == '') {} else {
                $('#file').val('');
                $('#error_gallery').html('<span class="text-danger">' + error + '</span>');
                return false;
            }
        });

        $(document).on('blur', '.edit_gal_name', function() {
            var gal_id = $(this).data('gal_id');
            var gal_text = $(this).text();
            var _token = $('input[name="_token"]').val();

            // alert(gal_id);
            // alert(gal_text);
            // alert(_token);
            $.ajax({
                url: "{{url('/update-gallery-name')}}",
                method: "GET",
                data: {
                    gal_id: gal_id,
                    gal_text: gal_text,
                    _token: _token
                },
                success: function(data) {
                    // $('#gallery_load').html(data);

                    load_gallery();
                    // $('#error_gallery').html('<span class="text-danger">Cập nhập tên hình ảnh thành công</span>');
                    //alert("Cập nhập tên hình ảnh thành công");
                }
            });
        });
        $(document).on('click', '.delete-gallery', function() {
            var gal_id = $(this).data('gal_id');
            // alert(gal_id)
            var _token = $('input[name="_token"]').val();
            // if (confirm('Bạn muốn xoá hình ảnh này không???')) {
            $.ajax({
                url: "{{url('/delete-gallery')}}",
                method: "GET",
                data: {
                    gal_id: gal_id,
                    _token: _token
                },
                success: function(data) {
                    load_gallery();
                }
            });
            // }


        });
        $(document).on('change', '.file_image', function() {
            // alert('Image')
            var gal_id = $(this).data('gal_id');
            var image = document.getElementById('file-' + gal_id).files[0];
            var _token = $('input[name="_token"]').val();

            var form_data = new FormData();

            form_data.append("file", document.getElementById('file-' + gal_id).files[0]);
            form_data.append("gal_id", gal_id);

            $.ajax({
                url: "{{url('/update-gallery')}}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    // $('#gallery_load').html(data);
                    load_gallery();
                    // $('#error_gallery').html('<span class="text-danger">Cập nhập hình ảnh thành công</span>');
                    //alert("Cập nhập tên hình ảnh thành công");
                }
            });



        });
    });
</script>
</div>
@endsection