@extends('admin.layouts.app')
@section('title', 'Employees | KRL')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Permissions</h4>
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
                                <li class="breadcrumb-item active">Permissions</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <!-- Tyre Listing Page -->
            <div class="row listing-form">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title">🛞 Permissions Listing</h4>
                                <p class="card-title-desc">
                                    View, edit, or delete permissions details below. This table supports search,
                                    sorting, and pagination via DataTables.
                                </p>
                            </div>
                            @if (hasAdminPermission('create permissions'))
                            <a class="btn" href="{{ route('admin.permission.create') }}" id="addVehicleBtn"
                               style="background-color: #ca2639; color: white; border: none;">
                                <i class="fas fa-plus"></i> Add Permission
                            </a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Sno.</th>
                                        <th>Permission</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td class="action">
                                            @if (hasAdminPermission('edit permissions'))
                                            <a href="">
                                                <button class="btn btn-light btn-sm edit-btn">
                                                    <i class="fas fa-pen text-warning"></i>
                                                </button>
                                            </a>
                                            @endif
                                            @if (hasAdminPermission('delete permissions'))
                                            <button class="btn btn-sm btn-light delete-btn">
                                                <a href="">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </a>
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Pagination Links -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $permissions->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- View Modal -->
        </div>
    </div>
@endsection