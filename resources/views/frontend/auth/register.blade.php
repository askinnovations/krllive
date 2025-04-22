@extends('frontend.layouts.app')
@section('title') {{ 'register' }} @endsection

@section('content')
<!-- register area -->
<div class="auth-area py-120">
            <div class="container">
                <div class="col-md-5 mx-auto">
                    <div class="auth-form">
                        <div class="auth-header">
                            <img src="assets/img/logo.jpg" alt="">
                            <p>Create your free KRL account</p>
                        </div>
                        <form method="POST" action="{{ route('user.register') }}" onsubmit="return validateForm();">
                        @csrf
                            <div class="form-group">
                                <div class="form-icon">
                                    <i class="far fa-user-tie"></i>
                                    <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-icon">
                                    <i class="far fa-phone"></i>
                                    <input type="number" class="form-control" name="mobile_number" placeholder="Your Number" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-icon">
                                    <i class="far fa-key"></i>
                                    <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
                                    <span class="password-view"><i class="far fa-eye-slash"></i></span>
                                </div>
                            </div>
                            <div class="auth-group">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agree" name="agree">
                                <label class="form-check-label" for="agree">
                                        I agree with the <a href="{{ route('front.terms') }}" class="auth-group-link">Terms &
                                            Conditions.</a>
                                    </label>
                                </div>
                            </div>
                            <div class="auth-btn">
                                <button type="submit" class="theme-btn">
                                    <span class="far fa-paper-plane"></span>
                                    Register
                                </button>
                            </div>
                        </form>

                        <div class="auth-bottom">

                            <p class="auth-bottom-text">Already have an account? <a href="{{ route('user.login') }}">Login.</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- register area end -->

        <!--  -->
     
<script>
    function validateForm() {
        const checkbox = document.getElementById('agree');
        if (!checkbox.checked) {
            alert('Please agree to the Terms & Conditions before registering.');
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>
@endsection