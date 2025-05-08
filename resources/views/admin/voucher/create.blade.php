@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Voucher Add/Edit Form -->
            <div class="row add-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4>➕ Add Voucher</h4>
                                        <p>Fill in the details to create a new voucher.</p>
                                    </div>
                                    
                                    <a href="{{ route('admin.voucher.index') }}" class="btn" id="backToVoucherListBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        ⬅ Back
                                    </a>

                                </div>
                                <div class="card-body">
                                    <!-- Row 1: Voucher Type & Date -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Voucher Type</label>
                                                <select class="form-control" id="voucherType">
                                                    <option value="">-- Select --</option>
                                                    <option value="Payment">Payment</option>
                                                    <option value="Receipt">Receipt</option>
                                                    <option value="Journal">Journal</option>
                                                    <option value="Contra">Contra</option>
                                                    <option value="Sales">Sales</option>
                                                    <option value="Purchase">Purchase</option>
                                                    <option value="Expense">Expense</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Date</label>
                                                <input type="date" class="form-control"
                                                    value="<?php echo date('Y-m-d'); ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row 2: From & To -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3" id="fromField">
                                                <label class="form-label" id="fromLabel">From</label>
                                                <input type="text" class="form-control" id="fromInput"
                                                    placeholder="From Account">
                                                <small class="form-text text-muted" id="fromNote"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3" id="toField">
                                                <label class="form-label" id="toLabel">To</label>
                                                <input type="text" class="form-control" id="toInput"
                                                    placeholder="To Account">
                                                <small class="form-text text-muted" id="toNote"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row 3: Amount & Description -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Amount</label>
                                                <input type="number" class="form-control" placeholder="Enter amount">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" rows="2"
                                                    placeholder="Enter description"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row 4: Narration, Tally Narration, Assign -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Narration</label>
                                                <textarea class="form-control" rows="2"
                                                    placeholder="Enter narration"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tally Narration</label>
                                                <textarea class="form-control" rows="2"
                                                    placeholder="Enter tally narration"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                              <label class="form-label">Assign</label>
                                              <select class="form-control">
                                                <option value="">-- Select Person or Entity --</option>
                                                <option value="Person A">Person A</option>
                                                <option value="Person B">Person B</option>
                                                <option value="Entity X">Entity X</option>
                                                <option value="Entity Y">Entity Y</option>
                                              </select>
                                            </div>
                                          </div>
                                          
                                    </div>

                                    <!-- Submit -->
                                    <div class="row">
                                        <div class="col-12 text-end">
                                            <button class="btn btn-primary">Save Voucher</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>


@endsection