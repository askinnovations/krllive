@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row add form">
                    <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4>🚛 Edit Driver Details</h4>
                                        <p>Enter the  details for the driver.</p>
                                    </div>
                                    <a  href="{{ route('admin.drivers.index') }}" class="btn" id="backToListBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        ⬅ Back to Listing
                                    </a>
                                </div>
                                <form method="POST" action="{{ route('admin.drivers.update',$driver->id) }}" enctype="multipart/form-data" style="padding: 20px;">
                                    @csrf
                                   
                                
                                    <div class="row">
                                        {{-- First Name --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">👤 First Name</label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                                name="first_name" value="{{ old('first_name', $driver->first_name) }}" placeholder="Enter first name" required>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Last Name --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">👤 Last Name</label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                name="last_name" value="{{ old('last_name', $driver->last_name) }}" placeholder="Enter last name" required>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Phone Number --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📱 Contact Number</label>
                                            <input type="number" class="form-control @error('phone_number') is-invalid @enderror"
                                                name="phone_number" value="{{ old('phone_number', $driver->phone_number) }}" placeholder="Enter contact number" required>
                                            @error('phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Emergency Contact Number --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📞 Emergency Contact Number</label>
                                            <input type="number" class="form-control @error('emergency_contact_number') is-invalid @enderror"
                                                name="emergency_contact_number" value="{{ old('emergency_contact_number', $driver->emergency_contact_number) }}" placeholder="Enter emergency contact number " required>
                                            @error('emergency_contact_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Address --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🏠 Residential Address</label>
                                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                                name="address" value="{{ old('address', $driver->address) }}" placeholder="Enter address " required>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- State --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🗺️ State</label>
                                            @php
                                                $states = ['Delhi', 'Maharashtra', 'Uttar Pradesh', 'Karnataka', 'Tamil Nadu', 'Rajasthan', 'Gujarat'];
                                            @endphp
                                            <select class="form-select @error('state') is-invalid @enderror" name="state" required>
                                                <option value="">Select State</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state }}" {{ old('state', $driver->state) == $state ? 'selected' : '' }}>{{ $state }}</option>
                                                @endforeach
                                            </select>
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Pin Code --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📮 Postal Code</label>
                                            <input type="number" class="form-control @error('pin_code') is-invalid @enderror"
                                                name="pin_code" value="{{ old('pin_code', $driver->pin_code) }}" placeholder="Enter Pin code " required>
                                            @error('pin_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Aadhaar Number
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🆔 Aadhaar Number</label>
                                            <input type="number" class="form-control @error('aadhaar_number') is-invalid @enderror"
                                                name="aadhaar_number" value="{{ old('aadhaar_number', $driver->aadhaar_number) }}" placeholder="Enter aadhar number " required>
                                            @error('aadhaar_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div> --}}
                                
                                        {{-- Vehicle Number --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🚗 Assigned Vehicle Number</label>
                                            <select class="form-select @error('vehicle_number') is-invalid @enderror" name="vehicle_number">
                                                <option value="">Select vehicle</option>
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->vehicle_no }}" {{ old('vehicle_number', $driver->vehicle_number) == $vehicle->vehicle_no ? 'selected' : '' }}>
                                                        {{ $vehicle->vehicle_no }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('vehicle_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Driver Photo --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📸 Driver Photo</label>
                                            <input type="file" class="form-control @error('driver_photo') is-invalid @enderror" name="driver_photo">
                                            @if($driver->driver_photo)
                                         
                                            <button type="button" 
                                            class="btn  openImageModal"
                                            data-image="{{ asset('storage/' . $driver->driver_photo) }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#imageModal">
                                           <p  class="text-info"> View Current Document</p>
                                        </button>
                                        
                                            @endif
                                          
                                            
                                        </div>
                                
                                        {{-- Aadhaar Doc --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📄 Aadhaar Document</label>
                                            <input type="file" class="form-control @error('aadhaar_doc') is-invalid @enderror" name="aadhaar_doc">
                                            @if($driver->aadhaar_doc)
                                            <button type="button" 
                                            class="btn  openImageModal"
                                            data-image="{{ asset('storage/' . $driver->aadhaar_doc) }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#imageModal">
                                           <p  class="text-info"> View Current Document</p>
                                        </button>
                                            @endif
                                           
                                        </div>
                                
                                        {{-- License Doc --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🚦 License Document</label>
                                            <input type="file" class="form-control @error('license_doc') is-invalid @enderror" name="license_doc">
                                            @if($driver->license_doc)
                                            <button type="button" 
                                            class="btn  openImageModal"
                                            data-image="{{ asset('storage/' . $driver->license_doc) }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#imageModal">
                                           <p  class="text-info"> View Current Document</p>
                                        </button>
                                            @endif
                                            
                                           
                                        </div>
                                
                                        {{-- Status --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">📌 Status</label>
                                            <div class="btn-group" role="group" aria-label="Status">
                                                <input type="radio" class="btn-check" name="status" id="status_active"
                                                    value="active" {{ old('status', $driver->status) == 'active' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-success" for="status_active">Active</label>
                                
                                                <input type="radio" class="btn-check" name="status" id="status_inactive"
                                                    value="inactive" {{ old('status', $driver->status) == 'inactive' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger" for="status_inactive">Inactive</label>
                                            </div>
                                            @error('status')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                
                                        {{-- Submit --}}
                                        <div class="text-end mt-3">
                                            <button type="submit" class="btn btn-primary">Update Driver</button>
                                        </div>
                                    </div>
                                </form>
                                

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
        </div>
    </div>

<!-- JavaScript for Add/Remove -->
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