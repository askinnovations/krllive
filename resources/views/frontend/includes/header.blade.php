@php
    use Illuminate\Support\Facades\Auth;
@endphp
<!-- header area -->
 <header class="header">

<!-- navbar -->
<div class="main-navigation">
    <nav class="navbar navbar-expand-lg">
        <div class="container position-relative">
            <a class="navbar-brand" href="{{ route('front.index') }}">
            <img src="{{asset('frontend/img/logo.jpg')}}"  alt="logo">
            </a>
            <div class="mobile-menu-right">
               
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                    aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <a href="{{ route('front.index') }}" class="offcanvas-brand" id="offcanvasNavbarLabel">
                    <img src="{{asset('frontend/img/logo.jpg')}}"  alt="logo">
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i
                            class="far fa-xmark"></i></button>
                </div>
                <div class="offcanvas-body gap-xl-4">
                    <ul class="navbar-nav justify-content-end flex-grow-1">
                        <li class="nav-item dropdown">
                            <a class="nav-link  active" href="{{ route('front.index') }}">Home</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('front.about') }}">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('front.contact') }}">Contact Us</a></li>

                        
                        <div class="nav-btn mobile">
                            @if(Auth::check())
                                <span style="color: #003F72;">
                                    {{ Auth::user()->name }}
                                </span>
                                <form action="{{ route('user.logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="theme-btn">Logout <i class="fas fa-sign-out-alt"></i></button>
                                </form>
                            @else
                                <a href="{{ route('user.login') }}" class="theme-btn">Login Now <i class="fas fa-arrow-right"></i></a>
                            @endif
                        </div>

                    </ul>
                    <!-- nav-right -->
                    <div class="nav-right">

                            <div class="nav-btn">
                                @if(Auth::check())
                                    <span style="color: #003F72;">
                                         {{ Auth::user()->name }}
                                    </span>
                                    <form action="{{ route('user.logout') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="theme-btn">
                                            Logout <i class="fas fa-sign-out-alt"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('user.login') }}" class="theme-btn">
                                        Login Now <i class="fas fa-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        <button type="button" class="sidebar-btn nav-right-link" data-bs-toggle="offcanvas"
                            data-bs-target="#sidebarPopup">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
<!-- navbar end-->

</header>
<!-- header area end -->