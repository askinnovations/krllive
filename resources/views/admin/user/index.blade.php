@extends('admin.layouts.app')
@section('title', 'Employees | KRL')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Users</h4>
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
                                <li class="breadcrumb-item active">Users</li>
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
                                <h4 class="card-title">🛞 Users Listing</h4>
                                <p class="card-title-desc">
                                    View, edit, or delete permissions details below. This table supports search,
                                    sorting, and pagination via DataTables.
                                </p>
                            </div>
                            @if (hasAdminPermission('create users'))
                            <a class="btn" href="{{ route('admin.user.create') }}" 
                            style="background-color: #ca2639; color: white; border: none;">
                             <i class="fas fa-plus"></i> Add User
                         </a>
                         @endif
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>
                                        @if (hasAdminPermission('edit users') || hasAdminPermission('delete users') )
                                       Action
                                        @endif
                                    </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        {{-- <td>{{ $loop->iteration }} {{ auth()->guard($user->role)->user() }}</td> --}}
                                        
                                        <td>##{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ \App\Models\Role::find($user->role)->name ?? 'N/A' }}</td>

                                        <td>
                                            @if (hasAdminPermission('edit users'))
                                          
                                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-light">
                                                <i class="fas fa-pen text-warning"></i>
                                            </a>
                                            @endif
                                            @if (hasAdminPermission('delete users'))
                                            <a href="{{ route('admin.user.delete', $user->id) }}"
                                                class="btn btn-sm btn-light"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="fas fa-trash text-danger"></i>
                                             </a>
                                             @endif
                                              </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- View Modal -->
        </div>
    </div>
@endsection