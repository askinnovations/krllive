@extends('admin.layouts.app')
@section('content')
<div class="page-content">
<div class="container-fluid">
 <!-- start page title -->
 <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Ledgers</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Ledgers</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- Ledgers Listing Page -->
                    <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">📊 Ledgers</h4>
                                        <p class="card-title-desc">Overview of ledgers, including ledger name, group,
                                            and opening balance.</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ledger Name</th>
                                                <th>Ledger Group</th>
                                                <th>Opening Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Cash in Hand</td>
                                                <td>Asset</td>
                                                <td>₹10,000</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Accounts Payable</td>
                                                <td>Liability</td>
                                                <td>₹5,000</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Sales Revenue</td>
                                                <td>Income</td>
                                                <td>₹50,000</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Office Expenses</td>
                                                <td>Expense</td>
                                                <td>₹7,500</td>
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
