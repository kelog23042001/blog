<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!-- <!DOCTYPE html> -->
<!-- <head> -->
<!-- <title>Đăng kí Auth</title> -->
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
<!-- <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, -->
<!-- Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" /> -->
<!-- <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script> -->
<!-- bootstrap-css -->
<!-- <link rel="stylesheet" href="{{asset('/backend/css/bootstrap.min.css')}}" > -->
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<!-- <link href="{{asset('/backend/css/style.css')}}" rel='stylesheet' type='text/css' /> -->
<!-- <link href="{{asset('/backend/css/style-responsive.css')}}" rel="stylesheet"/> -->
<!-- font CSS -->
<!-- <link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'> -->
<!-- font-awesome icons -->
<!-- <link rel="stylesheet" href="{{asset('/backend/css/font.css')}}" type="text/css"/> -->
<!-- <link href="{{asset('/backend/css/font-awesome.css')}}" rel="stylesheet"> -->
<!-- //font-awesome icons -->
<!-- <script src="{{asset('/backend/js/jquery2.0.3.min.js/')}}"></script> -->
<!-- </head> -->
<!-- <body> -->
<!-- <div class="log-w3"> -->
<!-- <div class="w3layouts-main"> -->
	<!-- <h2>Đăng nhập Auth</h2> -->
    <?php

        use Illuminate\Support\Facades\Session;

                $message = Session::get('message');
                if($message){
                    echo $message;
                    Session::put('message',null);
                }
    ?>
		<!-- <form action="{{URL::to('/login')}}" method="post"> -->
            <!-- {{ csrf_field() }} -->

			<!-- <input type="email" class="ggg" name="admin_email" value="{{old('admin_email')}}" placeholder="Điền Email" required=""> -->

			<!-- <input type="password" class="ggg" name="admin_password" value="{{old('admin_password')}}" placeholder="Điền password" required=""> -->
			<!-- <span><input type="checkbox" />Remember Me</span> -->
			<!-- <h6><a href="#">Forgot Password?</a></h6> -->
				<!-- <div class="clearfix"></div> -->
				<!-- <input type="submit" value="Đăng nhập" name="login"> -->
		<!-- </form> -->
        <!-- <a href="{{url('/register-auth')}}">Đăng ký Authentication</a> | -->
        <!-- <a href="{{url('/login-auth')}}">Đăng nhập Authentication</a> | -->

		<!-- <p>Don't Have an Account ?<a href="registration.html">Create an account</a></p> -->
<!-- </div> -->
<!-- </div> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mazer Admin Dashboard</title>
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
      
    <link rel="stylesheet" href="{{asset('/Backend/css/app.css')}}">
    

</head>

<body>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img style="width:100px; height:35px;" src="http://127.0.0.1:8000/Backend/images/logo/logo.png" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class=" mb-5">Log in with your data that you entered during registration.</p>

                    <form action="{{URL::to('/login')}}" method="post">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="email" id="email" class="form-control form-control-xl" placeholder="Username">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input name="password" id="password" type="password" class="form-control form-control-xl" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Keep me logged in
                            </label>
                        </div>
                        
                        <!-- <a href="{{url('/login-customer-google')}}"><i class="bi bi-google"></i>Google </a> -->

                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                        <a class="btn btn-lg btn-google btn-block  btn-outline" href="{{url('/login-customer-google')}}"><img src="https://img.icons8.com/color/16/000000/google-logo.png"> Signup Using Google</a>

                    </form>

                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Don't have an account? <a href="{{url('/register')}}"
                                class="font-bold">Sign
                                up</a>.</p>
                        <p><a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>
        @if(session('message'))
    {{session('message')}}
@endif
    </div>
</body>

</html>
<script src="{{asset('/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('/backend/js/scripts.js')}}"></script>
<script src="{{asset('/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('/backend/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{asset('/backend/js/jquery.scrollTo.js')}}"></script>
</body>
<style>

</style>
</html>

