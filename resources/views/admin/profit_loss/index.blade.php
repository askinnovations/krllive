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
 <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Profit & Loss Statement</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Profit & Loss</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row g-4 main-card1">
                        <!-- Income Total -->
                        <div class="col-md-4 card-to">
                            <div class="card shadow-sm border-0">
                                <div class="card-body bg-light-subtle rounded-3 p-4" style="background-color: #fff0f3;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="text-muted mb-1">Income Total</h6>
                                            <h4 class="fw-bold" style="color: #ca2639;">₹15,00,000</h4>
                                        </div>
                                        <div class="icon bg-white shadow-sm rounded-circle p-3">
                                            <i class="bi bi-wallet2 fs-4" style="color: #ca2639;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expense Total -->
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-body bg-light-subtle rounded-3 p-4" style="background-color: #fff0f3;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="text-muted mb-1">Expense Total</h6>
                                            <h4 class="fw-bold text-danger">₹8,75,000</h4>
                                        </div>
                                        <div class="icon bg-white shadow-sm rounded-circle p-3">
                                            <i class="bi bi-credit-card fs-4 text-danger"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Net Profit / Loss -->
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-body bg-light-subtle rounded-3 p-4" style="background-color: #fff0f3;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="text-muted mb-1">Net Profit</h6>
                                            <h4 class="fw-bold text-success" style="color: #4fbb00 !important;">
                                                ₹6,25,000</h4>
                                        </div>
                                        <div class="icon bg-white shadow-sm rounded-circle p-3">
                                            <i class="bi bi-graph-up-arrow fs-4 "
                                                style="color: #4fbb00 !important;"></i>
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
