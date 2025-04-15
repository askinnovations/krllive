@extends('admin.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        
            
        <!-- start page title -->
        <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Vehicles</h4>
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                              @endif
                          
                                  @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                              @endif
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Vehicles</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
    <!-- Vehicle Listing Page -->
                    <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">🚛 Vehicle Listing</h4>
                                        <p class="card-title-desc">View, edit, or delete vehicle details below.</p>
                                    </div>
                                    <a class="btn"  href="{{ route('admin.vehicles.create') }}"  id="addVehicleBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        <i class="fas fa-plus"></i> Add Vehicle
                                    </a>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Vehicle No</th>
                                                <th>Vehicle Type</th>
                                                <th>GVW</th>
                                                <th>Payload</th>
                                                <th>Registered Mobile Number</th>
                                                <th>Number of Tyres</th>
                                                <th >Action</th>
                                            </tr>
                                        </thead>
                                        @foreach ($vehicles as $index => $vehicle)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $vehicle->vehicle_no }}</td>
                                                <td>{{ $vehicle->vehicle_type }}</td>
                                                <td>{{ $vehicle->gvw }}</td>
                                                <td>{{ $vehicle->payload }}</td>
                                                <td>{{ $vehicle->registered_mobile_number }}</td>
                                                <td>{{ $vehicle->number_of_tyres }}</td>
                                                <td>
                                                    <a href="{{ route('admin.vehicles.view', ['id' => $vehicle->id]) }}" class="btn btn-sm btn-light view-btn"><i class="fas fa-eye text-primary"></i></a>
                                                    <a href="{{ route('admin.vehicles.edit', ['id' => $vehicle->id]) }}" class="btn btn-sm btn-light edit-btn"><i class="fas fa-pen text-warning"></i></a>
                                                    <button class="btn btn-sm btn-light delete-btn"
                                                    data-id="{{ $vehicle->id }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteUserModal">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                                
                                                   
                                                </td>
                                            </tr>
                                        @endforeach
                                      
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                   
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserLabel">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this vehicles?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>

    let deleteId = null;

    // When delete button is clicked
    $(document).on('click', '.delete-btn', function () {
        deleteId = $(this).data('id'); // get the ID and store it
    });

    // When confirm delete is clicked
    $('#confirmDelete').on('click', function () {
        if (deleteId) {
            $.ajax({
                url: '/admin/vehicles/delete/' + deleteId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    // Close modal
                    $('#deleteUserModal').modal('hide');

                   
                    location.reload(); // or remove row from DOM
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    // alert('Error deleting vehicle.');
                }
            });
        }
    });
  
</script>

</script>



@endsection
