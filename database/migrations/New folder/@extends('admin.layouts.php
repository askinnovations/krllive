@extends('admin.layouts.app')
@section('title', 'Order | KRL')
@section('content')
<form method="POST" action="{{ route('admin.orders.update', $order->order_id) }}">
   @csrf
   <div class="card">
   <div class="card-header">
      <h4>Edit Order</h4>
   </div>
   <div class="card-body">
      <div class="row">
         <div class="col-md-3">
            <label>📌 Order ID</label>
            <input type="text" name="order_id" class="form-control" value="{{ $order->order_id }}" readonly>
         </div>
         <div class="col-md-3">
            <label>📝 Description</label>
            <textarea name="description" class="form-control">{{ $order->description }}</textarea>
         </div>
         <div class="col-md-3">
            <label>📅 Date</label>
            <input type="date" name="order_date" class="form-control" value="{{ $order->order_date }}">
         </div>
         <div class="col-md-3">
            <label>📊 Status</label>
            <select name="status" class="form-select">
            <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
            <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
         </div>
         <!-- CUSTOMER NAME DROPDOWN -->
         <div class="col-md-3">
            <div class="mb-3">
               <label class="form-label">👤 CUSTOMER NAME</label>
               <select name="customer_id" id="customer_id" class="form-select" onchange="setCustomerDetails()">
                  <option value="">Select Customer</option>
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
                  $isSelected = old('customer_id', isset($order) ? $order->customer_id : '') == $user->id;
                  @endphp
                  <option 
                  value="{{ $user->id }}"
                  data-gst="{{ $user->gst_number }}"
                  data-address="{{ $formattedAddress }}"
                  {{ $isSelected ? 'selected' : '' }}>
                  {{ $user->name }}
                  </option>
                  @endforeach
               </select>
            </div>
         </div>
         <!-- GST NUMBER (Auto-filled) -->
         <div class="col-md-3">
            <div class="mb-3">
               <label class="form-label">🧾 GST NUMBER</label>
               <input type="text" name="gst_number" id="gst_number" value="{{ old('gst_number', isset($order) ? $order->customer_gst : '') }}" class="form-control" readonly>
            </div>
         </div>
         <!-- CUSTOMER ADDRESS (Auto-filled) -->
         <div class="col-md-3">
            <div class="mb-3">
               <label class="form-label">📍 CUSTOMER ADDRESS</label>
               <input type="text" name="customer_address" id="customer_address"  value="{{ old('customer_address', isset($order) ? $order->customer_address : '') }}"  class="form-control" readonly>
            </div>
         </div>
         <!-- ORDER TYPE -->
         <div class="col-md-3">
            <div class="mb-3">
               <label class="form-label">📊 Order Type</label>
               <select name="order_type" class="form-select">
                  <option value="">Select Order</option>
                  @php
                  $orderType = old('order_type', isset($order) ? $order->order_type : '');
                  @endphp
                  <option value="Back Date" {{ $orderType === 'Back Date' ? 'selected' : '' }}>Back Date</option>
                  <option value="Future" {{ $orderType === 'Future' ? 'selected' : '' }}>Future</option>
                  <option value="Normal" {{ $orderType === 'Normal' ? 'selected' : '' }}>Normal</option>
               </select>
            </div>
         </div>
      </div>
      
      <!-- LR Sections -->
      <div id="lr-sections">
         @foreach($order->lrs as $lrIndex => $lr)
         <div class="row mt-4 lr-section" data-lr-index="{{ $lrIndex }}">
            <h4 style="margin-bottom: 2%;">🚚 LR - Consignment Details #{{ $lrIndex + 1 }}</h4>
            
            <div class="row g-3 mb-3">
               <div class="col-md-3">
                  <label class="form-label">Lr Number</label>
                  <input 
                     type="number" 
                     name="lrs[{{ $lrIndex }}][lr_number]" 
                     class="form-control" 
                     placeholder="Enter lr number" 
                     value="{{ $lr->lr_number }}">
               </div>
               <div class="col-md-3">
                  <label class="form-label">Lr Date</label>
                  <input 
                     type="date" 
                     name="lrs[{{ $lrIndex }}][lr_date]" 
                     class="form-control" 
                     placeholder="Enter lr date" 
                     value="{{ $lr->lr_date }}">
               </div>
               <!-- Consignor Name -->
               <div class="col-md-3">
                  <label class="form-label">🚚 Consignor Name</label>
                  <select name="lrs[{{ $lrIndex }}][consignor_id]" class="form-select consignor-select" onchange="setConsignorDetails(this)">
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
                     $isSelected = $lr->consignor_id == $user->id;
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
               </div>
               <!-- Consignor GST -->
               <div class="col-md-3">
                  <label class="form-label">🧾 Consignor GST</label>
                  <input type="text" name="lrs[{{ $lrIndex }}][consignor_gst]" class="form-control consignor-gst" value="{{ $lr->consignor_gst }}" readonly>
               </div>
               <!-- Consignor Loading Address -->
               <div class="col-md-3">
                  <label class="form-label">📍 Loading Address</label>
                  <input type="text" name="lrs[{{ $lrIndex }}][consignor_loading]" class="form-control consignor-loading" value="{{ $lr->consignor_loading }}" readonly>
               </div>
               <!-- Consignee Name -->
               <div class="col-md-3">
                  <label class="form-label">🏢 Consignee Name</label>
                  <select name="lrs[{{ $lrIndex }}][consignee_id]" class="form-select consignee-select" onchange="setConsigneeDetails(this)">
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
                     $isSelected = $lr->consignee_id == $user->id;
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
               <!-- Consignee GST -->
               <div class="col-md-3">
                  <label class="form-label">🧾 Consignee GST</label>
                  <input type="text" name="lrs[{{ $lrIndex }}][consignee_gst]" class="form-control consignee-gst" value="{{ $lr->consignee_gst }}" readonly>
               </div>
               <!-- Consignee Unloading Address -->
               <div class="col-md-3">
                  <label class="form-label">📍 Unloading Address</label>
                  <input type="text" name="lrs[{{ $lrIndex }}][consignee_unloading]" class="form-control consignee-unloading" value="{{ $lr->consignee_unloading }}" readonly>
               </div>
            </div>
            
            <div class="row">
               <!-- Vehicle Date -->
               <div class="col-md-4">
                  <div class="mb-3">
                     <label class="form-label">📅 Vehicle Date</label>
                     <input type="date" name="lrs[{{ $lrIndex }}][vehicle_date]" class="form-control" value="{{ $lr->vehicle_date }}">
                  </div>
               </div>
               <!-- Vehicle Type -->
               <div class="col-md-4">
                  <div class="mb-3">
                     <label class="form-label">🚛 Vehicle Type</label>
                     <select name="lrs[{{ $lrIndex }}][vehicle_type]" class="form-select">
                        <option value="">Select Vehicle</option>
                        @foreach ($vehicles as $vehicle)
                        @php
                        $value = $vehicle->vehicle_type . '|' . $vehicle->vehicle_no;
                        $selected = $lr->vehicle_type . '|' . $lr->vehicle_no == $value ? 'selected' : '';
                        @endphp
                        <option value="{{ $value }}" {{ $selected }}>
                           {{ $vehicle->vehicle_type }} - {{ $vehicle->vehicle_no }}
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
                        <input class="form-check-input" type="radio" name="lrs[{{ $lrIndex }}][vehicle_ownership]" value="Own"
                        {{ $lr->vehicle_ownership == 'Own' ? 'checked' : '' }}>
                        <label class="form-check-label">Own</label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="lrs[{{ $lrIndex }}][vehicle_ownership]" value="Other"
                        {{ $lr->vehicle_ownership == 'Other' ? 'checked' : '' }}>
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
                     <select name="lrs[{{ $lrIndex }}][delivery_mode]" class="form-select">
                        <option value="">Select Mode</option>
                        <option value="Road" {{ $lr->delivery_mode == 'Road' ? 'selected' : '' }}>Road</option>
                        <option value="Rail" {{ $lr->delivery_mode == 'Rail' ? 'selected' : '' }}>Rail</option>
                        <option value="Air" {{ $lr->delivery_mode == 'Air' ? 'selected' : '' }}>Air</option>
                     </select>
                  </div>
               </div>
               <!-- From Location -->
               <div class="col-md-4">
                  <div class="mb-3">
                     <label class="form-label">📍 From (Origin)</label>
                     <select name="lrs[{{ $lrIndex }}][from_location]" class="form-select">
                        <option value="">Select Origin</option>
                        <option value="Mumbai" {{ $lr->from_location == 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                        <option value="Delhi" {{ $lr->from_location == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                        <option value="Chennai" {{ $lr->from_location == 'Chennai' ? 'selected' : '' }}>Chennai</option>
                     </select>
                  </div>
               </div>
               <!-- To Location -->
               <div class="col-md-4">
                  <div class="mb-3">
                     <label class="form-label">📍 To (Destination)</label>
                     <select name="lrs[{{ $lrIndex }}][to_location]" class="form-select">
                        <option value="">Select Destination</option>
                        <option value="Kolkata" {{ $lr->to_location == 'Kolkata' ? 'selected' : '' }}>Kolkata</option>
                        <option value="Hyderabad" {{ $lr->to_location == 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
                        <option value="Pune" {{ $lr->to_location == 'Pune' ? 'selected' : '' }}>Pune</option>
                     </select>
                  </div>
               </div>
            </div>
            
            <!-- Cargo Description Section -->
            <div class="row mt-4">
               <div class="col-12">
                  <h5 class="mb-3 pb-3">📦 Cargo Description</h5>
                  <!-- Documentation Selection -->
                  <div class="mb-3 d-flex gap-3">
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="lrs[{{ $lrIndex }}][cargo_description_type]" id="singleDoc{{ $lrIndex }}" value="single" {{ count($lr->cargos) <= 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="singleDoc{{ $lrIndex }}">Single Document</label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="lrs[{{ $lrIndex }}][cargo_description_type]" id="multipleDoc{{ $lrIndex }}" value="multiple" {{ count($lr->cargos) > 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="multipleDoc{{ $lrIndex }}">Multiple Documents</label>
                     </div>
                  </div>
                  
                  <!-- Cargo Details Table -->
                  <div class="table-responsive">
                     <table class="table table-bordered align-middle text-center">
                        <thead>
                           <tr>
                              <th>No. of Packages</th>
                              <th>Packaging Type</th>
                              <th>Description</th>
                              <th>Weight (kg)</th>
                              <th>Actual Weight (kg)</th>
                              <th>Charged Weight (kg)</th>
                              <th>Document No.</th>
                              <th>Document Name</th>
                              <th>Document Date</th>
                              <th>Eway Bill</th>
                              <th>Valid Upto</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody class="cargo-table-body">
                           @foreach($lr->cargos as $cargoIndex => $cargo)
                           <tr>
                              <td>
                                 <input type="number" name="lrs[{{ $lrIndex }}][cargos][{{ $cargoIndex }}][packages_no]" class="form-control" value="{{ $cargo->packages_no }}">
                              </td>
                              <td>
                                 <select name="lrs[{{ $lrIndex }}][cargos][{{ $cargoIndex }}][package_type]" class="form-select">
                                    <option value="Pallets" {{ $cargo->package_type == 'Pallets' ? 'selected' : '' }}>Pallets</option>
                                    <option value="Cartons" {{ $cargo->package_type == 'Cartons' ? 'selected' : '' }}>Cartons</option>
                                    <option value="Bags" {{ $cargo->package_type == 'Bags' ? 'selected' : '' }}>Bags</option>
                                 </select>
                              </td>
                              <td>
                                 <input type="text" name="lrs[{{ $lrIndex }}][cargos][{{ $cargoIndex }}][package_description]" class="form-control" value="{{ $cargo->package_description }}">
                              </td>
                              <td>
                                 <input type="number" name="lrs[{{ $lrIndex }}][cargos][{{ $cargoIndex }}][weight]" class="form-control" value="{{ $cargo->weight }}">
                              </td>
                              <td>
                                 <input type="number" name="lrs[{{ $lrIndex }}][cargos][{{ $cargoIndex }}][actual_weight]" class="form-control" value="{{ $cargo->actual_weight }}">
                              </td>
                              <td>
                                 <input type="number" name="lrs[{{ $lrIndex }}][cargos][{{ $cargoIndex }}][charged_weight]" class="form-control" value="{{ $cargo->charged_weight }}">
                              </td>
                              <td>
                                 <input type="text" name="lrs[{{ $lrIndex }}][cargos][{{ $cargoIndex }}][document_no]" class="form-control" value="{{ $cargo->document_no }}">
                              </td>
                              <td>
                                 <input type="text" name="lrs[{{ $lrIndex }}][cargos][{{ $cargoIndex }}][document_name]" class="form-control" value="{{ $cargo->document_name }}">
                              </td>
                              <td>
                                 <input type="date" name="lrs[{{ $lrIndex }}][cargos][{{ $cargoIndex }}][document_date]" class="form-control" value="{{ $cargo->document_date }}">
                              </td>
                              <td>
                                 <input type="text" name="lrs[{{ $lrIndex }}][cargos][{{ $cargoIndex }}][eway_bill]" class="form-control" value="{{ $cargo->eway_bill }}">
                              </td>
                              <td>
                                 <input type="date" name="lrs[{{ $lrIndex }}][cargos][{{ $cargoIndex }}][valid_upto]" class="form-control" value="{{ $cargo->valid_upto }}">
                              </td>
                              <td>
                                 <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button>
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  
                  <!-- Add Row Button -->
                  <div class="text-end mt-2">
                     <button type="button" class="btn btn-sm add-cargo-row" style="background: #ca2639; color: white;" data-lr-index="{{ $lrIndex }}">
                        <span style="filter: invert(1);">➕</span> Add Row
                     </button>
                  </div>
               </div>
            </div>
            
            <!-- Freight Details Section -->
            <div class="row mt-4">
               <div class="col-12">
                  <h5 class="pb-3">🚚 Freight Details</h5>
                  <div class="table-responsive">
                     <table class="table table-bordered align-middle text-center">
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
                        <tbody>
                           <tr>
                              <td>
                                 <input name="lrs[{{ $lrIndex }}][freight_amount]" type="number" class="form-control"
                                    value="{{ $lr->freight_amount }}"
                                    placeholder="Enter Freight Amount">
                              </td>
                              <td>
                                 <input name="lrs[{{ $lrIndex }}][lr_charges]" type="number" class="form-control"
                                    value="{{ $lr->lr_charges }}"
                                    placeholder="Enter LR Charges">
                              </td>
                              <td>
                                 <input name="lrs[{{ $lrIndex }}][hamali]" type="number" class="form-control"
                                    value="{{ $lr->hamali }}"
                                    placeholder="Enter Hamali Charges">
                              </td>
                              <td>
                                 <input name="lrs[{{ $lrIndex }}][other_charges]" type="number" class="form-control"
                                    value="{{ $lr->other_charges }}"
                                    placeholder="Enter Other Charges">
                              </td>
                              <td>
                                 <input name="lrs[{{ $lrIndex }}][gst_amount]" type="number" class="form-control"
                                    value="{{ $lr->gst_amount }}"
                                    placeholder="Enter GST Amount">
                              </td>
                              <td>
                                 <input name="lrs[{{ $lrIndex }}][total_freight]" type="number" class="form-control"
                                    value="{{ $lr->total_freight }}"
                                    placeholder="Total Freight">
                              </td>
                              <td>
                                 <input name="lrs[{{ $lrIndex }}][less_advance]" type="number" class="form-control"
                                    value="{{ $lr->less_advance }}"
                                    placeholder="Less Advance Amount">
                              </td>
                              <td>
                                 <input name="lrs[{{ $lrIndex }}][balance_freight]" type="number" class="form-control"
                                    value="{{ $lr->balance_freight }}"
                                    placeholder="Balance Freight Amount">
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            
            <!-- Declared Value -->
            <div class="row mt-3">
               <div class="col-md-6">
                  <div class="mb-3">
                     <label class="form-label" style="font-weight: bold;">💰 Declared Value (Rs.)</label>
                     <input type="number" name="lrs[{{ $lrIndex }}][declared_value]" value="{{ $lr->declared_value }}" class="form-control">
                  </div>
               </div>
            </div>
            
            <!-- Remove LR Button -->
            <div class="d-flex justify-content-end gap-2 mt-3">
               @if($lrIndex > 0)
               <button type="button" class="btn btn-outline-warning btn-sm remove-lr-btn" data-lr-index="{{ $lrIndex }}">
                  <i class="fas fa-trash-alt"></i> Remove LR
               </button>
               @endif
            </div>
         </div>
         @endforeach
      </div>
      
      <!-- Add More LR Button -->
      <div class="d-flex justify-content-end gap-2 mt-3">
         <button type="button" class="btn btn-sm add-more-lr-btn" style="background-color: #ca2639; color: #fff;">
            <i class="fas fa-plus-circle"></i> Add More LR - Consignment
         </button>
      </div>
      
      <!-- Submit Button -->
      <div class="row mt-4 mb-4">
         <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">
               <i class="fas fa-save"></i> Update Consignment 
            </button>
         </div>
      </div>
   </div>
</form>

<script>
   // Set customer details when page loads
   document.addEventListener('DOMContentLoaded', function() {
      setCustomerDetails();
      
      // Set consignor and consignee details for each LR
      document.querySelectorAll('.consignor-select').forEach(select => {
         if (select.value) setConsignorDetails(select);
      });
      
      document.querySelectorAll('.consignee-select').forEach(select => {
         if (select.value) setConsigneeDetails(select);
      });
   });

   function setCustomerDetails() {
      const selected = document.getElementById('customer_id');
      const gst = selected.options[selected.selectedIndex]?.getAttribute('data-gst') || '';
      const address = selected.options[selected.selectedIndex]?.getAttribute('data-address') || '';
      
      document.getElementById('gst_number').value = gst;
      document.getElementById('customer_address').value = address;
   }
   
   function setConsignorDetails(selectElement) {
      const lrSection = selectElement.closest('.lr-section');
      const gst = selectElement.options[selectElement.selectedIndex]?.getAttribute('data-gst-consignor') || '';
      const address = selectElement.options[selectElement.selectedIndex]?.getAttribute('data-address-consignor') || '';
      
      lrSection.querySelector('.consignor-gst').value = gst;
      lrSection.querySelector('.consignor-loading').value = address;
   }
   
   function setConsigneeDetails(selectElement) {
      const lrSection = selectElement.closest('.lr-section');
      const gst = selectElement.options[selectElement.selectedIndex]?.getAttribute('data-gst-consignee') || '';
      const address = selectElement.options[selectElement.selectedIndex]?.getAttribute('data-address-consignee') || '';
      
      lrSection.querySelector('.consignee-gst').value = gst;
      lrSection.querySelector('.consignee-unloading').value = address;
   }
   
   // Add new cargo row
   document.querySelectorAll('.add-cargo-row').forEach(button => {
      button.addEventListener('click', function() {
         const lrIndex = this.getAttribute('data-lr-index');
         const tbody = this.closest('.row').querySelector('.cargo-table-body');
         const cargoCount = tbody.querySelectorAll('tr').length;
         
         const newRow = document.createElement('tr');
         newRow.innerHTML = `
            <td>
               <input type="number" name="lrs[${lrIndex}][cargos][${cargoCount}][packages_no]" class="form-control">
            </td>
            <td>
               <select name="lrs[${lrIndex}][cargos][${cargoCount}][package_type]" class="form-select">
                  <option value="Pallets">Pallets</option>
                  <option value="Cartons">Cartons</option>
                  <option value="Bags">Bags</option>
               </select>
            </td>
            <td>
               <input type="text" name="lrs[${lrIndex}][cargos][${cargoCount}][package_description]" class="form-control">
            </td>
            <td>
               <input type="number" name="lrs[${lrIndex}][cargos][${cargoCount}][weight]" class="form-control">
            </td>
            <td>
               <input type="number" name="lrs[${lrIndex}][cargos][${cargoCount}][actual_weight]" class="form-control">
            </td>
            <td>
               <input type="number" name="lrs[${lrIndex}][cargos][${cargoCount}][charged_weight]" class="form-control">
            </td>
            <td>
               <input type="text" name="lrs[${lrIndex}][cargos][${cargoCount}][document_no]" class="form-control">
            </td>
            <td>
               <input type="text" name="lrs[${lrIndex}][cargos][${cargoCount}][document_name]" class="form-control">
            </td>
            <td>
               <input type="date" name="lrs[${lrIndex}][cargos][${cargoCount}][document_date]" class="form-control">
            </td>
            <td>
               <input type="text" name="lrs[${lrIndex}][cargos][${cargoCount}][eway_bill]" class="form-control">
            </td>
            <td>
               <input type="date" name="lrs[${lrIndex}][cargos][${cargoCount}][valid_upto]" class="form-control">
            </td>
            <td>
               <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button>
            </td>
         `;
         
         tbody.appendChild(newRow);
      });
   });
   
   // Remove cargo row
   function removeRow(button) {
      const row = button.closest('tr');
      row.remove();
   }
   
   // Add new LR section
   document.querySelector('.add-more-lr-btn').addEventListener('click', function() {
      const lrSections = document.getElementById('lr-sections');
      const lrCount = lrSections.querySelectorAll('.lr-section').length;
      const newLrIndex = lrCount;
      
      const newLrSection = document.createElement('div');
      newLrSection.className = 'row mt-4 lr-section';
      newLrSection.setAttribute('data-lr-index', newLrIndex);
      
      newLrSection.innerHTML = `
         <h4 style="margin-bottom: 2%;">🚚 LR - Consignment Details #${newLrIndex + 1}</h4>
         
         <div class="row g-3 mb-3">
            <div class="col-md-3">
               <label class="form-label">Lr Number</label>
               <input 
                  type="number" 
                  name="lrs[${newLrIndex}][lr_number]" 
                  class="form-control" 
                  placeholder="Enter lr number">
            </div>
            <div class="col-md-3">
               <label class="form-label">Lr Date</label>
               <input 
                  type="date" 
                  name="lrs[${newLrIndex}][lr_date]" 
                  class="form-control" 
                  placeholder="Enter lr date">
            </div>
            <!-- Consignor Name -->
            <div class="col-md-3">
               <label class="form-label">🚚 Consignor Name</label>
               <select name="lrs[${newLrIndex}][consignor_id]" class="form-select consignor-select" onchange="setConsignorDetails(this)">
                  <option value="">Select Consignor Name</option>
                  @foreach($users as $user)
                  @php
                  $addresses = json_decode($user->address, true);
                  $formattedAddress = '';
                  if (!empty($addresses) && is_array($addresses)) {
                     $first = $addresses[0];
                     $formattedAddress = trim(
                        ($first['full_address'] ?? '') . ', ' .
                        ($first['city'] ?? '') . ', ' .
                        ($first['pincode'] ?? '')
                     );
                  }
                  @endphp
                  <option 
                     value="{{ $user->id }}"
                     data-gst-consignor="{{ $user->gst_number }}"
                     data-address-consignor="{{ $formattedAddress }}">
                     {{ $user->name }}
                  </option>
                  @endforeach
               </select>
            </div>
            <!-- Consignor GST -->
            <div class="col-md-3">
               <label class="form-label">🧾 Consignor GST</label>
               <input type="text" name="lrs[${newLrIndex}][consignor_gst]" class="form-control consignor-gst" readonly>
            </div>
            <!-- Consignor Loading Address -->
            <div class="col-md-3">
               <label class="form-label">📍 Loading Address</label>
               <input type="text" name="lrs[${newLrIndex}][consignor_loading]" class="form-control consignor-loading" readonly>
            </div>
            <!-- Consignee Name -->
            <div class="col-md-3">
               <label class="form-label">🏢 Consignee Name</label>
               <select name="lrs[${newLrIndex}][consignee_id]" class="form-select consignee-select" onchange="setConsigneeDetails(this)">
                  <option value="">Select Consignee Name</option>
                  @foreach($users as $user)
                  @php
                  $addresses = json_decode($user->address, true);
                  $formattedAddress = '';
                  if (!empty($addresses) && is_array($addresses)) {
                     $first = $addresses[0];
                     $formattedAddress = trim(
                        ($first['full_address'] ?? '') . ', ' .
                        ($first['city'] ?? '') . ', ' .
                        ($first['pincode'] ?? '')
                     );
                  }
                  @endphp
                  <option 
                     value="{{ $user->id }}"
                     data-gst-consignee="{{ $user->gst_number }}"
                     data-address-consignee="{{ $formattedAddress }}">
                     {{ $user->name }}
                  </option>
                  @endforeach
               </select>
            </div>
            <!-- Consignee GST -->
            <div class="col-md-3">
               <label class="form-label">🧾 Consignee GST</label>
               <input type="text" name="lrs[${newLrIndex}][consignee_gst]" class="form-control consignee-gst" readonly>
            </div>
            <!-- Consignee Unloading Address -->
            <div class="col-md-3">
               <label class="form-label">📍 Unloading Address</label>
               <input type="text" name="lrs[${newLrIndex}][consignee_unloading]" class="form-control consignee-unloading" readonly>
            </div>
         </div>
         
         <div class="row">
            <!-- Vehicle Date -->
            <div class="col-md-4">
               <div class="mb-3">
                  <label class="form-label">📅 Vehicle Date</label>
                  <input type="date" name="lrs[${newLrIndex}][vehicle_date]" class="form-control">
               </div>
            </div>
            <!-- Vehicle Type -->
            <div class="col-md-4">
               <div class="mb-3">
                  <label class="form-label">🚛 Vehicle Type</label>
                  <select name="lrs[${newLrIndex}][vehicle_type]" class="form-select">
                     <option value="">Select Vehicle</option>
                     @foreach ($vehicles as $vehicle)
                     <option value="{{ $vehicle->vehicle_type . '|' . $vehicle->vehicle_no }}">
                        {{ $vehicle->vehicle_type }} - {{ $vehicle->vehicle_no }}
                     </option>
                     @endforeach
                  </select>
               </div>
            </div>
            <!-- Vehicle Ownership -->
            <div class="col-md-4">
               <label class