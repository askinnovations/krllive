@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')
<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Profile</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Profile</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Full Name</th>
                                                    <th>Mobile No</th>
                                                    <th>PAN</th>
                                                    <th>Firm Name</th>
                                                    <th>GST No</th>
                                                    <th>Aadhar No</th>
                                                    <th>You Are</th>
                                                    <th>Industry Sector</th>
                                                    <th>Address</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Pincode</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($users as $key => $user)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td> {{-- Serial Number --}}
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->mobile_number }}</td>
                                                    <td>{{ $user->pan_number }}</td>
                                                    <td>{{ $user->firm_number }}</td>
                                                    <td>{{ $user->gst_number }}</td>
                                                    <td>{{ $user->adhar_number }}</td>
                                                    <td>{{ $user->you_are }}</td>
                                                    <td>{{ $user->industry }}</td>
                                                    <td>{{ $user->address }}</td>
                                                    <td>{{ $user->city }}</td>
                                                    <td>{{ $user->state }}</td>
                                                    <td>{{ $user->pincode }}</td>
                                                </tr>
                                                @endforeach
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                        
        
                   
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
@endsection