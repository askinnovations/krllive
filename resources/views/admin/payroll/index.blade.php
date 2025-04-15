@extends('admin.layouts.app')
@section('title', 'Employees | KRL')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Payroll</h4>
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
                                <li class="breadcrumb-item active">Payroll</li>
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

                                <h4 class="card-title">🛞 Payroll Listing</h4>
                                <p class="card-title-desc">
                                    View, edit, or delete tyre details below. This table supports search,
                                    sorting, and pagination via DataTables.
                                </p>
                            </div>
                            {{-- <a class="btn"  href="{{ route('admin.employees.create') }}"  id="addVehicleBtn"
                            style="background-color: #ca2639; color: white; border: none;">
                            <i class="fas fa-plus"></i> Add Employee
                        </a> --}}
                           
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Employee ID</th>
                                        <th>Full Name</th>
                                        <th>pay Amount</th>
                                        <th>Salary Amount</th>
                                        <th>Present  days</th>
                                        <th>Working days</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($payrollData as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>EMP##{{ $data['employee']->id }}</td>

                                            <td>{{ $data['employee']->first_name }} {{ $data['employee']->last_name }}</td>
                                            <td>₹{{ $data['total_salary'] }}</td>
                                            <td>{{ $data['payable_salary'] }}</td>
                                            <td>{{ $data['present_days'] }}</td>
                                            <td>{{ $data['working_days'] }}</td>
                                            <td> <a href="{{ route('admin.payroll.show', $data['employee']->id) }}"> <button
                                                class="btn btn-light btn-sm edit-btn">
                                                <i class="fas fa-eye text-primary"></i>
                                            </button></a>

                                        <a href=""> <button
                                                class="btn btn-light btn-sm edit-btn">
                                                <i class="fas fa-pen text-warning"></i>
                                            </button></a>
                                        <button class="btn btn-sm btn-light delete-btn"><a
                                                href="">
                                                <i class="fas fa-trash text-danger"></i></a>
                                        </button></td>
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
    </div> <!-- end slimscroll-menu-->
    </div>
   
@endsection