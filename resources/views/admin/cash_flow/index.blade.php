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
                                <h4 class="mb-sm-0 font-size-18">Cash Flow</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Cash Flow</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Cash Flow Listing Page -->
                    <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">💰 Cash Flow Listing</h4>
                                        <p class="card-title-desc">Track your opening balance, cash movement, and
                                            closing balance.</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Opening Balance</th>
                                                <th>Cash In</th>
                                                <th>Cash Out</th>
                                                <th>Closing Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>01-Apr-2025</td>
                                                <td>₹2,00,000</td>
                                                <td>₹4,50,000</td>
                                                <td>₹3,00,000</td>
                                                <td><span class="fw-bold ">₹3,50,000</span></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>02-Apr-2025</td>
                                                <td>₹3,50,000</td>
                                                <td>₹1,00,000</td>
                                                <td>₹50,000</td>
                                                <td><span class="fw-bold ">₹4,00,000</span></td>
                                            </tr>
                                            <!-- Add more rows as needed -->
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
