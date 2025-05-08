@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Add Group Form -->
            <div class="row group-add-form" >
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4>📁 Add Group</h4>
                                        <p>Enter details for the new group below.</p>
                                    </div>
                                    <a href="{{ route('admin.group.index') }}" class="btn backToGroupListBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        ⬅ Back
</a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Group Name</label>
                                                <input type="text" class="form-control" placeholder="Enter group name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Sub Group (optional)</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter sub group name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-primary">Save Group</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- View Group Details -->
                    <div class="row group-view-form" style="display: none;">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4>📄 View Group Details</h4>
                                        <p>Below are the details of the selected group.</p>
                                    </div>
                                    <button class="btn backToGroupListBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        ⬅ Back
                                    </button>
                                </div>
                                <div class="card-body">
                                    <p><strong>Group Name:</strong> <span id="viewGroupName">Main Group A</span></p>
                                    <p><strong>Sub Group:</strong> <span id="viewSubGroupName">Sub Group A1</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>


@endsection