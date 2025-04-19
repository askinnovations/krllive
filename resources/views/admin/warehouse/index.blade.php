

@extends('admin.layouts.app')
@section('title', 'warehouse | KRL')
@section('content')
            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Warehouse</h4>
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
                                        <li class="breadcrumb-item active">Warehouse</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- Warehouse Listing Page -->
                    <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">🏢 Warehouse Listing</h4>
                                        <p class="card-title-desc">
                                            View, edit, or delete warehouse details below.
                                        </p>
                                    </div>
                                    <button class="btn" id="addWarehouseBtn"
                                        style="background-color: #ca2639; color: white; border: none;"
                                        data-bs-toggle="modal" data-bs-target="#addWarehouseModal">
                                        <i class="fas fa-plus"></i> Add Warehouse
                                    </button>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Warhouse ID</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Incharge</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($warehouses as $warehouse)
                            
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>WH##{{$warehouse->id}}</td>
                                                <td>{{$warehouse->warehouse_name}}</td>
                                                <td>{{$warehouse->address}}</td>
                                                <td>{{$warehouse->incharge}}</td>

                                                <td>
                                                   
                                                   <button class="btn btn-sm btn-light view-btn" data-bs-toggle="modal"
                                                        data-bs-target="#viewWarehouseModal">
                                                        <i class="fas fa-eye text-primary"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-light edit-btn edit-warehouse-btn" data-bs-toggle="modal"
                                                        data-bs-target="#editWarehouseModal" data-id="{{ $warehouse->id }}"><i
                                                            class="fas fa-pen text-warning"></i></button>
                                                           
                                                            <button class="btn btn-sm btn-light delete-btn" onclick="return confirm('Are you sure you want to delete this warehouse?') ? window.location.href='{{ route('admin.warehouse.delete', $warehouse->id) }}' : false;">
                                                                <i class="fas fa-trash text-danger"></i>
                                                            </button>
                                                            
                                                </td>
                                            </tr>
                                            @endforeach
                                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- View Warehouse Modal -->
                    <div class="modal fade" id="viewWarehouseModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Warehouse Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>🏭 Name:</strong> <span id="viewwarehouse_name"></span></p>
                                    <p><strong>📍 Address:</strong> <span id="viewaddress"></span></p>
                                    <p><strong>👨‍💼 Incharge:</strong> <span id="incharge"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Warehouse Modal -->
                    <div class="modal fade" id="addWarehouseModal" tabindex="-1"
                        aria-labelledby="addWarehouseModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addWarehouseModalLabel">🏢 Add Warehouse</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.warehouse.store')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">🏭 Warehouse Name</label>
                                                <input type="text" class="form-control" id="inputWarehouseName"
                                                    placeholder="Enter warehouse name" name="warehouse_name" required>
                                                    @error('warehouse_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">📍 Address</label>
                                                <input type="text" class="form-control" id="inputAddress"
                                                    placeholder="Enter address" name="address" required>
                                                    @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">👨‍💼 Incharge</label>
                                                <input type="text" class="form-control" id="inputIncharge"
                                                    placeholder="Enter incharge name" name="incharge"required >
                                                    @error('incharge')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary" >Add
                                                Warehouse</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Warehouse Modal -->
                    <div class="modal fade" id="editWarehouseModal" tabindex="-1"
                        aria-labelledby="editWarehouseModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editWarehouseModalLabel">✏️ Edit Warehouse</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editForm" action="" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">🏭 Warehouse Name</label>
                                                <input type="text" class="form-control" id="editWarehouseName" name="warehouse_name" required>
                                                @error('warehouse_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">📍 Address</label>
                                                <input type="text" class="form-control" id="editAddress" name="address" required>
                                                @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">👨‍💼 Incharge</label>
                                                <input type="text" class="form-control" id="editIncharge" name="incharge" required>
                                                @error('incharge')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary" id="updateWarehouse">Update
                                                Warehouse</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    

    <!-- JAVASCRIPT -->
  
    <script>

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".view-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let row = button.closest("tr");
                  
                    document.getElementById("viewwarehouse_name").textContent = row.cells[1].textContent;
                    document.getElementById("viewaddress").textContent = row.cells[2].textContent;
                    document.getElementById("incharge").textContent = row.cells[3].textContent;
    
                    var viewModal = new bootstrap.Modal(document.getElementById("viewWarehouseModal"));
                    viewModal.show();
                });
            });
        });
        
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".edit-warehouse-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let row = this.closest("tr"); // Get the row of the clicked button
        
                    // Populate modal fields with existing data from the row
                    document.getElementById("editWarehouseName").value = row.cells[1].textContent.trim();
                    document.getElementById("editAddress").value = row.cells[2].textContent.trim();
                    document.getElementById("editIncharge").value = row.cells[3].textContent.trim();
        
                    // Update form action with the correct warehouse ID
                    let form = document.getElementById("editWarehouseForm");
                    form.action = `/admin/warehouses/${this.dataset.id}`;
                });
            });
        });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Select all edit buttons
                document.querySelectorAll('.edit-warehouse-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        // Get the warehouse ID from data-id
                        const warehouseId = this.getAttribute('data-id');
                        
                        // Construct the new action URL
                        const actionUrl = `/admin/warehouse/update/${warehouseId}`;
                        
                        // Set the form action in the modal
                        const editForm = document.querySelector('#editWarehouseModal form');
                        if (editForm) {
                            editForm.action = actionUrl;
                        }
                    });
                });
            });
            </script>
   

    <!-- Datatable init js -->
  
@endsection