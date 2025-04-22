<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- title -->
    <title>KRL</title>
  

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="{{ asset('frontend/img/logo.png') }}">

<!-- Frontend CSS -->
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/all-fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/nice-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">


</head>

<body class="home-3">

    <!-- preloader -->
    <div class="preloader">
        <div class="loader-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- preloader end -->


    @include('frontend.includes.header')
    <main class="main">
    @yield('content')
    </main>
    @include('frontend.includes.footer')

 <!-- scroll-top -->
 <a href="#" id="scroll-top"><i class="far fa-arrow-up"></i></a>
    <!-- scroll-top end -->


    <!-- js -->
    <!-- Cloudflare Email Decode Script -->
<script data-cfasync="false" src="{{ asset('frontend/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}"></script>

<!-- Frontend JS Files -->
<script src="{{ asset('frontend/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('frontend/js/modernizr.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.appear.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/js/counter-up.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('frontend/js/wow.min.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>


</body>



</html>