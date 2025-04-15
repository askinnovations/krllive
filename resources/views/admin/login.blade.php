@extends('admin.layouts.auth')
'@section('title', 'Admin Login')
@section('content')

@section('content')
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xxl-3 col-lg-4 col-md-5">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="auth-content my-auto">
                        <div class="mb-4 mb-md-5 text-center">
                        <a href="#" class="d-block auth-logo">
                            <img  src="{{ asset('backend/images/logo.png') }}"  alt="" height="50"><span class="logo-txt">Khandelwal Roadlines</span>
                        </a>
                        </div>
                        <div class="text-center">
                                            <h5 class="mb-0">Welcome Back !</h5>
                                            <p class="text-muted mt-2">Sign in to continue to Khandelwal Roadlines</p>
                                        </div>
                            <form class="mt-4 pt-2" action="{{ route('admin.login.submit') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}"class="form-control" placeholder="Enter email" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary w-100" type="submit">Log In</button>
                                </div>
                            </form>
                        </div>
                        <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Khandelwal Roadlines   Created  <i class="mdi mdi-heart text-danger"></i> by ASK Innovations</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-9 col-lg-8 col-md-7">
                <div class="auth-bg pt-md-5 p-4 d-flex">
                    <div class="bg-overlay bg-primary"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



        