@extends('admin.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
                    <div class="row add form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4>🚛 Vehicle Details</h4>
                                        <p>Enter the required details for the vehicle.</p>
                                    </div>
                                    <a  href="{{ route('admin.vehicles.index') }}" class="btn" id="backToListBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        ⬅ Back to Listing
                                    </a>
                                </div>
                                <form action="{{ route('admin.vehicles.update', ['id' => $vehicle->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label">Vehicle Type</label>
                                            <input type="text" name="vehicle_type" class="form-control" value="{{ old('vehicle_type', $vehicle->vehicle_type) }}" placeholder="Enter vehicle type" required>
                                            @error('vehicle_type')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">GVW</label>
                                            <input type="text" name="gvw" class="form-control" value="{{ old('gvw', $vehicle->gvw) }}" placeholder="Enter GVW" required>
                                            @error('gvw')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Payload</label>
                                            <input type="text" name="payload" class="form-control" value="{{ old('payload', $vehicle->payload) }}" placeholder="Enter payload" required>
                                            @error('payload')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label">Vehicle No</label>
                                            <input type="text" name="vehicle_no" class="form-control" value="{{ old('vehicle_no', $vehicle->vehicle_no) }}" placeholder="Enter vehicle number" required>
                                            @error('vehicle_no')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Chassis Number</label>
                                            <input type="text" name="chassis_number" class="form-control" value="{{ old('chassis_number', $vehicle->chassis_number) }}" placeholder="Enter chassis number" required>
                                            @error('chassis_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Engine Number</label>
                                            <input type="text" name="engine_number" class="form-control" value="{{ old('engine_number', $vehicle->engine_number) }}" placeholder="Enter engine number" required>
                                            @error('engine_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label">Registered Mobile Number</label>
                                            <input type="text" name="registered_mobile_number" class="form-control" value="{{ old('registered_mobile_number', $vehicle->registered_mobile_number) }}" placeholder="Enter mobile number" required>
                                            @error('registered_mobile_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Number of Tyres</label>
                                            <input type="text" name="number_of_tyres" class="form-control" value="{{ old('number_of_tyres', $vehicle->number_of_tyres) }}" placeholder="Enter number of tyres" required>
                                            @error('number_of_tyres')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>

                                    <div class="accordion mt-4" id="documentAccordion">
                                        <!-- RC Document -->
                                         <div class="mb-3">
                                            <h5>Documents Upload</h5>
                                         </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#rcDocument">
                                                    📄 RC Document
                                                </button>
                                            </h2>
                                            <div id="rcDocument" class="accordion-collapse collapse show">
                                                <div class="accordion-body row g-3">
                                               <div class="col-md-4">
                                                    <label class="form-label">Upload Document</label>
                                                    <input type="file" name="rc_document_file" class="form-control">
                                                    @if($vehicle->rc_document_file)
                                                    <button type="button" 
                                                    class="btn  openImageModal"
                                                    data-image="{{ asset('storage/' . $vehicle->rc_document_file) }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#imageModal">
                                                   <p  class="text-info"> View Current Document</p>
                                                </button>
                                                @endif
                                                </div> 
                                                <div class="col-md-4">
                                                    <label class="form-label">Valid From</label>
                                                    <input type="date" name="rc_valid_from" class="form-control" value="{{ old('rc_valid_from', $vehicle->rc_valid_from) }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Valid Till</label>
                                                    <input type="date" name="rc_valid_till" class="form-control" value="{{ old('rc_valid_till', $vehicle->rc_valid_till) }}">
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                       

                                        <!-- Fitness Document -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#fitnessDocument">
                                                    📄 Fitness Certificate
                                                </button>
                                            </h2>
                                            <div id="fitnessDocument" class="accordion-collapse collapse">
                                                <div class="accordion-body" id="fitnessContainer">
                                                    <div class="row g-3">
                                                            <div class="col-md-6">
                                                            <label class="form-label">Upload Document</label>
                                                            <input type="file" name="fitness_certificate" class="form-control">
                                                            @if($vehicle->fitness_certificate)
                                                            <button type="button" 
                                                            class="btn  openImageModal"
                                                            data-image="{{ asset('storage/' .$vehicle->fitness_certificate) }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#imageModal">
                                                           <p  class="text-info"> View Current Document</p>
                                                        </button>
                                                               
                                                            @endif
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <label class="form-label">Valid From</label>
                                                            <input type="date" name="fitness_valid_till" class="form-control" value="{{ old('fitness_valid_till', $vehicle->fitness_valid_till) }}">
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Insurance Document -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#insuranceDocument">
                                                    📄 Insurance
                                                </button>
                                            </h2>
                                            <div id="insuranceDocument" class="accordion-collapse collapse">
                                                <div class="accordion-body" id="insuranceContainer">
                                                    <div class="row g-3">
                                                     <div class="col-md-4">
                                                    <label class="form-label">Upload Document</label>
                                                    <input type="file" name="insurance_document" class="form-control">
                                                    @if($vehicle->insurance_document)
                                                    <button type="button" 
                                                    class="btn  openImageModal"
                                                    data-image="{{ asset('storage/' . $vehicle->insurance_document) }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#imageModal">
                                                   <p  class="text-info"> View Current Document</p>
                                                </button>
                                                       
                                                    @endif
                                                   </div> 
                                                <div class="col-md-4">
                                                    <label class="form-label">Valid From</label>
                                                    <input type="date" name="insurance_valid_from" class="form-control" value="{{ old('insurance_valid_from', $vehicle->insurance_valid_from) }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Valid Till</label>
                                                    <input type="date" name="insurance_valid_till" class="form-control" value="{{ old('insurance_valid_till', $vehicle->insurance_valid_till) }}">
                                                </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Authorization Permit -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#authPermit">
                                                    📄 Authorization Permit
                                                </button>
                                            </h2>
                                            <div id="authPermit" class="accordion-collapse collapse">
                                                <div class="accordion-body" id="authPermitContainer">
                                                    <div class="row g-3">
                                                    <div class="col-md-4">
                                                    <label class="form-label">Upload Document</label>
                                                    <input type="file" name="authorization_permit" class="form-control">
                                                    @if($vehicle->authorization_permit)
                                                    <button type="button" 
                                                    class="btn  openImageModal"
                                                    data-image="{{ asset('storage/' .  $vehicle->authorization_permit) }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#imageModal">
                                                   <p  class="text-info"> View Current Document</p>
                                                </button>
                                                        {{-- <a href="{{ asset('storage/' . $vehicle->authorization_permit) }}" target="_blank">View Current Document</a> --}}
                                                    @endif
                                                   </div> 
                                                <div class="col-md-4">
                                                    <label class="form-label">Valid From</label>
                                                    <input type="date" name="auth_permit_valid_from" class="form-control" value="{{ old('auth_permit_valid_from', $vehicle->auth_permit_valid_from) }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Valid Till</label>
                                                    <input type="date" name="auth_permit_valid_till" class="form-control" value="{{ old('auth_permit_valid_till', $vehicle->auth_permit_valid_till) }}">
                                                </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- National Permit -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#nationalPermit">
                                                    📄 National Permit
                                                </button>
                                            </h2>
                                            <div id="nationalPermit" class="accordion-collapse collapse">
                                                <div class="accordion-body" id="nationalPermitContainer">
                                                    <div class="row g-3">
                                                     <div class="col-md-4">
                                                    <label class="form-label">Upload Document</label>
                                                    <input type="file" name="national_permit" class="form-control">
                                                    @if($vehicle->national_permit)
                                                    <button type="button" 
                                                    class="btn  openImageModal"
                                                    data-image="{{ asset('storage/' . $vehicle->national_permit) }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#imageModal">
                                                   <p  class="text-info"> View Current Document</p>
                                                </button>
                                                    @endif
                                                   </div> 
                                                <div class="col-md-4">
                                                    <label class="form-label">Valid From</label>
                                                    <input type="date" name="national_permit_valid_from" class="form-control" value="{{ old('national_permit_valid_from', $vehicle->national_permit_valid_from) }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Valid Till</label>
                                                    <input type="date" name="national_permit_valid_till" class="form-control" value="{{ old('national_permit_valid_till', $vehicle->national_permit_valid_till) }}">
                                                </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tax -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#nt">
                                                    📄 Tax
                                                </button>
                                            </h2>
                                            <div id="nt" class="accordion-collapse collapse">
                                                <div class="accordion-body" id="nationalPermitContainer">
                                                    <div class="row g-3">
                                                    <div class="col-md-4">
                                                    <label class="form-label">Upload Document</label>
                                                    <input type="file" name="tax_document" class="form-control">
                                                    @if($vehicle->tax_document)
                                                    <button type="button" 
                                                    class="btn  openImageModal"
                                                    data-image="{{ asset('storage/' . $vehicle->tax_document) }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#imageModal">
                                                   <p  class="text-info"> View Current Document</p>
                                                </button>
                                                       
                                                    @endif
                                                   </div> 
                                                <div class="col-md-4">
                                                    <label class="form-label">Valid From</label>
                                                    <input type="date" name="tax_valid_from" class="form-control" value="{{ old('tax_valid_from', $vehicle->tax_valid_from) }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Valid Till</label>
                                                    <input type="date" name="tax_valid_till" class="form-control" value="{{ old('tax_valid_till', $vehicle->tax_valid_till) }}">
                                                </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mt-4">
                                        <div class="col-12 text-end">
                                            <button  type="submit" class="btn btn-primary">Update Vehicle Details</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>  
                    <!-- Image Modal -->
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
</script>
</script>


@endsection