@extends('admin.layouts.app')
@section('content')
<div class="page-content">
<div class="container-fluid">
  <!-- start page title -->
  <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Group</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Group</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- Group Listing Page -->
                    <div class="row group-listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">📁 Group List</h4>
                                        <p class="card-title-desc">View, edit, or delete group details below.</p>
                                    </div>
                                     <a href="{{ route('admin.group.create') }}" class="btn" id="addGroupBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        <i class="fas fa-plus"></i> Add
</a>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Group Name</th>
                                                <th>Sub Group</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Main Group A</td>
                                                <td>Sub Group A1</td>
                                                <td class="text-center">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button class="btn btn-sm btn-light view-group-btn"><i
                                                                class="fas fa-eye text-primary"></i></button>
                                                        <button class="btn btn-sm btn-light edit-btn"><i
                                                                class="fas fa-pen text-warning"></i></button>
                                                        <button class="btn btn-sm btn-light delete-btn"><i
                                                                class="fas fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Add more group rows here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
      </div> <!-- container-fluid -->
</div>
            <!-- End Page-content -->

@endsection
