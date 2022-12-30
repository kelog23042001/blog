<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/typography.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="main-content">
        <section id="iq-favorites">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 overflow-hidden">
                        <div class="iq-main-header d-flex align-items-center justify-content-between">
                            <h4 class="main-title">Phim mới cập nhật</h4>
                        </div>
                        <div class="tvthrillers-contens">
                            <ul class="favorites-slider list-inline row p-0 mb-0">
                                @foreach($product as $key=>$recommnented)
                                <li class="slide-item">
                                    <div class="block-images position-relative">
                                        <div class="img-box">
                                            <img width="200px" height="250px" src="{{URL::to('public/uploads/product/'.$recommnented->product_image)}}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{asset('frontend/js/slick.min.js')}}"></script>
    <script src="{{asset('frontend/js/slick-animation.min.js')}}"></script>
    <script src="{{asset('frontend/js/custom.js')}}"></script>
</body>

</html>