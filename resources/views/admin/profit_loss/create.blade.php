@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
           <!-- Add Ledger Form -->
           <div class="row ledger-add-form" >
                        <div class="col-12">
                            <div class="card">
                               
                                 <!-- Add Ledger Form -->
                    <div class="row ledger-add-form" >
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4>📒 Add Ledger Master</h4>
                                        <p>Enter details for the new ledger below.</p>
                                    </div>
                                    <a href="{{ route('admin.ledger_master.index') }}"  class="btn backToLedgerListBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        ⬅ Back
</a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control" placeholder="Enter name">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Group/Subgroup</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter group or subgroup">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">PAN</label>
                                                <input type="text" class="form-control" placeholder="ABCDE1234F">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">TAN</label>
                                                <input type="text" class="form-control" placeholder="TAN12345B">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">GST</label>
                                                <input type="text" class="form-control" placeholder="22ABCDE1234F1Z5">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-primary">Save Ledger</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>


@endsection