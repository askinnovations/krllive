<!doctype html>
<html lang="en">
   <head>
        <meta charset="utf-8" />
        <title>KRL</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="krl" name="description" />
        <meta content="ASK Innovations" name="ASK Innovations" />
       
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('backend/images/logo.png') }}">
        
        <!-- Plugin CSS -->
        <link href="{{ asset('backend/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

        <!-- Preloader CSS -->
        <link rel="stylesheet" href="{{ asset('backend/css/preloader.min.css') }}" type="text/css" />

        <!-- Bootstrap CSS -->
        <link href="{{ asset('backend/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

        <!-- Icons CSS -->
        <link href="{{ asset('backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- App CSS -->
        <link href="{{ asset('backend/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />


    </head>

    <body>

    @yield('content')
        <script src="{{ asset('backend/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('backend/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('backend/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('backend/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('backend/libs/feather-icons/feather.min.js') }}"></script>
        <!-- pace js -->
        <script src="{{ asset('backend/libs/pace-js/pace.min.js') }}"></script>

        <!-- apexcharts -->
        <script src="{{ asset('backend/libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- Plugins js -->
        <script src="{{ asset('backend/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset('backend/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>

        <!-- Dashboard Init -->
        <script src="{{ asset('backend/js/pages/dashboard.init.js') }}"></script>

        <script src="{{ asset('backend/js/app.js') }}"></script>



</body>

</html>