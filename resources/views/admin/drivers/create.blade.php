@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row add form">
                    <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4>🚛Add Driver Details</h4>
                                        <p>Enter the  details for the driver.</p>
                                    </div>
                                    <a  href="{{ route('admin.drivers.index') }}" class="btn" id="backToListBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        ⬅ Back to Listing
                                    </a>
                                </div>

                                <form method="POST" action="{{ route('admin.drivers.store') }}" enctype="multipart/form-data" style="padding: 20px;">
                                    @csrf
                                    <div class="row">
                                        {{-- First Name --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">👤 First Name</label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                                name="first_name" value="{{ old('first_name') }}" placeholder="Enter first name" required >
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Last Name --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">👤 Last Name</label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                name="last_name" value="{{ old('last_name') }}" placeholder="Enter last name" required>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Phone Number --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📱 Contact Number</label>
                                            <input type="number" class="form-control @error('phone_number') is-invalid @enderror"
                                                name="phone_number" value="{{ old('phone_number') }}" placeholder="Enter phone number" required>
                                            @error('phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                         {{-- Emergency Contact Number --}}
                                         <div class="col-md-6 mb-3">
                                            <label class="form-label">📞 Emergency Contact Number</label>
                                            <input type="number" class="form-control @error('emergency_contact_number') is-invalid @enderror"
                                                name="emergency_contact_number" value="{{ old('emergency_contact_number') }}" placeholder="Contact number" required>
                                            @error('emergency_contact_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Address --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🏠 Residential Address</label>
                                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                                name="address" value="{{ old('address') }}" placeholder="Enter address" required>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                       
                                        {{-- State --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🗺️ State</label>
                                            <select class="form-select @error('state') is-invalid @enderror" name="state">
                                                <option value="">Select State</option> 
                                                @php
                                                    $states = ['Delhi', 'Maharashtra', 'Uttar Pradesh', 'Karnataka', 'Tamil Nadu', 'Rajasthan', 'Gujarat'];
                                                @endphp
                                                @foreach($states as $state)
                                                    <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                                                @endforeach
                                            </select>
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Pin Code --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📮 Postal Code</label>
                                            <input type="text" class="form-control @error('pin_code') is-invalid @enderror"
                                                name="pin_code" value="{{ old('pin_code') }}" placeholder="Enter postal code" required>
                                            @error('pin_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Aadhaar Number --}}
                                        {{-- <div class="col-md-6 mb-3">
                                            <label class="form-label">🆔 Aadhaar Number</label>
                                            <input type="number" class="form-control @error('aadhaar_number') is-invalid @enderror"
                                                name="aadhaar_number" value="{{ old('aadhaar_number') }}" placeholder="Enter Aadhaar number" required>
                                            @error('aadhaar_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div> --}}
                                
                                        {{-- Assigned Vehicle --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🚗 Assigned Vehicle Number</label>
                                            <select class="form-select @error('vehicle_number') is-invalid @enderror" name="vehicle_number" required>
                                                <option value="">Select vehicle</option>
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->vehicle_no }}" >
                                                        {{ $vehicle->vehicle_no }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('assigned_vehicle_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Photo Upload --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📸 Driver Photo</label>
                                            <input type="file" class="form-control @error('photo_url') is-invalid @enderror" name="driver_photo" required>
                                            @error('photo_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Aadhaar Upload --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📄 Aadhaar Document</label>
                                            <input type="file" class="form-control @error('aadhaar_doc_url') is-invalid @enderror" name="aadhaar_doc" required>
                                            @error('aadhaar_doc_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- License Upload --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🚦 License Document</label>
                                            <input type="file" class="form-control @error('license_doc_url') is-invalid @enderror" name="license_doc" required>
                                            @error('license_doc_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Status --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">📌 Status</label>
                                            <div class="btn-group" role="group" aria-label="Status">
                                                <input type="radio" class="btn-check" name="status" id="status_active"
                                                    value="active" {{ old('status', 'active') == 'active' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-success" for="status_active">Active</label>
                                
                                                <input type="radio" class="btn-check" name="status" id="status_inactive"
                                                    value="inactive" {{ old('status') == 'inactive' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger" for="status_inactive">Inactive</label>
                                            </div>
                                            @error('status')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Submit --}}
                                        <div class="text-end mt-3">
                                            <button type="submit" class="btn btn-primary">Add Driver</button>
                                        </div>
                                    </div>
                                </form>
                                

                            </div>
                    </div>
            </div>  
        </div>
    </div>

<!-- JavaScript for Add/Remove -->


</script>
@endsection