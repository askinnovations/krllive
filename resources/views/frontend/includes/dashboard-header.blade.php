 <!-- Header Area -->
 <header class="header">
        <div class="main-navigation">
            <nav class="navbar navbar-expand-lg">
                <div class="container position-relative">

                    <!-- Logo -->
                    <a class="navbar-brand" href="{{ route('user.dashboard') }}">
                    <img src="{{asset('frontend/img/logo.jpg')}}"  alt="logo" style="max-height: 50px;">
                        
                    </a>

                    <!-- Toggle Button for Offcanvas -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Offcanvas Menu -->
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <a href="index.html" class="offcanvas-brand" id="offcanvasNavbarLabel">
                                <img src="assets/img/logo.jpg" alt="" style="max-height: 40px;">
                            </a>
                            <button type="button" class="btn-close text-reset" style="color: #fff !important;"
                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>

                        <div class="offcanvas-body d-lg-flex justify-content-lg-between align-items-center gap-3">
                            <!-- Left - Navigation Items -->
                            <ul class="navbar-nav flex-grow-1 d-lg-flex align-items-lg-center gap-3 mb-3 mb-lg-0">
                                <!-- Add nav items if any -->
                            </ul>

                            <!-- Right - Icons and Profile -->
                            <ul class="navbar-nav d-flex align-items-center gap-3 mb-0 ms-lg-auto">
                                <!-- Cart -->
                                <li class="nav-item">
                                    <a class="nav-link position-relative" href="history.html">
                                        <i class="fas fa-receipt fs-5"></i>
                                    </a>
                                </li>


                                <!-- Notification -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link position-relative dropdown-toggle" href="#"
                                        data-bs-toggle="dropdown">
                                        <i class="fas fa-bell fs-5 text-secondary-custom"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge custom-badge">6</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm p-3 custom-dropdown"
                                        style="min-width: 320px; max-width: 100%; max-height: 350px; overflow-y: auto; white-space: normal;">
                                        <li class="dropdown-header fw-semibold text-secondary-custom">Recent
                                            Notifications</li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <!-- Notification Item -->
                                        <li class="mb-2">
                                            <a class="dropdown-item d-flex align-items-start gap-2 small" href="#"
                                                style="white-space: normal;">
                                                <i class="fas fa-box text-warning mt-1 flex-shrink-0"></i>
                                                <div style="flex: 1;">
                                                    <strong>New order booked</strong><br>
                                                    <span class="text-muted small">Order ID: ORD123472 · 2 mins
                                                        ago</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="mb-2">
                                            <a class="dropdown-item d-flex align-items-start gap-2 small" href="#"
                                                style="white-space: normal;">
                                                <i class="fas fa-truck text-primary mt-1 flex-shrink-0"></i>
                                                <div style="flex: 1;">
                                                    <strong>Package out for delivery</strong><br>
                                                    <span class="text-muted small">Delivery for ORD123469 · 10 mins
                                                        ago</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="mb-2">
                                            <a class="dropdown-item d-flex align-items-start gap-2 small" href="#"
                                                style="white-space: normal;">
                                                <i class="fas fa-times-circle text-danger mt-1 flex-shrink-0"></i>
                                                <div style="flex: 1;">
                                                    <strong>Order cancelled</strong><br>
                                                    <span class="text-muted small">ORD123465 · 30 mins ago</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="mb-2">
                                            <a class="dropdown-item d-flex align-items-start gap-2 small" href="#"
                                                style="white-space: normal;">
                                                <i class="fas fa-comment-alt text-info mt-1 flex-shrink-0"></i>
                                                <div style="flex: 1;">
                                                    <strong>Support replied</strong><br>
                                                    <span class="text-muted small">You have a new message · 1 hr
                                                        ago</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="mb-2">
                                            <a class="dropdown-item d-flex align-items-start gap-2 small" href="#"
                                                style="white-space: normal;">
                                                <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                                                <div style="flex: 1;">
                                                    <strong>Order confirmed</strong><br>
                                                    <span class="text-muted small">ORD123470 · 1 hr ago</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="mb-2">
                                            <a class="dropdown-item d-flex align-items-start gap-2 small" href="#"
                                                style="white-space: normal;">
                                                <i class="fas fa-warehouse text-secondary mt-1 flex-shrink-0"></i>
                                                <div style="flex: 1;">
                                                    <strong>Inventory updated</strong><br>
                                                    <span class="text-muted small">New stock added · 2 hrs ago</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Profile -->
                                @if(Auth::check())
                                    <!-- Profile -->
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle theme-btn px-3 py-2 rounded-pill text-white"
                                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="background-color: #c72336; font-weight: 500;">
                                            {{ Auth::user()->name }}
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm p-2 profile-dropdown" style="min-width: 180px;">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" href="{{ route('user.profile') }}">
                                                    <i class="fas fa-user-circle me-2 text-secondary-custom"></i> Profile
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('user.logout') }}" method="POST" class="w-100">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item d-flex align-items-center text-start w-100">
                                                        <i class="fas fa-sign-out-alt me-2 text-danger"></i> Logout
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a href="{{ route('user.login') }}" class="theme-btn px-3 py-2 rounded-pill text-white"
                                            style="background-color: #c72336; font-weight: 500;">
                                            Login Now <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
