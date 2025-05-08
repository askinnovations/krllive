@extends('admin.layouts.app')
@section('content')
<style>
        .card .rounded-circle {
            border-radius: 50% !important;
            padding: 12px 17px !important;
        }

        .main-card1 .card {
            margin-bottom: 0 !important;
        }

        @media(max-width:678px) {
            .card-to {
                margin-top: 31px;
            }
        }
    </style>
<div class="page-content">
<div class="container-fluid">
 <!-- start page title -->
                <!-- start page title -->
                <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Balance Sheet</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Balance Sheet</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row g-4 main-card1">
                        <!-- Total Assets -->
                        <div class="col-md-4 card-to">
                            <div class="card shadow-sm border-0">
                                <div class="card-body bg-light-subtle rounded-3 p-4" style="background-color: #f5f8fa;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="text-muted mb-1">Total Assets</h6>
                                            <h4 class="fw-bold" style="color: #1f78c1;">₹25,00,000</h4>
                                        </div>
                                        <div class="icon bg-white shadow-sm rounded-circle p-3">
                                            <i class="bi bi-house-door-fill fs-4" style="color: #1f78c1;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Liabilities -->
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-body bg-light-subtle rounded-3 p-4" style="background-color: #f5f8fa;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="text-muted mb-1">Total Liabilities</h6>
                                            <h4 class="fw-bold" style="color: #e55353;">₹10,00,000</h4>
                                        </div>
                                        <div class="icon bg-white shadow-sm rounded-circle p-3">
                                            <i class="bi bi-exclamation-circle-fill fs-4" style="color: #e55353;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Net Worth -->
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-body bg-light-subtle rounded-3 p-4" style="background-color: #f5f8fa;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="text-muted mb-1">Net Worth</h6>
                                            <h4 class="fw-bold" style="color: #28a745;">₹15,00,000</h4>
                                        </div>
                                        <div class="icon bg-white shadow-sm rounded-circle p-3">
                                            <i class="bi bi-graph-up fs-4" style="color: #28a745;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

      </div> <!-- container-fluid -->
</div>
            <!-- End Page-content -->

@endsection
