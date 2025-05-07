```blade
@extends('admin.layouts.app')
@section('title', 'Edit User | KRL')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit User</h4>
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Users</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row listing-form">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title">🛞 Edit User</h4>
                                <p class="card-title-desc">
                                    Update user details below. Fields marked with <span class="required"></span> are required.
                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.user.update',$user->id) }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                            
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Name<span class="required"></span></label>
                                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter User Name" value="{{ old('name', $user->name) }}" required>
                                                @error('name')
                                                    <small class="invalid-name text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email<span class="required"></span></label>
                                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter User Email" value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <small class="invalid-email text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="role" class="form-label">User Role<span class="required"></span></label>
                                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                                <option value="">Select Role</option>
                                                @foreach ($roles as $role )
                                                <option value="{{ $role->id }}" {{ $user->role ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <small class="invalid-role text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-5 mb-3 form-group mt-4">
                                            <label for="password_switch">Update Password</label>
                                            <div class="form-check form-switch custom-switch-v1 float-end">
                                                <input type="checkbox" name="password_switch" class="form-check-input" value="on" id="password_switch" {{ old('password_switch') == 'on' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="password_switch"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ps_div {{ old('password_switch') == 'on' ? '' : 'd-none' }}">
                                            <div class="form-group">
                                                <label for="password" class="form-label">Password<span class="required"></span></label>
                                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter New Password" minlength="6">
                                                @error('password')
                                                    <small class="invalid-password text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {{-- <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Cancel</a> --}}
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password field visibility
        document.getElementById('password_switch').addEventListener('change', function () {
            document.querySelector('.ps_div').classList.toggle('d-none', !this.checked);
        });

        // Bootstrap form validation
        (function () {
            'use strict';
            const form = document.querySelector('.needs-validation');
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })();
    </script>
@endsection
```