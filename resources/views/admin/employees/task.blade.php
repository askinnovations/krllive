@extends('admin.layouts.app')
@section('title', 'Tasks | KRL')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Tasks</h4>
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
                                <li class="breadcrumb-item active">Tasks</li>
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

                                <h4 class="card-title">🛞 Tasks Listing</h4>
                                <p class="card-title-desc">
                                    View, edit, or delete tyre details below. This table supports search,
                                    sorting, and pagination via DataTables.
                                </p>
                            </div>
                           
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Task Id</th>
                                        <th>Assigned To</th>
                                        <th>Description</th>
                                        <th>High Priority</th>
                                        <th>Date</th>
                                       
                                        <th>Action</th>
                                    </tr>
                                </thead>
                               
                                <tbody>
                                    @foreach ($employee->tasks as $task)
                                    <tr>
                                        <td>TSK##{{ $task->id }}</td>
                                        <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                        <td>{{ $task->description ?? 'N/A' }}</td>
                                        <td>
                                            @if($task->high_priority)
                                                <span class="badge bg-danger">High</span>
                                            @else
                                                <span class="badge bg-secondary">Normal</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($task->date)->format('Y-m-d') ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('admin.task_management.task_status', $task->id) }}">
                                                <button class="btn btn-sm {{ $task->status === 'close' ? 'btn-danger' : 'btn-secondary' }}">
                                                    {{ $task->status === 'close' ? 'Open' : 'Close' }}
                                                </button>
                                            </a>
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
        <!-- End Page-content -->
    </div>
    <!-- end main content-->

    </div>
    </div> <!-- end slimscroll-menu-->
    </div>
    

    <!-- Bootstrap JS -->

   
@endsection