@extends('admin.layouts.app')
@section('content')
<div class="page-content">
<div class="container-fluid">
 <!-- start page title -->
 <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Ledger Master</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Ledger Master</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- Ledger Listing Page -->
                    <div class="row ledger-listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">📒 Ledger Master List</h4>
                                        <p class="card-title-desc">View, edit, or delete ledger details below.</p>
                                    </div>

                                    <a href="{{ route('admin.ledger_master.create') }}" class="btn" id="addLedgerBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        <i class="fas fa-plus"></i> Add
                                    </a>

                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Group/Subgroup</th>
                                                <th>PAN</th>
                                                <th>TAN</th>
                                                <th>GST</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>ABC Ltd</td>
                                                <td>Main Group A / Sub A1</td>
                                                <td>ABCDE1234F</td>
                                                <td>TAN12345B</td>
                                                <td>22ABCDE1234F1Z5</td>
                                                <td class="text-center">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button class="btn btn-sm btn-light view-ledger-btn"><i
                                                                class="fas fa-eye text-primary"></i></button>
                                                        <button class="btn btn-sm btn-light edit-btn"><i
                                                                class="fas fa-pen text-warning"></i></button>
                                                        <button class="btn btn-sm btn-light delete-btn"><i
                                                                class="fas fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- More rows -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

      </div> <!-- container-fluid -->
</div>
            <!-- End Page-content -->

@endsection
