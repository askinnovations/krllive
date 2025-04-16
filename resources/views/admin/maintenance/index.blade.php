@extends('admin.layouts.app')
@section('title', ' Maintenance | KRL')
@section('content')
  <div class="page-content">
    <div class="container-fluid">

    <!-- start page title -->
    <div class="row">
      <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0 font-size-18">Maintenance</h4>
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
          <li class="breadcrumb-item active">Maintenance</li>
        </ol>
        </div>

      </div>
      </div>
    </div>
    <!-- end page title -->


    <!-- Maintenance Listing Page -->
    <div class="row listing-form">
      <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h4 class="card-title">🛠️ Maintenance Listing</h4>
          <p class="card-title-desc">
          View, edit, or delete maintenance records below. This table supports search,
          sorting, and pagination via DataTables.
          </p>
        </div>
        <button class="btn" id="addMaintenanceBtn" style="background-color: #ca2639; color: white; border: none;"
          data-bs-toggle="modal" data-bs-target="#addMaintenanceModal">
          <i class="fas fa-plus"></i> Add Maintenance
        </button>
        </div>
        <div class="card-body">
        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
          <thead>

          <tr>
            <th>S.No</th>
            <th>Vehicle</th>
            <th>Category</th>
            <th>Vendor</th>
            <th>Odometer Reading</th>
            <th>Autoparts</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>

          @foreach ($maintenances as $maintenance)
        <tr>
        <td> {{ $loop->iteration  }}</td>
        <td> {{ $maintenance->vehicle }}</td>
        <td> {{ $maintenance->category }}</td>
        <td> {{ $maintenance->vendor}}</td>
        <td>{{ $maintenance->odometer_reading }}</td>

        <td>
        <ul>
          @foreach ($maintenance->autoparts as $part)
        <li>
          
           
                <label class="fw-bold">Name:</label> {{ $part['name'] }}
           
           
                <label class="fw-bold">ID:</label> {{ $part['id'] }}
           
            
                <label class="fw-bold">Quantity:</label> {{ $part['quantity'] }}
           
        
        
        {{-- Name: - {{ $part['name'] }} ID:- {{ $part['id'] }}   Quantity:- {{ $part['quantity'] }} --}}
        </li>

      @endforeach
        </ul>
        </td>
        <td>
        <button class="btn btn-sm btn-light view-btn" data-id="{{ $maintenance->id }}"
          data-vehicle="{{ $maintenance->vehicle }}" data-category="{{ $maintenance->category }}"
          data-vendor="{{ $maintenance->vendor}}"
          data-odometer_reading="{{ $maintenance->odometer_reading }}"
          data-autoparts='@json($maintenance->autoparts)'>
          <i class="fas fa-eye text-primary"></i>
        </button>
        <button class="btn btn-sm btn-light edit-btn" data-bs-toggle="modal"
          data-bs-target="#updateMaintenanceModal" data-id="{{ $maintenance->id }}"
          data-vehicle="{{ $maintenance->vehicle }}" data-category="{{ $maintenance->category }}"
          data-vendor="{{ $maintenance->vendor}}"
          data-odometer_reading="{{ $maintenance->odometer_reading }}"
          data-autoparts='@json($maintenance->autoparts)'>
          <i class="fas fa-pen text-warning"></i>
        </button>

        <button class="btn btn-sm btn-light delete-btn"><A
          href="{{ route('admin.maintenance.delete', $maintenance->id) }}"  onclick="return confirm('Are you sure you want to delete this maintenance record?')">
          <i class="fas fa-trash text-danger"></i></a>
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

    <!-- Add Maintenance Modal -->
    <div id="addMaintenanceModal" class="modal fade" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">➕ Add Maintenance</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="{{ route('admin.maintenance.store') }}" method="POST">
          @csrf
          <div class="row">
          <!-- Vehicle -->
          <div class="col-md-6 mb-3">
            <label class="form-label">🚗 Vehicle</label>
            <select class="form-control" id="addVehicle" name="vehicle" required>
              <option value="">Select Vehicle</option>
              @foreach($vehicleTypes as $vehicle)
             <option value="{{ $vehicle->vehicle_type }}">{{ ucfirst($vehicle->vehicle_type) }}</option>
            @endforeach
          </select>
            @error('vehicle')
        <small class="text-danger">{{ $message }}</small>
      @enderror
          </div>

          <!-- Category -->
          <div class="col-md-6 mb-3">
            <label class="form-label">📌 Category</label>
            <select class="form-control" id="addCategory" name="category" required>
            <option value="">Select Category</option>
            <option value="routine_check">Routine Check</option>
            <option value="major_repair">Major Repair</option>
            </select>
            @error('category')
        <small class="text-danger">{{ $message }}</small>
      @enderror
          </div>

          <!-- Vendor -->
          <div class="col-md-6 mb-3">
            <label class="form-label">🏢 Vendor</label>
            <select class="form-control" id="addVendor" name="vendor" required>
            <option value="">Select Vendor</option>
            <option value="service_center">Service Center</option>
            <option value="mechanic">Mechanic</option>
            </select>
            @error('vendor')
        <small class="text-danger">{{ $message }}</small>
      @enderror
          </div>

          <!-- Odometer Reading -->
          <div class="col-md-6 mb-3">
            <label class="form-label">📏 Odometer Reading</label>
            <input type="number" class="form-control" id="addOdometer" name="odometer_reading" required>
            @error('odometer_reading')
        <small class="text-danger">{{ $message }}</small>
      @enderror
          </div>

          <!-- Autoparts -->
          <div class="col-md-12 mb-3">
            <label class="form-label">🔩 Autoparts</label>
            <div id="autopartsContainer">
            <div class="row mb-2 autopart-item">
              <div class="col-md-4">
              <input type="text" class="form-control" name="autoparts[0][name]" placeholder="Part Name">
              @error('autoparts.0.name')
          <small class="text-danger">{{ $message }}</small>
        @enderror
              </div>
              <div class="col-md-4">
              <input type="text" class="form-control" name="autoparts[0][id]" placeholder="Part ID">
              @error('autoparts.0.id')
          <small class="text-danger">{{ $message }}</small>
        @enderror
              </div>
              <div class="col-md-4">
              <input type="number" class="form-control" name="autoparts[0][quantity]" placeholder="Quantity">
              @error('autoparts.0.quantity')
          <small class="text-danger">{{ $message }}</small>
        @enderror
              </div>
            </div>
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" id="addAutopartBtn">Add Another
            Part</button>
          </div>
          </div>

          <div class="text-end">
          <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>

        </div>
      </div>
      </div>
    </div>

    {{-- update maintenance model --}}
    <div id="updateMaintenanceModal" class="modal fade" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">➕ Edit Maintenance</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
       
        <form id="updateMaintenanceForm" method="POST">
          <input type="hidden" id="editId" name="id">
          @csrf
          @method('PUT')

          <div class="row">
          <!-- Vehicle -->
          <div class="col-md-6 mb-3">
            <label class="form-label">🚗 Vehicle</label>
            <select class="form-control" id="editVehicle" name="vehicle" required>
              <option value="">Select Vehicle</option>
              @foreach($vehicleTypes as $vehicle)
             <option value="{{ $vehicle->vehicle_type }}">{{ ucfirst($vehicle->vehicle_type) }}</option>
            @endforeach
            </select>
            @error('vehicle')
        <small class="text-danger">{{ $message }}</small>
      @enderror
          </div>

          <!-- Category -->
          <div class="col-md-6 mb-3">
            <label class="form-label">📌 Category</label>
            <select class="form-control" id="editCategory" name="category" required>
            <option value="">Select Category</option>
            <option value="routine_check">Routine Check</option>
            <option value="major_repair">Major Repair</option>
            </select>
            @error('category')
        <small class="text-danger">{{ $message }}</small>
      @enderror
          </div>

          <!-- Vendor -->
          <div class="col-md-6 mb-3">
            <label class="form-label">🏢 Vendor</label>
            <select class="form-control" id="editVendor" name="vendor" required>
            <option value="">Select Vendor</option>
            <option value="service_center">Service Center</option>
            <option value="mechanic">Mechanic</option>
            </select>
            @error('vendor')
        <small class="text-danger">{{ $message }}</small>
      @enderror
          </div>

          <!-- Odometer Reading -->
          <div class="col-md-6 mb-3">
            <label class="form-label">📏 Odometer Reading</label>
            <input type="number" class="form-control" id="editOdometer" name="odometer_reading" required>
            @error('odometer_reading')
        <small class="text-danger">{{ $message }}</small>
      @enderror
          </div>

          <!-- Autoparts -->
          <div class="col-md-12 mb-3">
            <label class="form-label">🔩 Autoparts</label>
            <div id="editautopartsContainer">
            <div class="row mb-2 autopart-item">
              <div class="col-md-4">
              <input type="text" class="form-control" name="autoparts[0][name]" placeholder="Part Name">
              @error('autoparts.0.name')
          <small class="text-danger">{{ $message }}</small>
        @enderror
              </div>
              <div class="col-md-4">
              <input type="text" class="form-control" name="autoparts[0][id]" placeholder="Part ID">
              @error('autoparts.0.id')
          <small class="text-danger">{{ $message }}</small>
        @enderror
              </div>
              <div class="col-md-4">
              <input type="number" class="form-control" name="autoparts[0][quantity]" placeholder="Quantity">
              @error('autoparts.0.quantity')
          <small class="text-danger">{{ $message }}</small>
        @enderror
              </div>
            </div>
            </div>
            <button type="button" class="btn btn-sm btn-secondary mt-2" id="EditAutopartBtn">Add Another
            Part</button>
          </div>
          </div>

          <div class="text-end">
          <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>

        </div>
      </div>
      </div>
    </div>


    <!-- View Maintenance Modal -->
    <div id="viewMaintenanceModal" class="modal fade" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">🔍 View Maintenance Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <p><strong>🚗 Vehicle:</strong> <span id="viewVehicle"></span></p>
        <p><strong>📌 Category:</strong> <span id="viewCategory"></span></p>
        <p><strong>🏢 Vendor:</strong> <span id="viewVendor"></span></p>
        <p><strong>📏 Odometer Reading:</strong> <span id="viewOdometer_reading"></span></p>
        <p><strong>🔩 Autoparts:</strong> <span id="viewAutoparts"></span></p>

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


  <!-- Right Sidebar -->
  <div class="right-bar">
    <div data-simplebar class="h-100">
    <div class="rightbar-title d-flex align-items-center p-3">

      <h5 class="m-0 me-2">Theme Customizer</h5>

      <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
      <i class="mdi mdi-close noti-icon"></i>
      </a>
    </div>


    </div> <!-- end slimscroll-menu-->
  </div>
  <!-- /Right-bar -->

  <!-- Right bar overlay-->
  <div class="rightbar-overlay"></div>

  <script>
    let autopartIndex = 1; // start from 1 since 0 already exists

    document.getElementById('addAutopartBtn').addEventListener('click', function () {
    const container = document.getElementById('autopartsContainer');

    const newRow = document.createElement('div');
    newRow.classList.add('row', 'mb-2', 'autopart-item');

    newRow.innerHTML = `
      <div class="col-md-4">
      <input type="text" class="form-control" name="autoparts[${autopartIndex}][name]" placeholder="Part Name">
      </div>
      <div class="col-md-4">
      <input type="text" class="form-control" name="autoparts[${autopartIndex}][id]" placeholder="Part ID">
      </div>
      <div class="col-md-4">
      <input type="number" class="form-control" name="autoparts[${autopartIndex}][quantity]" placeholder="Quantity">
      </div>
      `;

    container.appendChild(newRow);
    autopartIndex++;
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    let autopartIndex = 1; // Start at 1 since 0 is already used

    const addButton = document.getElementById('EditAutopartBtn');
    const container = document.getElementById('editautopartsContainer');

    addButton.addEventListener('click', function () {
      const newRow = document.createElement('div');
      newRow.classList.add('row', 'mb-2', 'autopart-item');

      newRow.innerHTML = `
      <div class="col-md-4">
        <input type="text" class="form-control" name="autoparts[${autopartIndex}][name]" placeholder="Part Name">
      </div>
      <div class="col-md-4">
        <input type="text" class="form-control" name="autoparts[${autopartIndex}][id]" placeholder="Part ID">
      </div>
      <div class="col-md-4">
        <input type="number" class="form-control" name="autoparts[${autopartIndex}][quantity]" placeholder="Quantity">
      </div>
      `;

      container.appendChild(newRow);
      autopartIndex++;
    });
    });
  </script>


  <script>
    document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("addMaintenanceForm").addEventListener("submit", function (event) {
      event.preventDefault(); // Prevent default form submission

      let vehicle = document.getElementById("addVehicle").value;
      let category = document.getElementById("addCategory").value;
      let vendor = document.getElementById("addVendor").value;
      let odometer = document.getElementById("addOdometer").value;

      // Validate Form Fields
      if (!vehicle || !category || !vendor || !odometer) {
      alert("Please fill all required fields.");
      return;
      }

      let autoparts = Array.from(document.querySelectorAll(".autopart-item")).map(item => {
      let partName = item.querySelector(".part-name").value;
      let partId = item.querySelector(".part-id").value;
      let quantity = item.querySelector(".part-quantity").value;
      return `${partName} (${partId}) x${quantity}`;
      }).join(", ");

      let tbody = document.querySelector("#datatable tbody");
      let id = tbody.rows.length + 1;

      let row = document.createElement("tr");
      row.innerHTML = `
        `;

      tbody.appendChild(row);

      // Reset form fields
      document.getElementById("addMaintenanceForm").reset();
      document.getElementById("updateMaintenanceModal").reset();

      // Close modal after adding
      let modal = new bootstrap.Modal(document.getElementById("addMaintenanceModal"));
      modal.hide();
      let modal = new bootstrap.Modal(document.getElementById("updateMaintenanceModal"));
      modal.hide();
    });


    });
  </script>


  <!-- Table HTML remains same -->




  <!-- JavaScript Code -->


  <!-- Apna code sabse last -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.view-btn');
      if (!btn) return;

      let autopartsArray = [];
      try {
      autopartsArray = JSON.parse(btn.dataset.autoparts || '[]');
      } catch (err) {
      console.error("Autoparts JSON parse error:", err);
      }

      const maintenanceData = {
      id: btn.dataset.id,
      vehicle: btn.dataset.vehicle,
      category: btn.dataset.category,
      vendor: btn.dataset.vendor,
      odometer_reading: btn.dataset.odometer_reading,
      autoparts: autopartsArray
      };

      $('#viewId').text(maintenanceData.id);
      $('#viewVehicle').text(maintenanceData.vehicle);
      $('#viewCategory').text(maintenanceData.category);
      $('#viewVendor').text(maintenanceData.vendor);
      $('#viewOdometer_reading').text(maintenanceData.odometer_reading);

      if (maintenanceData.autoparts.length === 0) {
      $('#viewAutoparts').html("<em>No autoparts used.</em>");
      } else {
      let autopartsHtml = "<ul>";
      maintenanceData.autoparts.forEach(part => {
        autopartsHtml += `<li>Name: ${part.name} (ID: ${part.id}) - Quantity: ${part.quantity}</li>`;
      });
      autopartsHtml += "</ul>";
      $('#viewAutoparts').html(maintenanceData.autoparts.length ? autopartsHtml : "<em>No autoparts used.</em>");
      }
      $('#viewMaintenanceModal').modal('show');
    });
    });
  </script>
  <script>
    document.addEventListener('click', function (e) {
    const btn = e.target.closest('.edit-btn'); // safe in case <i> tag clicked
    if (btn) {
      const data = {
      id: btn.dataset.id,
      vehicle: btn.dataset.vehicle,
      category: btn.dataset.category,
      vendor: btn.dataset.vendor,
      odometer_reading: btn.dataset.odometer_reading,
      autoparts: JSON.parse(btn.dataset.autoparts || '[]')
      };

      let form = document.getElementById('updateMaintenanceForm');
      form.action = `/admin/maintenance/update/${data.id}`;

      // Set basic input values
      document.getElementById('editId').value = data.id;
      document.getElementById('editVehicle').value = data.vehicle;
      document.getElementById('editCategory').value = data.category;
      document.getElementById('editVendor').value = data.vendor;
      document.getElementById('editOdometer').value = data.odometer_reading;

      // Clear previous autoparts
      const container = document.getElementById('editautopartsContainer');
      container.innerHTML = '';
      let autopartIndex = 0;

      // Function to create autopart row
      function createAutopartRow(part = {}, index = 0) {
      return `
        <div class="row mb-2 autopart-item">
        <div class="col-md-4">
          <input type="text" class="form-control" name="autoparts[${index}][name]" placeholder="Part Name" value="${part.name || ''}" id="editPartName${index}">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control" name="autoparts[${index}][id]" placeholder="Part ID" value="${part.id || ''}" id="editPartId${index}">
        </div>
        <div class="col-md-3">
          <input type="number" class="form-control" name="autoparts[${index}][quantity]" placeholder="Quantity" value="${part.quantity || ''}" id="editQuantity${index}">
        </div>
        <div class="col-md-1 d-flex align-items-center">
          <button type="button" class="btn btn-sm btn-danger remove-autopart">&times;</button>
        </div>
        </div>
      `;
      }

      // Add all parts
      data.autoparts.forEach((part, index) => {
      container.insertAdjacentHTML('beforeend', createAutopartRow(part, index));
      });
     
    }
    
    });
  </script>
 


@endsection