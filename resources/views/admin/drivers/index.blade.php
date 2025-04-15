@extends('admin.layouts.app')
@section('title', 'Drivers | KRL')
@section('content')
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Drivers</h4>
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
                                        <li class="breadcrumb-item active">Drivers</li>
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

                                        <h4 class="card-title">🛞 Driver Listing</h4>
                                        
                                        <p class="card-title-desc">
                                            View, edit, or delete driver details below. This table supports search,
                                            sorting, and pagination via DataTables.
                                        </p>
                                    </div>
                                    <a class="btn"  href="{{ route('admin.drivers.create') }}"  id="addVehicleBtn"
                                    style="background-color: #ca2639; color: white; border: none;">
                                    <i class="fas fa-plus"></i> Add Driver
                                </a>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Full Name</th>
                                                <th>Phone Number</th>
                                                <th>Vehicle Number</th>
                                                <th> Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($drivers as $driver)
                                           
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$driver->first_name}}{{$driver->last_name}}</td>
                                                <td>{{$driver->phone_number}}</td>
                                                <td>{{$driver->vehicle_number ?? ' '}}</td>
                                              
                                                <td><span class="badge bg-success">{{$driver->status}}</span></td>
                                                <td>
                                                    <a href="{{ route('admin.drivers.show',$driver->id) }}">
                                                    <button class="btn btn-sm btn-light view-btn">
                                                        <i class="fas fa-eye text-primary"></i>
                                                    </button>
                                                    </a>
                                                    <a href="{{ route('admin.drivers.edit',$driver->id) }}">
                                                    <button class="btn btn-sm btn-light edit-btn">
                                                        <i class="fas fa-pen text-warning"></i>
                                                    </button></a>
                                                    <a href="{{ route('admin.drivers.delete',$driver->id) }}">
                                                    <button class="btn btn-sm btn-light delete-btn">
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button></a>
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
                    <div id="viewModal" class="modal fade" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">🛞 Tyre Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>🏢 Company:</strong> <span id="viewCompany"></span></p>
                                    <p><strong>🔩 Make & Model:</strong> <span id="viewModel"></span></p>
                                    <p><strong>📄 Description:</strong> <span id="viewDescription"></span></p>
                                    <p><strong>📏 Format:</strong> <span id="viewFormat"></span></p>
                                    <p><strong>🆔 Tyre Number:</strong> <span id="viewTyreNumber"></span></p>
                                    <p><strong>📊 Health Status:</strong> <span id="viewHealth"></span></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add Tyre Modal -->
                   
                </div>
               
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->
@endsection