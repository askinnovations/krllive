
@extends('frontend.layouts.app')
@section('title') {{ 'login' }} @endsection

@section('content')
<!-- login area -->
<div class="auth-area py-120">
            <div class="container">
                <div class="col-md-5 mx-auto">
                    <div class="auth-form">
                        <div class="auth-header">
                            <img src="assets/img/logo.jpg" alt="">
                            <p>Login with your KRL account</p>
                        </div>
                        <form method="POST" action="{{ route('user.login') }}">
                           @csrf
                            <div class="form-group">
                                <div class="form-icon">
                                    <i class="far fa-phone"></i>
                                    <input type="number" name="mobile_number" class="form-control" placeholder="Your Number" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-icon">
                                    <i class="far fa-key"></i>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Your Password" required>
                                    <span class="password-view"><i class="far fa-eye-slash"></i></span>
                                </div>
                            </div>
                            <div class="auth-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                                
                            </div>
                            <div class="auth-btn">
                                <button type="submit" class="theme-btn"><span class="far fa-sign-in"></span>
                                    Login</button>
                            </div>
                        </form>
                        <div class="auth-bottom">

                            <p class="auth-bottom-text">Don't have an account? <a href="{{ route('user.register') }}">Register.</a></p>
                        </div>
                    </div>
                </div>
            </div>
</div>
        <!-- login area end -->
@endsection