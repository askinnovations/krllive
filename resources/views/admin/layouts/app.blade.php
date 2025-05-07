<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>KRL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="KRL" name="description" />
    <meta content="ASK Innovations" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/images/logo.png') }}">

    <!-- Core CSS -->
    <link href="{{ asset('backend/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('backend/css/preloader.min.css') }}" type="text/css" />

    <!-- DataTables CSS -->
    <link href="{{ asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Vector Maps CSS -->
    <link href="{{ asset('backend/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

    <!-- Boxicons (optional, for icons) -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

   <body>
      <!-- <body data-layout="horizontal"> -->
      <!-- Begin page -->
      <div id="layout-wrapper">
      {{-- Navbar start --}}
      @include('admin.layouts.navbar')
      {{-- Navbar start --}}
      {{-- Sidebar start --}}
      @include('admin.layouts.sidebar')
      {{-- Sidebar end --}}
      <div class="main-content">
         {{-- Content start --}}
         @yield('content')
         {{-- Content end --}}
         {{-- Footer start --}}
         @include('admin.layouts.footer')
         {{-- Footer end --}}
      </div>
    <!-- Auto-remove alerts after 4 seconds -->
 <!-- Your page content here -->

    <!-- Core JS (Load jQuery first) -->
    <script src="{{ asset('backend/libs/jquery/jquery.min.js') }}"></script>

    <!-- Then load Select2 (after jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Bootstrap and Core Libraries -->
    <script src="{{ asset('backend/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('backend/libs/pace-js/pace.min.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('backend/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('backend/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('backend/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('backend/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('backend/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('backend/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- DataTables Init -->
    <script src="{{ asset('backend/js/pages/datatables.init.js') }}"></script>

    <!-- ApexCharts (optional, if using charts) -->
    <script src="{{ asset('backend/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector Maps -->
    <script src="{{ asset('backend/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('backend/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- Dashboard Init (optional, if using dashboard charts/maps) -->
    <script src="{{ asset('backend/js/pages/dashboard.init.js') }}"></script>

    <!-- App JS -->
    <script src="{{ asset('backend/js/app.js') }}"></script>

<!-- jQuery -->
<!-- <script src="{{ asset('backend/libs/jquery/jquery.min.js') }}"></script> -->

<!-- Popper.js (MISSING currently, add this line) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="{{ asset('backend/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


    <!-- Custom Scripts -->
    <script>
        $(document).ready(function() {
            $('#orderBookingTable').DataTable({
                "paging": true,
                "searching": true,
                "info": true,
                "responsive": true
            });

            $('#datatable').DataTable(); // if you have another datatable
        });

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelectorAll('.auto-dismiss').forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 4000);
        });
    </script>

   </body>
</html>