@extends('admin.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- View Employee Details Page -->
        <div class="view-employee-form">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4>Employee Details View</h4>
                        <p class="mb-0">View details for the employee.</p>
                    </div>
                    <a href="{{ route('admin.employees.index') }}" class="btn" id="backToListBtn"
                        style="background-color: #ca2639; color: white; border: none;">
                        ⬅ Back to Listing
                    </a>
                </div>
                <div class="card-body">
                    <h4>👨‍💼 Employee Details</h4>
                    <div class="row mb-2">
                        <div class="col-md-4"><strong>👤 First Name:</strong> {{ $employee->first_name }}</div>
                        <div class="col-md-4"><strong>👤 Last Name:</strong> {{ $employee->last_name }}</div>
                        <div class="col-md-4"><strong>📧 Email:</strong> {{ $employee->email }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4"><strong>📞 Contact Number:</strong> {{ $employee->phone_number }}</div>
                        <div class="col-md-4"><strong>📱 Emergency Contact:</strong> {{ $employee->emergency_contact ?? 'N/A' }}</div>
                        <div class="col-md-4"><strong>🏠 Address:</strong> {{ $employee->address }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4"><strong>🌍 State:</strong> {{ $employee->state }}</div>
                        <div class="col-md-4"><strong>📮 Postal Code:</strong> {{ $employee->pin_code ?? 'N/A' }}</div>
                        <div class="col-md-4"><strong>🆔 Aadhaar Number:</strong> {{ $employee->aadhaar_number ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4"><strong>💳 PAN Number:</strong> {{ $employee->pan_number ?? 'N/A' }}</div>
                        <div class="col-md-4"><strong>🏦 Account Number:</strong> {{ $employee->account_number ?? 'N/A' }}</div>
                        <div class="col-md-4"><strong>🏦 IFSC Code:</strong> {{ $employee->ifsc_code ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4"><strong>💼 Designation:</strong> {{ $employee->designation ?? 'N/A' }}</div>
                        <div class="col-md-4"><strong>🏢 Department:</strong> {{ $employee->department ?? 'N/A' }}</div>
                        <div class="col-md-4"><strong>📅 Date of Joining:</strong> {{ $employee->date_of_joining ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4"><strong>💰 Salary:</strong> {{ $employee->salary ?? 'N/A' }}</div>
                        <div class="col-md-4"><strong>📌 Status:</strong>
                            @if($employee->status === 'active')
                                <span class="text-success">Active</span>
                            @else
                                <span class="text-danger">Inactive</span>
                            @endif
                        </div>
                    </div>
                    <h6 class="mt-3">📁 Documents</h6>
                    <div class="row">
                        @if($employee->employee_photo)
                            <div class="col-md-4 mb-2">
                                <button type="button" class="btn btn-outline-info openImageModal w-100"
                                    data-image="{{ asset('storage/' . $employee->employee_photo) }}" data-bs-toggle="modal"
                                    data-bs-target="#imageModal">
                                    🖼️ Employee Photo: View
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Document Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" alt="Document" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.openImageModal', function () {
            var imageUrl = $(this).data('image');
            console.log("Image URL:", imageUrl);
            $('#modalImage').attr('src', imageUrl);
        });
    });
</script>
@endsection