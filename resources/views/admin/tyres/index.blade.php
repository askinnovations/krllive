@extends('admin.layouts.app')
@section('title', 'Tyres | KRL')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Tyres</h4>
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
                                <li class="breadcrumb-item active">Tyres</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <!-- Tyre Listing Page -->
            <div class="row listing-form">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>

                                <h4 class="card-title">🛞 Tyre Listing</h4>
                                <p class="card-title-desc">
                                    View, edit, or delete tyre details below. This table supports search,
                                    sorting, and pagination via DataTables.
                                </p>
                            </div>
                            @if (hasAdminPermission('create tyres'))
                            <button class="btn" id="addTyreBtn"
                                style="background-color: #ca2639; color: white; border: none;">
                                <i class="fas fa-plus"></i> Add Tyre
                            </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <table id=""  class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr >
                                        <th>S.No</th>
                                        <th>Company</th>
                                        <th>Make & Model</th>
                                        <th>Tyre Number</th>
                                        <th>Description</th>
                                        <th>Format</th>
                                        <th>Health Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($tyres as $tyre)
                                        <tr>
                                            <td>{{ $loop->iteration  }}</td>
                                            <td>{{ $tyre->company }}</td>
                                            <td>{{ $tyre->make_model }}</td>
                                            <td>{{ $tyre->tyre_number }}</td>
                                            <td>{{ $tyre->description }}</td>
                                            <td>{{ $tyre->format }}</td>

                                            <td><span class="badge bg-success">{{ $tyre->tyre_health }}</span></td>
                                            <td>
                                                @if (hasAdminPermission('view tyres'))
                                                <button class="btn btn-sm btn-light view-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewTyreModal"
                                                    data-company="{{ $tyre->company }}"
                                                    data-model="{{ $tyre->make_model }}"
                                                    data-description="{{ $tyre->description }}"
                                                    data-format="{{ $tyre->format }}"
                                                    data-tyre_number="{{ $tyre->tyre_number }}"
                                                    data-health="{{ $tyre->tyre_health }}"
                                                    onclick="viewTyreData(this)">
                                                    <i class="fas fa-eye text-primary"></i>
                                                </button>
                                                @endif
                                                @if (hasAdminPermission('edit tyres'))
                                                <button class="btn btn-sm btn-light edit-btn"
                                                    data-id="{{ $tyre->id }}"
                                                    data-company="{{ $tyre->company }}"
                                                    data-make_model="{{ $tyre->make_model }}"
                                                    data-description="{{ $tyre->description }}"
                                                    data-format="{{ $tyre->format }}"
                                                    data-tyre_number="{{ $tyre->tyre_number }}"
                                                    data-tyre_health="{{ $tyre->tyre_health }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#updateTyreModal">
                                                    <i class="fas fa-pen text-warning"></i>
                                                </button>
                                                @endif
                                                @if (hasAdminPermission('delete tyres'))
                                                <button class="btn btn-sm btn-light delete-btn"><a
                                                        href="{{ route('admin.tyres.delete', $tyre->id) }}"  onclick="return confirm('Are you sure you want to delete this tyre record?')"> <i
                                                            class="fas fa-trash text-danger"></i>
                                                    </a>
                                                </button>
                                                @endif
                                                

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                           
                        </div>
                    </div>
                </div>
            </div>
            {{-- view model --}}
            <div class="modal fade" id="viewTyreModal" tabindex="-1" aria-labelledby="viewTyreModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewTyreModalLabel">Tyre Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>🏢 Company:</strong> <span id="viewCompany"></span></p>
                            <p><strong>🔩 Make & Model:</strong> <span id="viewModel"></span></p>
                            <p><strong>📄 Description:</strong> <span id="viewDescription"></span></p>
                            <p><strong>📏 Format:</strong> <span id="viewFormat"></span></p>
                            <p><strong>🆔 Tyre Number:</strong> <span id="viewTyreNumber"></span></p>
                            <p><strong>📊 Health Status:</strong> <span id="viewHealth"></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Tyre Modal -->
            <div class="modal fade" id="addTyreModal" tabindex="-1" aria-labelledby="addTyreModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addTyreModalLabel">🛞 Add Tyre</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                              <form action="{{ route('admin.tyres.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">🏢 Company</label>
                                        <input type="text" class="form-control" id="inputCompany"
                                            placeholder="Enter tyre company" name="company" required>
                                        @error('company')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">🔩 Make & Model</label>
                                        <input type="text" class="form-control" id="inputModel"
                                            placeholder="Enter make & model" name="make_model" required>
                                        @error('make_model')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">📄 Tyre Description</label>
                                        <input type="text" class="form-control" id="inputDescription"
                                            placeholder="Enter description" name="description" required>
                                        @error('description')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">📏 Format</label>
                                        <input type="text" class="form-control" id="inputFormat" placeholder="Enter format"
                                            name="format" required>
                                        @error('format')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">🆔 Tyre Number</label>
                                        <input type="text" class="form-control" id="inputTyreNumber"
                                            placeholder="Enter tyre number" name="tyre_number" required>
                                        @error('tyre_number')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">📊 Tyre Health</label>
                                        <select class="form-control" id="inputHealth" name="tyre_health">
                                            <option value="">Select health status</option>
                                            <option value="new">New</option>
                                            <option value="good">Good</option>
                                            <option value="worn_out">Worn Out</option>
                                            <option value="needs_replacement">Needs Replacement</option>
                                        </select>
                                        @error('tyre_health')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Add
                                        Tyre</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- //update tyre model --}}
            <div class="modal fade" id="updateTyreModal" tabindex="-1" aria-labelledby="updateTyreModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
            
                        <div class="modal-header">
                            <h5 class="modal-title">🛞 Edit Tyre</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
            
                        <div class="modal-body">
                            <form id="editForm"  method="post" action="">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <input type="hidden"  id="editid">
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">🏢 Company</label>
                                        <input type="text" class="form-control" placeholder="Enter tyre company"
                                            id="editCompany" name="company" required>
                                        @error('company')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">🔩 Make & Model</label>
                                        <input type="text" class="form-control" placeholder="Enter make & model" 
                                            id="editModel" name="make_model" required>
                                        @error('make_model')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">📄 Tyre Description</label>
                                        <input type="text" class="form-control" placeholder="Enter description"
                                            id="editDescription" name="description" required>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">📏 Format</label>
                                        <input type="text" class="form-control" placeholder="Enter format" id="editFormat"
                                            name="format" required>
                                        @error('format')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">🆔 Tyre Number</label>
                                        <input type="text" class="form-control" placeholder="Enter tyre number"
                                            id="editTyreNumber" name="tyre_number" required>
                                        @error('tyre_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">📊 Tyre Health</label>
                                        <select class="form-control" id="editHealth" name="tyre_health">
                                            <option value="">Select health status</option>
                                            <option value="new">New</option>
                                            <option value="good">Good</option>
                                            <option value="worn_out">Worn Out</option>
                                            <option value="needs_replacement">Needs Replacement</option>
                                        </select>
                                        @error('tyre_health')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Update Tyre</button>
                                    
                                </div>
                            </form>
                        </div>
            
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="updateTyreModal" tabindex="-1" aria-labelledby="updateTyreModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
              
                    <div class="modal-header">
                      <h5 class="modal-title">🛞 Update Tyre</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
              
                    <div class="modal-body">
                        <p><strong>🏢 Company:</strong> <span id="viewCompany"></span></p>
                        <p><strong>🔩 Make & Model:</strong> <span id="viewModel"></span></p>
                        <p><strong>📄 Description:</strong> <span id="viewDescription"></span></p>
                        <p><strong>📏 Format:</strong> <span id="viewFormat"></span></p>
                        <p><strong>🆔 Tyre Number:</strong> <span id="viewTyreNumber"></span></p>
                        <p><strong>📊 Health Status:</strong> <span id="viewHealth"></span></p>
                    </div>
              
                  </div>
                </div>
              </div>
        </div>
    </div>
    <!-- end main content-->

    </div>
   
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Event delegation from document since child rows are dynamically inserted
            document.addEventListener('click', function (e) {
                // Check if the clicked element or its parent has class 'edit-btn'
                const btn = e.target.closest('.edit-btn');
                if (!btn) return;
     
                const tyreData = {
                    id: btn.dataset.id,
                    company: btn.dataset.company,
                    make_model: btn.dataset.make_model,
                    description: btn.dataset.description,
                    format: btn.dataset.format,
                    tyre_number: btn.dataset.tyre_number,
                    tyre_health: btn.dataset.tyre_health
                };
    
                // console.log("Clicked row data:", tyreData);
    
                // Fill modal fields
                $('#editid').val(tyreData.id);
                $('#editCompany').val(tyreData.company);
                $('#editModel').val(tyreData.make_model);
                $('#editDescription').val(tyreData.description);
                $('#editFormat').val(tyreData.format);
                $('#editTyreNumber').val(tyreData.tyre_number);
                $('#editHealth').val(tyreData.tyre_health.toLowerCase()); 

                let form = document.getElementById('editForm');
                form.action = `/admin/tyres/update/${tyreData.id}`;
                // Show modal
                $('#updateTyreModal').modal('show');
            });
        });
    </script>
   
               <!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Apna custom jQuery script -->
<script>
    function viewTyreData(button) {
      document.getElementById("viewCompany").textContent = button.dataset.company;
      document.getElementById("viewModel").textContent = button.dataset.model;
      document.getElementById("viewDescription").textContent = button.dataset.description;
      document.getElementById("viewFormat").textContent = button.dataset.format;
      document.getElementById("viewTyreNumber").textContent = button.dataset.tyre_number;
      document.getElementById("viewHealth").textContent = button.dataset.health;
    }
  </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function getHealthBadgeClass(health) {
                switch (health) {
                    case "New":
                        return "bg-success text-white"; // Green
                    case "Good":
                        return "bg-primary text-white"; // Blue
                    case "Worn Out":
                        return "bg-warning text-dark"; // Yellow
                    case "Needs Replacement":
                        return "bg-danger text-white"; // Red
                    default:
                        return "bg-secondary text-white"; // Gray (default)
                }
            }
            // Attach existing buttons on page load
            document.querySelectorAll(".view-btn").forEach(attachViewEvent);
            document.querySelectorAll(".delete-btn").forEach(attachDeleteEvent);
        });
           
       
    </script>
    {{-- open model add and update --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("addTyreBtn").addEventListener("click", function () {
            var addTyreModal = new bootstrap.Modal(document.getElementById("addTyreModal"));
            addTyreModal.show();
        });
        document.getElementById("updateTyreBtn").addEventListener("click", function () {
                var updateTyreBtnTyreModal = new bootstrap.Modal(document.getElementById("updateTyreModal"));
                updateTyreModal.show();
            });  
    });
</script>

@endsection