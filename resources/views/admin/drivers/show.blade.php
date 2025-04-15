@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- View Vehicle Details Page -->
            <div class="view-vehicle-form">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4> Driver Details View</h4>
                            <p class="mb-0">View details for the driver.</p>
                        </div>
                        <a href="{{ route('admin.drivers.index') }}" class="btn" id="backToListBtn"
                            style="background-color: #ca2639; color: white; border: none;">
                            ⬅ Back to Listing
                        </a>
                    </div>
                    <div class="card-body">
                        <h4>👨‍✈️ Driver Details</h4>
                        <div class="row mb-2">
                            <div class="col-md-4"><strong>👤 Name:</strong> {{ $driver->first_name }} {{ $driver->last_name }}</div>
                            <div class="col-md-4"><strong>📞 Phone Number:</strong> {{ $driver->phone_number }}</div>
                            <div class="col-md-4"><strong>📱 Emergency Contact:</strong> {{ $driver->emergency_contact_number ?? 'N/A' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4"><strong>🏠 Address:</strong> {{ $driver->address }}</div>
                            <div class="col-md-4"><strong>🌍 State:</strong> {{ $driver->state }}</div>
                            <div class="col-md-4"><strong>📮 Pin Code:</strong> {{ $driver->pin_code ?? 'N/A' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4"><strong>🆔 Aadhaar Number:</strong> {{ $driver->aadhaar_number ?? 'N/A' }}</div>
                            <div class="col-md-4"><strong>🚘 Vehicle Number:</strong> {{ $driver->vehicle_number ?? 'N/A' }}</div>
                            <div class="col-md-4"><strong>📊 Status:</strong>
                                @if($driver->status === 'active')
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Inactive</span>
                                @endif
                            </div>
                        </div>
                    
                        <h6 class="mt-3">📁 Documents</h6>
                        <div class="row">
                            @if($driver->driver_photo)
                                <div class="col-md-4 mb-2">
                                    <button type="button" class="btn btn-outline-info openImageModal w-100"
                                        data-image="{{ asset('storage/' . $driver->driver_photo) }}" data-bs-toggle="modal"
                                        data-bs-target="#imageModal">
                                        🖼️ Driver Photo: View
                                    </button>
                                </div>
                            @endif
                    
                            @if($driver->aadhaar_doc)
                                <div class="col-md-4 mb-2">
                                    <button type="button" class="btn btn-outline-info openImageModal w-100"
                                        data-image="{{ asset('storage/' . $driver->aadhaar_doc) }}" data-bs-toggle="modal"
                                        data-bs-target="#imageModal">
                                        📄 Aadhaar Document: View
                                    </button>
                                </div>
                            @endif
                    
                            @if($driver->license_doc)
                                <div class="col-md-4 mb-2">
                                    <button type="button" class="btn btn-outline-info openImageModal w-100"
                                        data-image="{{ asset('storage/' . $driver->license_doc) }}" data-bs-toggle="modal"
                                        data-bs-target="#imageModal">
                                        📄 License Document: View
                                    </button>
                                </div>
                            @endif
                        </div>
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