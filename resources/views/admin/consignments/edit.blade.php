@extends('admin.layouts.app')
@section('title', 'Order | KRL')
@section('content')
<!-- Order Booking Add Page -->
<div class="row order-booking-form">
<div class="col-12">
<div class="card">
<div class="card-header d-flex justify-content-between align-items-center">
   <div>
      <h4>🛒 consignments edit </h4>
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
            <a href="{{ route('admin.consignments.index') }}" class="btn" id="backToListBtn"
               style="background-color: #ca2639; color: white; border: none;">
            ⬅ Back to Listing
            </a>
         </div>
         <form method="POST" action="{{ route('admin.consignments.update', $order->order_id) }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
               @php
               $lrList = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
              
               $lrData = $lrList[0] ?? []; 
               
               @endphp
               <div class="row">
                  <!-- Consignor Details -->
                  <div class="col-md-6">
                     <h5>📦 Consignor (Sender)</h5>
                     <select name="consignor_id" id="consignor_id" class="form-select" onchange="setConsignorDetails()" required>
                        <option value="">Select Consignor Name</option>
                        @foreach($users as $user)
                        @php
                        $addresses = json_decode($user->address, true);
                        $formattedAddress = '';
                        if (!empty($addresses) && is_array($addresses)) {
                        $first = $addresses[0]; // only first address
                        $formattedAddress = trim(
                        ($first['full_address'] ?? '') . ', ' .
                        ($first['city'] ?? '') . ', ' .
                        ($first['pincode'] ?? '')
                        );
                        }
                        $isSelected = old('consignor_id', $lrData['consignor_id'] ?? '') == $user->id;
                        @endphp
                        <option 
                        value="{{ $user->id }}"
                        data-gst-consignor="{{ $user->gst_number }}"
                        data-address-consignor="{{ $formattedAddress }}"
                        {{ $isSelected ? 'selected' : '' }}>
                        {{ $user->name }}
                        </option>
                        @endforeach
                     </select>
                     <div class="mb-3">
                        <label class="form-label">Consignor Loading Address</label>
                        <textarea name="consignor_loading" id="consignor_loading" class="form-control" rows="2"
                           placeholder="Enter all addresses">{{ old('consignor_loading', $lrData['consignor_loading'] ?? '') }}</textarea>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">Consignor GST</label>
                        <input type="text" name="consignor_gst" id="consignor_gst" class="form-control"
                           value="{{ old('consignor_gst', $lrData['consignor_gst'] ?? '') }}"
                           placeholder="Enter GST numbers" readonly required>
                     </div>
                  </div>
                  <!-- Consignee Details -->
                  <div class="col-md-6">
                     <h5>📦 Consignee (Receiver)</h5>
                     <div class="mb-3">
                        <label class="form-label">Lr date</label>
                        <input type="date" name="lr_date" class="form-control" value="{{ old('lr_date', $lrData['lr_date'] ?? '') }}"
                           placeholder="Enter lr name" required>
                     </div>
                     <div class="mb-3">
                        <select name="consignee_id" id="consignee_id" class="form-select" onchange="setConsigneeDetails()" required>
                           <option value="">Select Consignee Name</option>
                           @foreach($users as $user)
                           @php
                           $addresses = json_decode($user->address, true);
                           $formattedAddress = '';
                           if (!empty($addresses) && is_array($addresses)) {
                           $first = $addresses[0]; // only first address
                           $formattedAddress = trim(
                           ($first['full_address'] ?? '') . ', ' .
                           ($first['city'] ?? '') . ', ' .
                           ($first['pincode'] ?? '')
                           );
                           }
                           $isSelected = old('consignee_id', $lrData['consignee_id'] ?? '') == $user->id;
                           @endphp
                           <option 
                           value="{{ $user->id }}"
                           data-gst-consignee="{{ $user->gst_number }}"
                           data-address-consignee="{{ $formattedAddress }}"
                           {{ $isSelected ? 'selected' : '' }}>
                           {{ $user->name }}
                           </option>
                           @endforeach
                        </select>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">Consignee Unloading Address</label>
                        <textarea name="consignee_unloading" id="consignee_unloading" class="form-control" rows="2"
                           placeholder="Enter all addresses">{{ old('consignee_unloading', $lrData['consignee_unloading'] ?? '') }}</textarea>
                     </div>
                     <div class="mb-3">
                        <label class="form-label">Consignee GST</label>
                        <input name="consignee_gst" id="consignee_gst" value="{{ old('consignee_gst', $lrData['consignee_gst'] ?? '') }}" 
                           type="text" class="form-control" placeholder="Enter GST numbers" required>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <!-- Date -->
                  <div class="col-md-4">
                   
                     <div class="mb-3">
                        <label class="form-label">🚚 Vehicle Number</label>
                        <select name="vehicle_no" class="form-select">
                           @foreach ($vehicles as $vehicle)
                              <option 
                                    value="{{ $vehicle->vehicle_no }}" 
                                    data-type="{{ $vehicle->vehicle_no }}" 
                                 
                                    {{ old('vehicle_no', $lrData['vehicle_no']) == $vehicle->vehicle_no ? 'selected' : '' }}>
                                    {{ $vehicle->vehicle_no }}
                              </option>
                           @endforeach
                        </select>
                        </div>
                  </div>
                  <!-- Vehicle Type -->
                  <div class="col-md-4">
                     @php 
                     $vehicleOptions = [
                         "3MT / LCV",
                         "5MT",
                         "7.5MT",
                         "9MT",
                         "12MT",
                         "20MT / Multiaxle",
                         "25MT",
                         "19MT / 32FT Container",
                         "30MT",
                         "35MT",
                         "20FT Trailer - 20FT Container",
                         "40FT Container"
                     ];
                 
                     $selectedVehicle = old("lr.vehicle_type", $lrData['vehicle_type'] ?? '');
                 @endphp
                 
                 <div class="mb-3">
                     <label class="form-label">🚛 Vehicle Type</label>
                     <select name="vehicle_type" class="form-select" required>
                         <option value="">Select Type</option>
                         @foreach ($vehicleOptions as $type)
                             <option value="{{ $type }}" {{ $selectedVehicle == $type ? 'selected' : '' }}>
                                 {{ $type }}
                             </option>
                         @endforeach
                     </select>
                 </div>
                 
               </div>
                  <!-- Vehicle Ownership -->
                              <div class="col-md-4">
                                 <label class="form-label">🛻 Vehicle Ownership</label>
                                 <div class="d-flex gap-3">
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="vehicle_ownership" value="Own"
                        {{ old('vehicle_ownership', $lrData['vehicle_ownership'] ?? '') == 'Own' ? 'checked' : '' }}>
                  <label class="form-check-label">Own</label>
               </div>
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="vehicle_ownership" value="Other"
                        {{ old('vehicle_ownership', $lrData['vehicle_ownership'] ?? '') == 'Other' ? 'checked' : '' }}>
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
         <select name="delivery_mode" class="form-select" required>
            <option value="">Select Mode</option>
            <option value="Road" {{ old('delivery_mode', $lrData['delivery_mode'] ?? '') == 'door_delivery' ? 'selected' : '' }}>Door Delivery</option>
            <option value="Rail" {{ old('delivery_mode', $lrData['delivery_mode'] ?? '') == 'godwon_deliver' ? 'selected' : '' }}>Godwon Deliver</option>
           
         </select>
      </div>
   </div>
   <!-- From Location -->
   <div class="col-md-4">
      <div class="mb-3">
         <label class="form-label">📍 From (Origin)</label>
         <select name="from_location" class="form-select" required>
            <option value="">Select Origin</option>
            <option value="Mumbai" {{ old('from_location', $lrData['from_location'] ?? '') == 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
            <option value="Delhi" {{ old('from_location', $lrData['from_location'] ?? '') == 'Delhi' ? 'selected' : '' }}>Delhi</option>
            <option value="Chennai" {{ old('from_location', $lrData['from_location'] ?? '') == 'Chennai' ? 'selected' : '' }}>Chennai</option>
         </select>
      </div>
   </div>
   <!-- To Location -->
   <div class="col-md-4">
      <div class="mb-3">
         <label class="form-label">📍 To (Destination)</label>
         <select name="to_location" class="form-select" required>
            <option value="">Select Destination</option>
            <option value="Kolkata" {{ old('to_location', $lrData['to_location'] ?? '') == 'Kolkata' ? 'selected' : '' }}>Kolkata</option>
            <option value="Hyderabad" {{ old('to_location', $lrData['to_location'] ?? '') == 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
            <option value="Pune" {{ old('to_location', $lrData['to_location'] ?? '') == 'Pune' ? 'selected' : '' }}>Pune</option>
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
{{-- insurence mode --}}
     
               <!-- Cargo Description Section -->
               <div class="row mt-4">
                  <div class="col-12">
                     <h5 class="mb-3 pb-3">📦 Cargo Description</h5>
                     <div class="mb-3 d-flex gap-3">
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="cargo_description_type" id="singleDoc" value="single" {{ old('cargo_description_type', 'single') == 'single' ? 'checked' : '' }} required>
                           <label class="form-check-label" for="singleDoc">Single Document</label>
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="radio" name="cargo_description_type" id="multipleDoc" value="multiple" required>
                           <label class="form-check-label" for="multipleDoc">Multiple Documents</label>
                        </div>
                     </div>
                     <!-- Cargo Details Table -->
                     <!-- Cargo Table -->
                     <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                           <thead>
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
         @php 
         $cargoData = old('cargo', isset($lrData['cargo']) ? $lrData['cargo'] : [['packages_no' => '', 'package_type' => '', 'package_description' => '', 'weight' => '', 'actual_weight' => '', 'charged_weight' => '', 'document_no' => '', 'document_name' => '', 'document_date' => '', 'eway_bill' => '', 'valid_upto' => '']]); 
         @endphp
         @foreach ($cargoData as $index => $cargo)
         <tr>
            <td><input type="number" name="cargo[{{ $index }}][packages_no]" class="form-control" value="{{ $cargo['packages_no'] }}" required></td>
            <td>
               <select name="cargo[{{ $index }}][package_type]" class="form-select" required>
                  <option value="Pallets" {{ $cargo['package_type'] == 'Pallets' ? 'selected' : '' }}>Pallets</option>
                  <option value="Cartons" {{ $cargo['package_type'] == 'Cartons' ? 'selected' : '' }}>Cartons</option>
                  <option value="Bags" {{ $cargo['package_type'] == 'Bags' ? 'selected' : '' }}>Bags</option>
               </select>
            </td>
            <td><input type="text" name="cargo[{{ $index }}][package_description]" class="form-control" value="{{ $cargo['package_description'] }}" required></td>
            {{-- <td><input type="number" name="cargo[{{ $index }}][weight]" class="form-control" value="{{ $cargo['weight'] }}" required></td> --}}
            <td><input type="number" name="cargo[{{ $index }}][actual_weight]" class="form-control" value="{{ $cargo['actual_weight'] }}" required></td>
            <td><input type="number" name="cargo[{{ $index }}][charged_weight]" class="form-control" value="{{ $cargo['charged_weight'] }}" required></td>
            <td>
               <select class="form-select" name="cargo[{{ $index }}][unit]" required>
                  <option value="">Select Unit</option>
                  <option value="kg" {{ ($cargo['unit'] ?? '') == 'kg' ? 'selected' : '' }}>Kg</option>
                  <option value="ton" {{ ($cargo['unit'] ?? '') == 'ton' ? 'selected' : '' }}>Ton</option>
              </select>
             </td>
            <td><input type="text" name="cargo[{{ $index }}][document_no]" class="form-control" value="{{ $cargo['document_no'] }}" required></td>
            <td><input type="text" name="cargo[{{ $index }}][document_name]" class="form-control" value="{{ $cargo['document_name'] }}" required></td>
            <td><input type="date" name="cargo[{{ $index }}][document_date]" class="form-control" value="{{ $cargo['document_date'] }}" required></td>
            <td><input type="file" name="cargo[{{ $index }}][document_file]" class="form-control" value="" >
              
            <img src="{{ asset('storage/' .$cargo['document_file']) }}" width="150" class="img-thumbnail" alt="Document Image">

            </td>
            <td><input type="text" name="cargo[{{ $index }}][eway_bill]" class="form-control" value="{{ $cargo['eway_bill'] }}" required></td>
            <td><input type="date" name="cargo[{{ $index }}][valid_upto]" class="form-control" value="{{ $cargo['valid_upto'] }}" required></td>
            <td><input name="cargo[{{ $index }}][declared_value]" type="number" value="{{ $cargo['declared_value'] }}" class="form-control" placeholder="0" required></td>

            <td>
               <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button>
            </td>
         </tr>
         @endforeach
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
                            <input class="form-check-input freight-type" type="radio" name="freightType"
                                id="freightPaid" value="paid"
                                onchange="toggleFreightTable()"
                                {{ (isset($lrData['freightType']) && $lrData['freightType'] == 'paid') ? 'checked' : '' }}>
                            <label class="form-check-label" for="freightPaid">Paid</label>
                        </div>
                    
                        <div class="form-check form-check-inline">
                            <input class="form-check-input freight-type" type="radio" name="freightType"
                                id="freightToPay" value="to_pay"
                                onchange="toggleFreightTable()"
                                {{ (isset($lrData['freightType']) && $lrData['freightType'] == 'to_pay') ? 'checked' : '' }}>
                            <label class="form-check-label" for="freightToPay">To Pay</label>
                        </div>
                    
                        <div class="form-check form-check-inline">
                            <input class="form-check-input freight-type" type="radio" name="freightType"
                                id="freightToBeBilled" value="to_be_billed"
                                onchange="toggleFreightTable()"
                                {{ (isset($lrData['freightType']) && $lrData['freightType'] == 'to_be_billed') ? 'checked' : '' }}>
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
                                 <td><input name="freight_amount" type="number" class="form-control"
                                 value="{{ old('freight_amount', $lrData['freight_amount'] ?? '') }}"
                                    
                                    placeholder="Enter Freight Amount" required></td>
                                 <td><input name="lr_charges" type="number" class="form-control"
                                 value="{{ old('lr_charges', $lrData['lr_charges'] ?? '') }}"
                                    
                                    placeholder="Enter LR Charges" required></td>
                                 <td><input name="hamali" type="number" class="form-control"
                                 value="{{ old('hamali', $lrData['hamali'] ?? '') }}"
                                   
                                    placeholder="Enter Hamali Charges" required></td>
                                    
                                 <td><input name="other_charges" type="number" class="form-control"
                                 value="{{ old('other_charges', $lrData['other_charges'] ?? '') }}"
                                    
                                    placeholder="Enter Other Charges" required></td>

                                 <td><input name="gst_amount" type="number" class="form-control"
                                  value="{{ old('gst_amount', $lrData['gst_amount'] ?? '') }}"
                                    
                                    placeholder="Enter GST Amount" required></td>
                                 <td><input name="total_freight" type="number" class="form-control"
                                  value="{{ old('total_freight', $lrData['total_freight'] ?? '') }}"
                                    
                                    placeholder="Total Freight" required></td>
                                 <td><input name="less_advance" type="number" class="form-control"
                                  value="{{ old('less_advance', $lrData['less_advance'] ?? '') }}"
                                    
                                    placeholder="Less Advance Amount" required></td>
                                 <td><input name="balance_freight" type="number" class="form-control"
                                  value="{{ old('balance_freight', $lrData['balance_freight'] ?? '') }}"
                                    
                                    placeholder="Balance Freight Amount" required></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <!-- Declared Value -->
                  <div class="col-md-6 mt-3">
                     <div class="mb-3">
                        <label class="form-label " style="font-weight: bold;">💰 Total Declared Value
                        (Rs.)</label>
                        <input type="number" id="totalDeclaredValue"  required  value="{{ old('total_declared_value', $lrData['toatal_declared_value'] ?? '') }}"  name="total_declared_value" class="form-control">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <!-- Submit Button -->
                  <div class="row mt-4 mb-4">
                     <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Consignment 
                        </button>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
{{-- image view --}}
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
   let cargoIndex = {{ count($cargoData) }};

   function calculateTotalDeclaredValue() {
       let total = 0;
       const inputs = document.querySelectorAll('.declared-value');

       inputs.forEach(input => {
           total += parseFloat(input.value) || 0;
       });

       document.getElementById('totalDeclaredValue').value = total;
   }

   function addRow() {
       const tbody = document.getElementById('cargoTableBody');
       const row = document.createElement('tr');

       row.innerHTML = `
           <td><input type="number" name="cargo[${cargoIndex}][packages_no]" class="form-control"></td>
           <td>
               <select name="cargo[${cargoIndex}][package_type]" class="form-select">
                   <option value="Pallets">Pallets</option>
                   <option value="Cartons">Cartons</option>
                   <option value="Bags">Bags</option>
               </select>
           </td>
           <td><input type="text" name="cargo[${cargoIndex}][package_description]" class="form-control"></td>
           <td><input type="number" name="cargo[${cargoIndex}][actual_weight]" class="form-control"></td>
           <td><input type="number" name="cargo[${cargoIndex}][charged_weight]" class="form-control"></td>
           <td><input type="text" name="cargo[${cargoIndex}][document_no]" class="form-control"></td>
           <td><input type="text" name="cargo[${cargoIndex}][document_name]" class="form-control"></td>
           <td><input type="date" name="cargo[${cargoIndex}][document_date]" class="form-control"></td>
           <td><input type="file" name="cargo[${cargoIndex}][document_file]" class="form-control"></td>
           <td><input type="text" name="cargo[${cargoIndex}][eway_bill]" class="form-control"></td>
           <td><input type="date" name="cargo[${cargoIndex}][valid_upto]" class="form-control"></td>
           <td><input type="number" name="cargo[${cargoIndex}][declared_value]" class="form-control declared-value" oninput="calculateTotalDeclaredValue()" required></td>
           <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button></td>
       `;

       tbody.appendChild(row);
       cargoIndex++;
       calculateTotalDeclaredValue(); // Update total on row add
   }

   function removeRow(button) {
       button.closest('tr').remove();
       calculateTotalDeclaredValue(); // Update total on row remove
   }

   // Run once after DOM loads to handle existing rows
   document.addEventListener('DOMContentLoaded', function () {
       document.querySelectorAll('input[name$="[declared_value]"]').forEach(input => {
           input.classList.add('declared-value');
           input.addEventListener('input', calculateTotalDeclaredValue);
       });

       calculateTotalDeclaredValue();
   });
</script>

<script>
   document.getElementById('createInsuranceYes').addEventListener('click', function () {
       let myModal = new bootstrap.Modal(document.getElementById('insuranceModal'));
       myModal.show();
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
   
   // Call on page load (for edit mode)
   document.addEventListener('DOMContentLoaded', function () {
       const customerSelect = document.getElementById('consignor_id');
       if (customerSelect.value !== '') {
           setConsignorDetails();
       }
   });
</script>
<script>
   function setConsigneeDetails() {
       const selected = document.getElementById('consignee_id');
       const gst = selected.options[selected.selectedIndex].getAttribute('data-gst-consignee');
       const address = selected.options[selected.selectedIndex].getAttribute('data-address-consignee');
   
       document.getElementById('consignee_gst').value = gst || '';
       document.getElementById('consignee_unloading').value = address || '';
   }
   
   // Call on page load (for edit mode)
   document.addEventListener('DOMContentLoaded', function () {
       const customerSelect = document.getElementById('consignee_id');
       if (customerSelect.value !== '') {
           setConsigneeDetails();
       }
   });
</script>
<script>
   $(document).ready(function () {
       $(document).on('click', '.openImageModal', function () {
           var imageUrl = $(this).data('image');
           console.log("Image URL:", imageUrl); // Should log to console
           $('#modalImage').attr('src', imageUrl);
       });
   });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection