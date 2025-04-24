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

    <!-- Dashboard-specific CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all-fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    <style>
        .navbar-nav .nav-link {
            color: #333;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        .navbar-nav .badge {
            font-size: 10px;
            padding: 2px 5px;
        }

        .dropdown-menu {
            font-size: 0.9rem;
            border-radius: 8px;
        }

        .theme-btn:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .theme-btn {
            background-color: #c72336;
            color: #fff;
            border: none;
            transition: background-color 0.3s ease;
            font-weight: 600 !important;
            border-radius: 10px !important;
            margin-left: 20px;
        }

        .navbar-nav .badge {
            font-size: 12px;
            padding: 2px 5px;
            margin-top: 23px;
        }

        /* Primary and Secondary Colors */
        .text-secondary-custom {
            color: #003F72 !important;
        }

        .custom-badge {
            background-color: #c72336;
            color: #fff;
            font-size: 0.7rem;
            padding: 4px 6px;
            border-radius: 10px;
        }

        .custom-dropdown {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .dropdown-item:hover {
            background-color: #003F72;
            color: #fff;
        }

        .dropdown-item i {
            min-width: 16px;
        }

        .view-all-link {
            color: #c72336;
            font-weight: 500;
        }

        .view-all-link:hover {
            color: #fff;
            background-color: #c72336;
        }

        .theme-btn {
            background-color: #003F72;
            color: #fff;
            transition: background 0.3s ease;
        }

        .theme-btn:hover {
            background-color: none !important;
            color: #fff;
        }

        .profile-dropdown {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .profile-dropdown .dropdown-item {
            font-size: 0.9rem;
            padding: 8px 12px;
            border-radius: 6px;
        }

        .profile-dropdown .dropdown-item:hover {
            background-color: #003F72;
            color: #fff;
        }

        .text-secondary-custom {
            color: #003F72;
        }

        .navbar .nav-item .dropdown-menu .dropdown-item:hover {
            background: none;
            color: #c72336 !important;
        }

        .bg-primary-custom {
            background-color: #c72336 !important;
            color: #fff;
        }

        .btn-danger {
            background-color: #c72336;
            border-color: #c72336;
        }

        .btn-danger:hover {
            background-color: #a31c2c;
            border-color: #a31c2c;
        }

        .table thead th {
            background-color: #f8f9fa;
        }

        .pagination .page-link {
            color: #003F72;
        }

        .pagination .active .page-link {
            background-color: #c72336 !important;
            border-color: #c72336 !important;
        }

        .res {
            margin-top: 4%;
        }

        @media (max-width: 576px) {
            .table-responsive {
                font-size: 0.875rem;
            }
        }

        @media (max-width: 576px) {
            .nav-btn {
                margin-top: 10px;
            }

            .profile-dropdown {
                min-width: 100%;
            }
        }

        @media (max-width: 786px) {
            .custom-dropdown {
                min-width: 100%;
            }

            .navbar-toggler span {
                border: none;
            }

            .navbar-nav .badge {
                font-size: 12px;
                padding: 2px 5px;
                margin-top: 0;
            }

        }

        @media (max-width: 767.98px) {
            .res .col-custom {
                width: 50%;
                flex: 0 0 50%;
            }

            .portfolio-sidebar .widget {
                background: var(--color-white);
                padding: 15px;
                border-radius: 7px;
                margin-bottom: 0px;
                box-shadow: 0 0 12px 2px rgb(0 0 0 / 5%);
                height: 136px;
            }

            .portfolio-sidebar .widget .title {
                font-size: 18px;
            }

            .portfolio-sidebar h3 {
                color: #c72336;
                font-size: 32px;
                margin-top: -15px;
            }

            .navbar .offcanvas-header .btn-close {
                background-color: var(--color-red);
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 2l12 12M14 2L2 14'/%3E%3C/svg%3E");
                background-size: 1rem;
                background-repeat: no-repeat;
                background-position: center;
            }


        }
    </style>

</head>

<body>

    <!-- preloader -->
    <div class="preloader">
        <div class="loader-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- preloader end -->

    {{-- Dashboard Header --}}
    @include('frontend.includes.dashboard-header')

    

    <main class="main">
        @yield('content')
    </main>

    

     <!-- scroll-top -->
     <a href="#" id="scroll-top"><i class="far fa-arrow-up"></i></a>
    <!-- scroll-top end -->


    <!-- js -->
    <script data-cfasync="false" src="{{ asset('frontend/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}"></script>
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
<script src="{{ asset('frontend/js/contact-form.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>


</body>



</html>