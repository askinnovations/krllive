@extends('admin.layouts.app')
@section('content')
<div class="page-content">
<div class="container-fluid">
 <!-- start page title -->
                     <!-- start page title -->
                     <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Account Payable</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Account Payable</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- Accounts Payable Listing Page -->
                    <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">💳 Accounts Payable</h4>
                                        <p class="card-title-desc">Overview of accounts payable, including vendor
                                            details and payment status.</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="ex" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Vendor Name</th>
                                                <th>Bill Date</th>
                                                <th>Bill Amount</th>
                                                <th>Amount Paid</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>ABC Supplies</td>
                                                <td>10/12/2025</td>
                                                <td>₹15,000</td>
                                                <td>₹10,000</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>XYZ Enterprises</td>
                                                <td>11/12/2025</td>
                                                <td>₹20,000</td>
                                                <td>₹20,000</td>
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
