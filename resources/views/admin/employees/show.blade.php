@extends('admin.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- View Vehicle Details Page -->
        <div class="view-vehicle-form">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4> Employee Details View</h4>
                        <p class="mb-0">View details for the Employee.</p>
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
                        <div class="col-md-4"><strong>💰  Selary:</strong> {{ $employee->salary }}</div>
                    </div>
                
                    <div class="row mb-2">
                        <div class="col-md-4"><strong>📌 Status:</strong> 
                            @if($employee->status === 'active')
                                <span class="text-success">Active</span>
                            @else
                                <span class="text-danger">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
                
        </div>
    </div>
</div>

                    
</div>
</div>
@endsection