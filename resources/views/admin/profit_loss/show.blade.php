@extends('admin.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- View Vehicle Details Page -->
        <div class="view-vehicle-form">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4>🚗 Vehicle Details View</h4>
                        <p class="mb-0">View details for the vehicle.</p>
                    </div>
                    <a href="{{ route('admin.vehicles.index') }}" class="btn" id="backToListBtn"
                        style="background-color: #ca2639; color: white; border: none;">
                        ⬅ Back to Listing
                    </a>
                </div>
                <div class="card-body">
    <h4>Vehicle Details</h4>
    <p><strong>🚗 Vehicle Type:</strong> {{ $vehicle->vehicle_type }}</p>
    <p><strong>🔢 Vehicle Number:</strong> {{ $vehicle->vehicle_no }}</p>
    <p><strong>📞 Registered Mobile Number:</strong> {{ $vehicle->registered_mobile_number }}</p>
    <p><strong>⚖️ Gross Vehicle Weight (GVW):</strong> {{ $vehicle->gvw ?? 'N/A' }}</p>
    <p><strong>📦 Payload:</strong> {{ $vehicle->payload ?? 'N/A' }}</p>
    <p><strong>🔧 Chassis Number:</strong> {{ $vehicle->chassis_number ?? 'N/A' }}</p>
    <p><strong>🛠️ Engine Number:</strong> {{ $vehicle->engine_number ?? 'N/A' }}</p>
    <p><strong>🚪 Number of Tyres:</strong> {{ $vehicle->number_of_tyres ?? 'N/A' }}</p>

    <hr>

    <h4>Vehicle Documents</h4>

    @php
        $documents = [
            'rc_document_file' => ['label' => '📄 Registration Certificate (RC)', 'valid_from' => $vehicle->rc_valid_from, 'valid_till' => $vehicle->rc_valid_till],
            'fitness_certificate' => ['label' => '🏋️ Fitness Certificate', 'valid_from' => null, 'valid_till' => $vehicle->fitness_valid_till],
            'insurance_document' => ['label' => '🛡️ Insurance Document', 'valid_from' => $vehicle->insurance_valid_from, 'valid_till' => $vehicle->insurance_valid_till],
            'authorization_permit' => ['label' => '📝 Authorization Permit', 'valid_from' => $vehicle->auth_permit_valid_from, 'valid_till' => $vehicle->auth_permit_valid_till],
            'national_permit' => ['label' => '🌐 National Permit', 'valid_from' => $vehicle->national_permit_valid_from, 'valid_till' => $vehicle->national_permit_valid_till],
            'tax_document' => ['label' => '💰 Tax Document', 'valid_from' => $vehicle->tax_valid_from, 'valid_till' => $vehicle->tax_valid_till],
        ];
    @endphp

    @foreach($documents as $field => $doc)
        @if(!empty($vehicle->$field))
            <div class="document-section">
                <p><strong>{{ $doc['label'] }}:</strong></p>
                <!-- <img src="{{ asset('storage/' . $vehicle->$field) }}" alt="{{ $doc['label'] }}" style="max-width: 100%; height: auto; margin-bottom: 10px;"> -->
                <p><strong>Valid From:</strong> {{ $doc['valid_from'] ? \Carbon\Carbon::parse($doc['valid_from'])->format('d-m-Y') : 'N/A' }}</p>
                <p><strong>Valid Till:</strong> {{ $doc['valid_till'] ? \Carbon\Carbon::parse($doc['valid_till'])->format('d-m-Y') : 'N/A' }}</p>
            </div>
            <hr>
        @endif
    @endforeach
</div>

                
            </div>
        </div>
    </div>
</div>

                    
</div>
</div>
@endsection