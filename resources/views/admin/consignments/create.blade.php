@extends('admin.layouts.app')
@section('title', 'Order | KRL')
@section('content')
<style>
   /* Make Select2 look like Bootstrap input */
   .select2-container .select2-selection--single {
   height: 38px !important; /* match Bootstrap .form-control height */
   padding: 6px 12px;
   }
   .select2-container--default .select2-selection--single .select2-selection__arrow {
   height: 38px !important;
   right: 6px;
   }
</style>
<!-- Order Booking Add Page -->
<div class="row order-booking-form">
<div class="col-12">
<div class="card">
<div class="card-header d-flex justify-content-between align-items-center">
   <div>
      <h4>🛒 Order Details Add</h4>
      <p class="mb-0">Enter the required details for the order.</p>
   </div>
   <a href="{{ route('admin.consignments.index') }}" class="btn" id="backToListBtn"
      style="background-color: #ca2639; color: white; border: none;">
   ⬅ Back to Listing
   </a>
</div>
<!-- LR / Consignment add Form -->
<div class="row add-form">
   <div class="col-12">
      <div class="card">
         <div class="card-header d-flex justify-content-between align-items-center">
            <div>
               <h4>🚚 Add LR / Consignment</h4>
               <p class="mb-0">Fill in the required details for shipment and delivery.</p>
            </div>
            <a href="{{ route('admin.consignments.create') }}" class="btn" id="backToListBtn"
               style="background-color: #ca2639; color: white; border: none;">
            ⬅ Back to Listing
            </a>
         </div>
         <form method="POST" action="{{ route('admin.consignments.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
               <div class="row">
                  <!-- Consignor Details -->
                  <div class="col-md-6">
                     <!-- <div class="mb-3">
                        <label class="form-label">Lr Number</label>
                        <input type="text" name="lr_number"class="form-control"
                            placeholder="Enter lr number" required>
                        </div> -->
                        {{-- @dd($users); --}}
                     <h5>📦 Consignor (Sender)</h5>
                     <select name="consignor_id" id="consignor_id" class="form-select my-select" onchange="setConsignorDetails()" required>
                        <option value="">Select Consignor Name</option>
                        @foreach($users as $user)
                        @php
                            $addresses = json_decode($user->address, true); // decode JSON string to PHP array
                        @endphp
                    
                        @if(!empty($addresses) && is_array($addresses))
                            @foreach($addresses as $address)
                                @php
                                    $formattedAddress = trim(
                                        ($address['billing_address'] ?? '') . ', ' .
                                        ($address['city'] ?? '') . ', ' .
                                        ($address['consignment_address'] ?? '')
                                    );
                                @endphp
                                <option 
                                    value="{{ $user->id }}"
                                    data-gst-consignor="{{ $address['gstin'] ?? '' }}"
                                    data-address-consignor="{{ $formattedAddress }}"
                                    data-mobile="{{ $address['mobile_number'] ?? '' }}"
                                    data-email="{{ $address['email'] ?? '' }}"
                                    data-poc="{{ $address['poc'] ?? '' }}"
                                >
                                    {{ $user->name }} - {{ $address['city'] ?? '' }}
                                </option>
                            @endforeach
                        @endif
                    @endforeach
                    
                    
                     </select>
                     <div class="mb-3">
                        <label class="form-label">Consignor Loading Address</label>
                        <textarea name="consignor_loading" id="consignor_loading" class="form-control" rows="2"
                           placeholder="Enter all addresses" required></textarea>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">Consignor GST</label>
                        <input type="text" name="consignor_gst" id="consignor_gst" class="form-control" placeholder="Enter GST numbers" required>
                     </div>
                     <div class="mb-3 ">
                        <label class="form-label">💰 ORDER AMOUNT</label>
                        <input type="number" name="byOrder" class="form-control" placeholder="Enter Amount" id="byoder">
                     </div>
                  </div>
                  <!-- Consignee Details -->
                  <div class="col-md-6">
                     <div class="mb-3">
                        <label class="form-label">Lr date</label>
                        <input type="date" name="lr_date" class="form-control"
                           placeholder="Enter Lr date">
                     </div>
                     <h5>📦 Consignee (Receiver)</h5>
                     <select name="consignee_id" id="consignee_id" class="form-select my-select" onchange="setConsigneeDetails()" required>
                        <option value="">Select Consignee Name</option>
                    
                        @foreach($users as $user)
                            @php
                                $addresses = json_decode($user->address, true);
                            @endphp
                    
                            @if(!empty($addresses) && is_array($addresses))
                                @foreach($addresses as $address)
                                    @php
                                        $formattedAddress = trim(
                                            ($address['billing_address'] ?? '') . ', ' .
                                            ($address['city'] ?? '') . ', ' .
                                            ($address['consignment_address'] ?? '')
                                        );
                                    @endphp
                                    <option 
                                        value="{{ $user->id }}"
                                        data-gst-consignee="{{ $address['gstin'] ?? '' }}"
                                        data-address-consignee="{{ $formattedAddress }}"
                                        data-mobile="{{ $address['mobile_number'] ?? '' }}"
                                        data-email="{{ $address['email'] ?? '' }}"
                                        data-poc="{{ $address['poc'] ?? '' }}"
                                    >
                                        {{ $user->name }} - {{ $address['city'] ?? '' }}
                                    </option>
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                    
                    <!-- Consignee Unloading Address -->
                    <div class="mb-3">
                        <label class="form-label">Consignee Unloading Address</label>
                        <textarea name="consignee_unloading" id="consignee_unloading" class="form-control" rows="2"
                            placeholder="Enter all addresses" required></textarea>
                    </div>
                    
                    <!-- Consignee GST -->
                    <div class="mb-3">
                        <label class="form-label">Consignee GST</label>
                        <input name="consignee_gst" id="consignee_gst" type="text" class="form-control" placeholder="Enter GST number" required>
                    </div>
                   
                  </div>
               </div>
               <div class="row">
                  <!-- Date -->
                  <div class="col-md-4">
                     <div class="mb-3">
                        <label class="form-label">🚚 Vehicle Number</label>
                        <select name="vehicle_no" id="vehicle_no" class="form-select my-select" required>
                           <option >Select Vehicle NO.</option>
                           @foreach ($vehicles as $vehicle)
                           <option value="{{ $vehicle->vehicle_no }}">
                              {{ $vehicle->vehicle_no }}
                           </option>
                           @endforeach              
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <!-- Vehicle Type -->
                     <div class="mb-3">
                        <label class="form-label">🚛 Vehicle Type</label>
                        <select name="vehicle_type"  class="form-select my-select" required>
                           <option value="">Select Vehicle Type</option>
                           @foreach ($vehiclesType as $type)
                           <option value="{{ $type->id }}">{{ $type->vehicletype }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <!-- Vehicle Ownership -->
                  <div class="col-md-4">
                     <label class="form-label">🛻 Vehicle Ownership</label>
                     <div class="d-flex gap-3">
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="vehicle_ownership" value="Own" checked required>
                           <label class="form-check-label">Own</label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="vehicle_ownership" value="Other" required>
                           <label class="form-check-label">Other</label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <!-- Delivery Mode -->
                  <div class="col-md-4">
                     <div class="mb-3">
                        <label class="form-label">🚢 Delivery Mode</label>
                        <select name="delivery_mode" class="form-select my-select" required>
                           <option selected>Select Mode</option>
                           <option value="door_delivery">Door Delivery</option>
                           <option value="godwon_deliver">Dodwon  Deliver</option>
                        </select>
                     </div>
                  </div>
                  <!-- From Location -->
                  <div class="col-md-4">
                     <div class="mb-3">
                        <label class="form-label">📍 From (Origin)</label>
                        <select name="from_location" class="form-select my-select" required>
                           <option selected>Select Origin</option>
                           @foreach ($destination as $loc)
                           <option value="{{ $loc->id }}">{{ $loc->destination }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <!-- To Location -->
                  <div class="col-md-4">
                     <div class="mb-3">
                        <label class="form-label">📍 To (Destination)</label>
                        <select name="to_location" class="form-select my-select" required>
                           <option selected>Select Destination</option>
                           @foreach ($destination as $loc)
                           <option value="{{ $loc->id }}">{{ $loc->destination }}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
                     <label class="form-label mb-0">🛡️ Insurance?</label>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="insurance_status" value="yes" id="createInsuranceYes" {{ old('insurance_status') == 'yes' ? 'checked' : '' }}>
                        <label class="form-check-label" for="createInsuranceYes">Yes</label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="insurance_status" value="no" id="createInsuranceNo" {{ old('insurance_status', 'no') == 'no' ? 'checked' : '' }}>
                        <label class="form-check-label" for="createInsuranceNo">No</label>
                     </div>
                     <!-- Insurance input field -->
                     <input type="text" class="form-control {{ old('insurance_status') != 'yes' ? 'd-none' : '' }}" 
                        name="insurance_description" 
                        id="insuranceInput" 
                        placeholder="Enter Insurance Number" 
                        style="max-width: 450px;" 
                        value="{{ old('insurance_description') }}">
                  </div>
               </div>
               <!-- Cargo Description Section -->
               <div class="row mt-4">
                  <div class="col-12">
                     <h5 class="mb-3 pb-3">📦 Cargo Description</h5>
                     <div class="mb-3 d-flex gap-3">
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="cargo_description_type" id="singleDoc" value="single" checked required>
                           <label class="form-check-label" for="singleDoc">Single Document</label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="cargo_description_type" id="multipleDoc" value="multiple" required>
                           <label class="form-check-label" for="multipleDoc">Multiple Documents</label>
                        </div>
                     </div>
                     <!-- Cargo Details Table -->
                     <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                           <thead class="">
                              <tr>
                                 <th>No. of Packages</th>
                                 <th>Packaging Type</th>
                                 <th>Description</th>
                                 <th>Actual Weight (kg)</th>
                                 <th>Charged Weight (kg)</th>
                                 <th>Unit</th>
                                 <th>Document No.</th>
                                 <th>Document Name</th>
                                 <th>Document Date</th>
                                 <th>Document Upload</th>
                                 <th>Eway Bill</th>
                                 <th>Valid Upto</th>
                                 <th>Declared value</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody id="cargoTableBody">
                              <tr>
                                 <td><input type="number" name="cargo[0][packages_no]" class="form-control" placeholder="0" required></td>
                                 <td>
                                    <select name="cargo[0][package_type]" class="form-select " required>
                                       <option value="Pallets">Pallets</option>
                                       <option value="Cartons">Cartons</option>
                                       <option value="Bags">Bags</option>
                                    </select>
                                 </td>
                                 <td><input type="text" name="cargo[0][package_description]" class="form-control" placeholder="Enter description" required></td>
                                 <td><input name="cargo[0][actual_weight]" type="number" class="form-control" placeholder="0" required></td>
                                 <td><input name="cargo[0][charged_weight]" type="number" class="form-control" placeholder="0" required></td>
                                 <td>
                                    <select class="form-select " name="cargo[0][unit]" required>
                                       <option value="">Select Unit</option>
                                       <option value="kg">Kg</option>
                                       <option value="ton">Ton</option>
                                    </select>
                                 </td>
                                 <td><input name="cargo[0][document_no]" type="text" class="form-control" placeholder="Doc No." required></td>
                                 <td><input name="cargo[0][document_name]" type="text" class="form-control" placeholder="Doc Name" required></td>
                                 <td><input name="cargo[0][document_date]" type="date" class="form-control" required></td>
                                 <td><input name="cargo[0][document_file]" type="file" class="form-control"></td>
                                 <td><input name="cargo[0][eway_bill]" type="text" class="form-control" placeholder="Eway Bill No." required></td>
                                 <td><input name="cargo[0][valid_upto]" type="date" class="form-control" required></td>
                                 <td><input name="cargo[0][declared_value]" type="number" class="form-control" placeholder="0" required></td>
                                 <td>
                                    <button class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <div class="text-end mt-2">
                        <button type="button" class="btn btn-sm" style="background: #ca2639; color: white;"
                           onclick="addRow()">
                        <span style="filter: invert(1);">➕</span> Add Row</button>
                     </div>
                  </div>
               </div>
               <!-- Freight Details Section -->
               <div class="row mt-4">
                  <div class="col-12">
                     <h5 class=" pb-3">🚚 Freight Details</h5>
                     <div class="mb-3 d-flex gap-3">
                        <div class="form-check form-check-inline">
                           <input class="form-check-input freight-type" type="radio" name="freightType" id="freightPaid" value="paid" onchange="toggleFreightTable()" checked>
                           <label class="form-check-label" for="freightPaid">Paid</label>
                        </div>
                        <div class="form-check form-check-inline">
                           <input class="form-check-input freight-type" type="radio" name="freightType" id="freightToPay" value="to_pay" onchange="toggleFreightTable()">
                           <label class="form-check-label" for="freightToPay">To Pay</label>
                        </div>
                        <div class="form-check form-check-inline">
                           <input class="form-check-input freight-type" type="radio" name="freightType" id="freightToBeBilled" value="to_be_billed" onchange="toggleFreightTable()">
                           <label class="form-check-label" for="freightToBeBilled">To Be Billed</label>
                        </div>
                     </div>
                     <!-- Freight Charges Table -->
                     <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center" id="freight-table">
                           <thead>
                              <tr>
                                 <th>Freight</th>
                                 <th>LR Charges</th>
                                 <th>Hamali</th>
                                 <th>Other Charges</th>
                                 <th>GST</th>
                                 <th>Total Freight</th>
                                 <th>Less Advance</th>
                                 <th>Balance Freight</th>
                              </tr>
                           </thead>
                           <tbody id="freightBody">
                              <tr>
                                 <td>
                                    <input type="number" name="freight_amount" class="form-control freight-amount" placeholder="Enter Freight Amount" readonly>
                                 </td>
                                 <td>
                                    <input type="number" name="lr_charges" class="form-control lr-charges" placeholder="Enter LR " required>
                                 </td>
                                 <td>
                                    <input type="number" name="hamali" class="form-control hamali" placeholder="Enter Hamali " required>
                                 </td>
                                 <td>
                                    <input type="number" name="other_charges" class="form-control other-charges" placeholder="Enter Other " required>
                                 </td>
                                 <td>
                                    <input type="number" name="gst_amount" class="form-control gst" placeholder="Enter GST %" required>
                                 </td>
                                 <td>
                                    <input type="number" name="total_freight" class="form-control total-freight" placeholder="Total Freight" readonly>
                                 </td>
                                 <td>
                                    <input type="number" name="less_advance" class="form-control less-advance" placeholder="Less Advance Amount" required>
                                 </td>
                                 <td>
                                    <input type="number" name="balance_freight" class="form-control balance-freight" placeholder="Balance Freight" readonly>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <!-- Declared Value -->
                  <div class="col-md-6 mt-3">
                     
                        
                        <input type="hidden" id="totalChargedWeight" class="form-control" readonly>
                   
                     <div class="mb-3">
                        <label class="form-label " style="font-weight: bold;">💰Total Declared Value
                        (Rs.)</label>
                        <input type="number" id="totalDeclaredValue" name="total_declared_value" class="form-control"readonly>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <!-- Submit Button -->
                  <div class="row mt-4 mb-4">
                     <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Consignment & LR Details
                        </button>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>

<script>
   function toggleFreightTable() {
       const tbody = document.getElementById('freightBody');
   
       const selectedFreightType = document.querySelector('input[name="freightType"]:checked').value;
   
       if (selectedFreightType === 'to_be_billed') {
           tbody.style.display = 'none';
           const inputs = tbody.querySelectorAll('input');
           inputs.forEach(input => input.removeAttribute('required'));
       } else {
           tbody.style.display = 'table-row-group';
           const inputs = tbody.querySelectorAll('input');
           inputs.forEach(input => input.setAttribute('required', 'required'));
       }
   }
   
   // Auto-call this function on page load (to show/hide based on preselected value)
   document.addEventListener('DOMContentLoaded', function () {
       toggleFreightTable();
   });
</script>
<script>
   const yesRadio = document.getElementById('createInsuranceYes');
   const noRadio = document.getElementById('createInsuranceNo');
   const insuranceInput = document.getElementById('insuranceInput');
   
   function toggleInsuranceField() {
       if (yesRadio.checked) {
           insuranceInput.classList.remove('d-none');
       } else {
           insuranceInput.classList.add('d-none');
           insuranceInput.value = '';
       }
   }
   
   // Run on load
   window.addEventListener('DOMContentLoaded', toggleInsuranceField);
   
   // Run on change
   yesRadio.addEventListener('change', toggleInsuranceField);
   noRadio.addEventListener('change', toggleInsuranceField);
</script>
<script>
   document.getElementById('vehicle_no').addEventListener('change', function () {
       const selectedOption = this.options[this.selectedIndex];
       const type = selectedOption.getAttribute('data-type');
   
       const typeSelect = document.getElementById('vehicle_type');
       for (let i = 0; i < typeSelect.options.length; i++) {
           if (typeSelect.options[i].value === type) {
               typeSelect.selectedIndex = i;
               break;
           }
       }
   });
</script>
<script>
   function calculateTotalDeclaredValue() {
       const declaredValues = document.querySelectorAll('input[name$="[declared_value]"]');
       let total = 0;
   
       declaredValues.forEach(input => {
           total += parseFloat(input.value) || 0;
       });
   
       document.getElementById('totalDeclaredValue').value = total;
   }
   
   function calculateTotalChargedWeight() {
       const chargedWeights = document.querySelectorAll('input[name$="[charged_weight]"]');
       let total = 0;
   
       chargedWeights.forEach(input => {
           total += parseFloat(input.value) || 0;
       });
   
       document.getElementById('totalChargedWeight').value = total;
   }
   
   function addRow() {
       let table = document.getElementById('cargoTableBody');
       let rowCount = table.rows.length;
       let newRow = table.rows[0].cloneNode(true);
   
       const inputs = newRow.querySelectorAll('input, select');
       inputs.forEach(function (input) {
           const name = input.getAttribute('name');
           if (name) {
               const field = name.match(/\[([a-zA-Z_]+)\]/)[1];
               input.setAttribute('name', `cargo[${rowCount}][${field}]`);
               input.value = '';
   
               // Bind input listeners dynamically
               if (field === 'declared_value') {
                   input.addEventListener('input', calculateTotalDeclaredValue);
               }
   
               if (field === 'charged_weight') {
                   input.addEventListener('input', calculateTotalChargedWeight);
               }
           }
       });
   
       table.appendChild(newRow);
       calculateTotalDeclaredValue();
       calculateTotalChargedWeight();
   }
   
   function removeRow(button) {
       let table = document.getElementById('cargoTableBody');
       if (table.rows.length > 1) {
           button.closest('tr').remove();
   
           Array.from(table.rows).forEach((row, index) => {
               const inputs = row.querySelectorAll('input, select');
               inputs.forEach(input => {
                   const name = input.getAttribute('name');
                   if (name) {
                       const field = name.match(/\[([a-zA-Z_]+)\]/)[1];
                       input.setAttribute('name', `cargo[${index}][${field}]`);
                   }
               });
           });
   
           calculateTotalDeclaredValue();
           calculateTotalChargedWeight();
       }
   }
   
   document.addEventListener('DOMContentLoaded', function () {
       document.querySelectorAll('input[name$="[declared_value]"]').forEach(input => {
           input.addEventListener('input', calculateTotalDeclaredValue);
       });
   
       document.querySelectorAll('input[name$="[charged_weight]"]').forEach(input => {
           input.addEventListener('input', calculateTotalChargedWeight);
       });
   
       calculateTotalDeclaredValue();
       calculateTotalChargedWeight();
   });
   </script>
   
<script>
   function setConsignorDetails() {
       const selected = document.getElementById('consignor_id');
       const gst = selected.options[selected.selectedIndex].getAttribute('data-gst-consignor');
       const address = selected.options[selected.selectedIndex].getAttribute('data-address-consignor');
   
       document.getElementById('consignor_gst').value = gst || '';
       document.getElementById('consignor_loading').value = address || '';
   }
</script>
<script>
    function setConsigneeDetails() {
        const select = document.getElementById('consignee_id');
        const selectedOption = select.options[select.selectedIndex];

        const gst = selectedOption.getAttribute('data-gst-consignee') || '';
        const address = selectedOption.getAttribute('data-address-consignee') || '';

        document.getElementById('consignee_gst').value = gst;
        document.getElementById('consignee_unloading').value = address;
    }
</script>
<script>
   document.addEventListener('input', function(e) {
    const row = e.target.closest('tr');
    if (!row) return;
   
    // Get all input values
    const freight = parseFloat(row.querySelector('.freight-amount')?.value) || 0;
    const lrCharges = parseFloat(row.querySelector('.lr-charges')?.value) || 0;
    const hamali = parseFloat(row.querySelector('.hamali')?.value) || 0;
    const otherCharges = parseFloat(row.querySelector('.other-charges')?.value) || 0;
    const gstPercent = parseFloat(row.querySelector('.gst')?.value) || 0;
    const lessAdvance = parseFloat(row.querySelector('.less-advance')?.value) || 0;
   
    // Total before GST
    const subtotal = freight + lrCharges + hamali + otherCharges;
   
    // GST amount
    const gstAmount = subtotal * gstPercent / 100;
   
    // Total Freight = subtotal + gst
    const totalFreight = subtotal + gstAmount;
   
    // Balance Freight = total - less advance
    const balance = totalFreight - lessAdvance;
   
    // Update values
    if (row.querySelector('.total-freight')) {
      row.querySelector('.total-freight').value = totalFreight.toFixed(2);
    }
   
    if (row.querySelector('.balance-freight')) {
      row.querySelector('.balance-freight').value = balance.toFixed(2);
    }
   });
   
    
</script>
<script>
   function updateFreightAmount() {
       const byOrder = parseFloat(document.getElementById('byoder')?.value) || 0;
       const chargedWeight = parseFloat(document.getElementById('totalChargedWeight')?.value) || 0;
       const result = byOrder * chargedWeight;
   
       const freightInput = document.querySelector('.freight-amount');
       if (freightInput) {
           freightInput.value = result.toFixed(2);
       }
   }
   
   // Listen to changes on both inputs
   document.getElementById('byoder').addEventListener('input', updateFreightAmount);
   document.getElementById('totalChargedWeight').addEventListener('input', updateFreightAmount);
   
   // Run once on load
   document.addEventListener('DOMContentLoaded', updateFreightAmount);
   </script>
   
@endsection