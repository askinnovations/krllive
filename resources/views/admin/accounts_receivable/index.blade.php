@extends('admin.layouts.app')
@section('content')
<div class="page-content">
<div class="container-fluid">
 <!-- start page title -->
 
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Account Receivable</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Account Receivable</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- Accounts Receivable Listing Page -->
                    <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">💰 Accounts Receivable</h4>
                                        <p class="card-title-desc">Overview of accounts receivable, including customer
                                            details and payment status.</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Customer Name</th>
                                                <th>Invoice Date</th>
                                                <th>Amount</th>
                                                <th>Amount Received</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>XYZ Corp</td>
                                                <td>12/12/2025</td>
                                                <td>₹30,000</td>
                                                <td>₹15,000</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>ABC Limited</td>
                                                <td>15/12/2025</td>
                                                <td>₹45,000</td>
                                                <td>₹45,000</td>
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
