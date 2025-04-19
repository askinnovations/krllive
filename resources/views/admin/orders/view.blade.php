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
               <input type="text" name="order_id" class="form-control" value="{{ $order->order_id }}" readonly required>
            </div>
            <div class="col-md-3">
               <label>📝 Description</label>
               <textarea name="description" class="form-control" readonly>{{ $order->description }}</textarea required>
            </div>
            <div class="col-md-3">
               <label>📅 Date</label>
               <input type="date" name="order_date" class="form-control" value="{{ $order->order_date }}" required readonly>
            </div>
            <div class="col-md-3">
               <label>📊 Status</label>
               <select name="status" class="form-select" required readonly>
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
                  <select name="customer_id" id="customer_id" class="form-select" onchange="setCustomerDetails()" required readonly>
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
                  <input type="text" name="gst_number" id="gst_number" value="{{ old('gst_number', isset($order) ? $order->customer_gst : '') }}" class="form-control" readonly required>
               </div>
            </div>
            <!-- CUSTOMER ADDRESS (Auto-filled) -->
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📍 CUSTOMER ADDRESS</label>
                  <input type="text" name="customer_address" id="customer_address"  value="{{ old('customer_address', isset($order) ? $order->customer_address : '') }}"  class="form-control" readonly required>
               </div>
            </div>
            <!-- ORDER TYPE -->
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📊 Order Type</label>
                  
                  <select name="order_type" class="form-select" required>
                     <option value="">Select Order Type</option>
                     @php
                     $orderType = old('order_type', isset($order) ? $order->order_type : '');
                     
                     @endphp
                    
                     <option value="import" {{ $orderType === 'import' ? 'selected' : '' }}>Import</option>
                     <option value="import-restoff" {{ $orderType === 'import-restoff' ? 'selected' : '' }}>Import Restoff</option>
                     <option value="export" {{ $orderType === 'export' ? 'selected' : '' }}>Export</option>
                     <option value="export_restoff" {{ $orderType === 'export-restoff' ? 'selected' : '' }}>Export Restoff</option>
                     <option value="domestic" {{ $orderType === 'domestic' ? 'selected' : '' }}>Domestic</option>
                  </select>
               </div>
            </div>
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📍 PICKUP ADDRESS</label>
                  <input type="text" name="pickup_addresss" id="pickup_addresss" value="{{ old('pickup_addresss', isset($order) ? $order->pickup_addresss : '') }}" class="form-control"  placeholder="Pickup Addresss" readonly>
               </div>
            </div>
            
            <!-- DEliver adddress   -->
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📍DELEIEIVER ADDRESS</label>
                  <input type="text" name="deleiver_addresss" id="deleiver_addresss" class="form-control" value="{{ old('deleiver_addresss', isset($order) ? $order->deleiver_addresss : '') }}"  placeholder="Deleiver Addresss" readonly>
               </div>
            </div>
            @php
               $method = old('order_method', $order->order_method ?? '');
               $orderAmount = old('order_amount', $order->byorder ?? '');
               $contractNumber = old('contract_number', $order->bycontract?? '');
               @endphp

           <div class="col-md-3">
           <div class="mb-3">
               <label class="form-label">📑 Order Method</label><br>

               <div class="form-check form-check-inline">
               <input 
                   class="form-check-input" 
                   type="radio" 
                   name="order_method" 
                   id="byOrder" 
                   value="order" 
                   onclick="toggleOrderMethod()" 
                   {{ $method == 'order' ? 'checked' : '' }}>
               <label class="form-check-label" for="byOrder">By Order</label>
               </div>

               <div class="form-check form-check-inline">
               <input 
                   class="form-check-input" 
                   type="radio" 
                   name="order_method" 
                   id="byContract" 
                   value="contract" 
                   onclick="toggleOrderMethod()" 
                   {{ $method == 'contract' ? 'checked' : '' }}>
               <label class="form-check-label" for="byContract">By Contract</label>
               </div>
           </div>

         </div>
         <!-- lr  -->
         @php
         $lrData = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
         @endphp
         @foreach($lrData as $index => $lr)
         <div class="row mt-4" id="lr-section">
            <!-- <h4 style="margin-bottom: 2%;">🚚 Update LR - Consignment Details</h4> -->
            <div class="row g-3 mb-3 single-lr-row">
               <div class="col-md-3">
                  <label class="form-label">Lr Number</label>
                  <input required
                     type="number" 
                     name="lr_number" 
                     class="form-control" 
                     placeholder="Enter lr number" 
                     value="{{ $lr['lr_number'] ?? '' }}" readonly>
               </div>
               <div class="col-md-3">
                  <label class="form-label">Lr Date</label>
                  <input required
                     type="date" 
                     name="lr_date" 
                     class="form-control" 
                     placeholder="Enter lr number" 
                     value="{{ $lr['lr_date'] ?? '' }}" readonly>
               </div>
               <!-- Consignor Dropdown -->
               <div class="col-md-3">
                  <label class="form-label">🚚 Consignor Name</label>
                  <select name="lr[{{ $index }}][consignor_id]" 
                     id="consignor_id_{{ $index }}" 
                     class="form-select" 
                     readonly
                     onchange="setConsignorDetails({{ $index }})" required>
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
                     $isSelected = old("lr.$index.consignor_id", $lr['consignor_id'] ?? '') == $user->id;
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
               <!-- GST Field -->
               <div class="col-md-3">
                  <label class="form-label">🧾 Consignor GST</label>
                  <input type="text" readonly
                  name="lr[{{ $index }}][consignor_gst]" 
                  id="consignor_gst_{{ $index }}" 
                  value="{{ old("lr.$index.consignor_gst", $lr['consignor_gst'] ?? '') }}" 
                  class="form-control" readonly required>
               </div>
               <!-- Address Field -->
               <div class="col-md-3">
                  <label class="form-label">📍 Loading Address</label>
                  <input type="text" readonly
                  name="lr[{{ $index }}][consignor_loading]" 
                  id="consignor_loading_{{ $index }}" 
                  value="{{ old("lr.$index.consignor_loading", $lr['consignor_loading'] ?? '') }}" 
                  class="form-control" readonly required>
               </div>
               <!-- Consignee Name -->
               <div class="col-md-3">
                  <label class="form-label">🏢 Consignee Name</label>
                  <select name="lr[{{ $index }}][consignee_id]" 
                  readonly
                     id="consignee_id_{{ $index }}" 
                     class="form-select" 
                     onchange="setConsigneeDetails({{ $index }})" required>
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
                     $isSelected = old("lr.$index.consignee_id", $lr['consignee_id'] ?? '') == $user->id;
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
                  <input type="text"  readonly
                  name="lr[{{ $index }}][consignee_gst]" 
                  id="consignee_gst_{{ $index }}" 
                  value="{{ old("lr.$index.consignee_gst", $lr['consignee_gst'] ?? '') }}" 
                  class="form-control" readonly required>
               </div>
               <!-- Consignee Unloading Address -->
               <div class="col-md-3">
                  <label class="form-label">📍 Unloading Address</label>
                  <input type="text" readonly
                  name="lr[{{ $index }}][consignee_unloading]" 
                  id="consignee_unloading_{{ $index }}" 
                  value="{{ old("lr.$index.consignee_unloading", $lr['consignee_unloading'] ?? '') }}" 
                  class="form-control" readonly required>
               </div>
            </div>
            <div class="row">
               <!-- LR Date -->
              
               <div class="col-md-4">
                  <label class="form-label">🚛 Vehicle Number</label>
                  <select name="lr[{{ $index }}][vehicle_no]" class="form-select">
                      <option value="">Select Vehicle</option>
                      @foreach ($vehicles as $vehicle)
                          <option value="{{ $vehicle->vehicle_no }}" 
                              {{ (isset($lr['vehicle_no']) && $lr['vehicle_no'] == $vehicle->vehicle_no) ? 'selected' : '' }}>
                              {{ $vehicle->vehicle_no }}
                          </option>
                      @endforeach
                  </select>
              </div>
               <!-- Vehicle Type (Vehicle ID from vehicles table) -->
               
               <!-- Vehicle Dropdown -->
               <div class="col-md-4">
                  <label class="form-label">🚛 Vehicle</label>
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
             
                 $selectedVehicle = old("lr.$index.vehicle_type", $lr['vehicle_type'] ?? '');
             @endphp
             
             <select name="lr[{{ $index }}][vehicle_type]" 
                     
                     class="form-select" 
                     onchange="fillVehicleDetails({{ $index }})"
                     readonly>
                 <option value="">Select Vehicle</option>
             
                 @foreach ($vehicleOptions as $option)
                     <option value="{{ $option }}" {{ $selectedVehicle == $option ? 'selected' : '' }}>
                         {{ $option }}
                     </option>
                 @endforeach
                  </select>
               </div>
               <!-- Vehicle Ownership -->
               <div class="col-md-4">
                  <label class="form-label">🛻 Vehicle Ownership</label>
                  <div class="d-flex gap-3">
                     <div class="form-check">
                        <input class="form-check-input" readonly
                        type="radio" 
                        name="lr[{{ $index }}][vehicle_ownership]" 
                        id="ownership_own_{{ $index }}" 
                        value="Own"
                        {{ old("lr.$index.vehicle_ownership", $lr['vehicle_ownership']) == 'Own' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ownership_own_{{ $index }}">Own</label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" readonly
                        type="radio" 
                        name="lr[{{ $index }}][vehicle_ownership]" 
                        id="ownership_other_{{ $index }}" 
                        value="Other"
                        {{ old("lr.$index.vehicle_ownership", $lr['vehicle_ownership']) == 'Other' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ownership_other_{{ $index }}">Other</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <!-- Delivery Mode -->
               <div class="col-md-4">
                  <div class="mb-3">
                     <label class="form-label">🚢 Delivery Mode</label>
                     <select name="lr[{{ $index }}][delivery_mode]" class="form-select" required>
                        <option value="">Select Mode</option>
                        <option value="Road" {{ old("lr.$index.delivery_mode", $lr['delivery_mode']) == 'door delivery' ? 'selected' : '' }}>Door Deliver</option>
                        <option value="Rail" {{ old("lr.$index.delivery_mode", $lr['delivery_mode']) == 'godwon_deliver' ? 'selected' : '' }}>Godwon Deliver</option>
                        
                     </select>
                  </div>
               </div>
               <!-- From Location -->
               <div class="col-md-4">
                  <div class="mb-3">
                     <label class="form-label">📍 From (Origin)</label>
                     <select name="lr[{{ $index }}][from_location]" class="form-select" required readonly>
                        <option value="">Select Origin</option>
                        <option value="Mumbai" {{ old("lr.$index.from_location", $lr['from_location']) == 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                        <option value="Delhi" {{ old("lr.$index.from_location", $lr['from_location']) == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                        <option value="Chennai" {{ old("lr.$index.from_location", $lr['from_location']) == 'Chennai' ? 'selected' : '' }}>Chennai</option>
                     </select>
                  </div>
               </div>
               <!-- To Location -->
               <div class="col-md-4">
                  <div class="mb-3">
                     <label class="form-label">📍 To (Destination)</label>
                     <select name="lr[{{ $index }}][to_location]" class="form-select" required readonly>
                        <option value="">Select Destination</option>
                        <option value="Kolkata" {{ old("lr.$index.to_location", $lr['to_location']) == 'Kolkata' ? 'selected' : '' }}>Kolkata</option>
                        <option value="Hyderabad" {{ old("lr.$index.to_location", $lr['to_location']) == 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
                        <option value="Pune" {{ old("lr.$index.to_location", $lr['to_location']) == 'Pune' ? 'selected' : '' }}>Pune</option>
                     </select>
                  </div>
               </div>
            </div>
            <div class="row mt-4">
               @php
               $lrIndex = $loop->index ?? 0;
               $cargoData = isset($lr['cargo']) && is_array($lr['cargo']) 
               ? collect($lr['cargo'])->filter(fn($item) => isset($item['packages_no']) && $item['packages_no'] !== null)->values()
               : collect();
               @endphp
               <div class="col-12" data-lr-index="{{ $lrIndex }}">
                  <h5 class="mb-3 pb-3">📦 Cargo Description (LR #{{ $lrIndex + 1 }})</h5>
                  <div class="table-responsive">
                     <table class="table table-bordered align-middle text-center">
                        <thead>
                           <tr>
                              <th>No. of Packages</th>
                              <th>Packaging Type</th>
                              <th>Description</th>
                              {{-- <th>Weight (kg)</th> --}}
                              <th>Actual Weight (kg)</th>
                              <th>Charged Weight (kg)</th>
                              <th>&nbsp;Unit&nbsp;&nbsp;</th>
                              <th>Document No.</th>
                              <th>Document Name</th>
                              <th>Document Date</th>
                              <th>Eway Bill</th>
                              <th>Valid Upto</th>
                              <th>Declared value</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody id="cargoTableBody-{{ $lrIndex }}">
                           @foreach ($cargoData as $cargoIndex => $cargo)
                           <tr>
                              <td><input type="number" name="lr[{{ $lrIndex }}][cargo][{{ $cargoIndex }}][packages_no]" class="form-control" value="{{ $cargo['packages_no'] }}" required readonly></td>
                              <td>
                                 <select name="lr[{{ $lrIndex }}][cargo][{{ $cargoIndex }}][package_type]" class="form-select" required>
                                 <option value="Pallets" {{ $cargo['package_type'] == 'Pallets' ? 'selected' : '' }}>Pallets</option>
                                 <option value="Cartons" {{ $cargo['package_type'] == 'Cartons' ? 'selected' : '' }}>Cartons</option>
                                 <option value="Bags" {{ $cargo['package_type'] == 'Bags' ? 'selected' : '' }}>Bags</option>
                                 </select>
                              </td>
                              <td><input type="text" name="lr[{{ $lrIndex }}][cargo][{{ $cargoIndex }}][package_description]" class="form-control" value="{{ $cargo['package_description'] }}" required readonly></td>
                              {{-- <td><input type="number" name="lr[{{ $lrIndex }}][cargo][{{ $cargoIndex }}][weight]" class="form-control" value="{{ $cargo['weight'] }}" required readonly></td> --}}
                              <td><input type="number" name="lr[{{ $lrIndex }}][cargo][{{ $cargoIndex }}][actual_weight]" class="form-control" value="{{ $cargo['actual_weight'] }}" required readonly></td>
                              <td><input type="number" name="lr[{{ $lrIndex }}][cargo][{{ $cargoIndex }}][charged_weight]" class="form-control" value="{{ $cargo['charged_weight'] }}" required readonly></td>
                              <td>
                                 <select class="form-select" name="lr[{{ $lrIndex }}][cargo][0][unit]" required>
                                     <option value="">Select Unit</option>
                                     <option value="kg" {{ ($cargo['unit'] ?? '') == 'kg' ? 'selected' : '' }}>Kg</option>
                                     <option value="ton" {{ ($cargo['unit'] ?? '') == 'ton' ? 'selected' : '' }}>Ton</option>
                                 </select>
                                </td>
                              <td><input type="text" name="lr[{{ $lrIndex }}][cargo][{{ $cargoIndex }}][document_no]" class="form-control" value="{{ $cargo['document_no'] }}" required readonly></td>
                              <td><input type="text" name="lr[{{ $lrIndex }}][cargo][{{ $cargoIndex }}][document_name]" class="form-control" value="{{ $cargo['document_name'] }}" required readonly></td>
                              <td><input type="date" name="lr[{{ $lrIndex }}][cargo][{{ $cargoIndex }}][document_date]" class="form-control" value="{{ $cargo['document_date'] }}" required readonly></td>
                              <td><input type="text" name="lr[{{ $lrIndex }}][cargo][{{ $cargoIndex }}][eway_bill]" class="form-control" value="{{ $cargo['eway_bill'] }}" required readonly></td>
                              <td><input type="date" name="lr[{{ $lrIndex }}][cargo][{{ $cargoIndex }}][valid_upto]" class="form-control" value="{{ $cargo['valid_upto'] }}" required readonly></td>
                              <td>
                                 <input  name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][declared_value]"
                                       type="number" 
                                       value="{{ $cargo['declared_value'] }}" 
                                       class="form-control declared-value"  
                                       readonly 
                                      ></td>
                                 
                               
                              <td>
                                 <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button>
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                     <!-- Add Row Button for this LR -->
                     <!-- <div class="text-end mt-2">
                        <button type="button" class="btn btn-sm btn-primary" onclick="addRow({{ $lrIndex }})">
                        ➕ Add Row
                        </button>
                     </div> -->
                  </div>
               </div>
               <!-- Freight Details Section  -->
               <div class="row mt-4">
                  <div class="col-12">
                     <h5 class="pb-3">🚚 Freight Details (LR {{ $lrIndex + 1 }})</h5>
                     @php $freightType = $lr['freightType'] ?? 'paid'; @endphp

                     <div class="mb-3 d-flex gap-3">
                         <div class="form-check form-check-inline">
                             <input class="form-check-input freight-type"
                                    type="radio"
                                    name="lr[freightType]"
                                    id="freightPaid"
                                    value="paid"
                                    onchange="toggleFreightTable()"
                                    {{ $freightType === 'paid' ? 'checked' : '' }}>
                             <label class="form-check-label" for="freightPaid">Paid</label>
                         </div>
                     
                         <div class="form-check form-check-inline">
                             <input class="form-check-input freight-type"
                                    type="radio"
                                    name="lr[freightType]"
                                    id="freightToPay"
                                    value="to_pay"
                                    onchange="toggleFreightTable()"
                                    {{ $freightType === 'to_pay' ? 'checked' : '' }}>
                             <label class="form-check-label" for="freightToPay">To Pay</label>
                         </div>
                     
                         <div class="form-check form-check-inline">
                             <input class="form-check-input freight-type"
                                    type="radio"
                                    name="lr[freightType]"
                                    id="freightToBeBilled"
                                    value="to_be_billed"
                                    onchange="toggleFreightTable()"
                                    {{ $freightType === 'to_be_billed' ? 'checked' : '' }}>
                             <label class="form-check-label" for="freightToBeBilled">To Be Billed</label>
                         </div>
                     </div>
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
                                 <td><input name="lr[{{ $lrIndex }}][freight_amount]" type="number" class="form-control"
                                    value="{{ $lr['freight_amount'] ?? '' }}" placeholder="Enter Freight Amount" required readonly></td>
                                 <td><input name="lr[{{ $lrIndex }}][lr_charges]" type="number" class="form-control"
                                    value="{{ $lr['lr_charges'] ?? '' }}" placeholder="Enter LR Charges" required readonly></td>
                                 <td><input name="lr[{{ $lrIndex }}][hamali]" type="number" class="form-control"
                                    value="{{ $lr['hamali'] ?? '' }}" placeholder="Enter Hamali Charges" required readonly></td>
                                 <td><input name="lr[{{ $lrIndex }}][other_charges]" type="number" class="form-control"
                                    value="{{ $lr['other_charges'] ?? '' }}" placeholder="Enter Other Charges" required readonly></td>
                                 <td><input name="lr[{{ $lrIndex }}][gst_amount]" type="number" class="form-control"
                                    value="{{ $lr['gst_amount'] ?? '' }}" placeholder="Enter GST Amount" required readonly></td>
                                 <td><input name="lr[{{ $lrIndex }}][total_freight]" type="number" class="form-control"
                                    value="{{ $lr['total_freight'] ?? '' }}" placeholder="Total Freight" required readonly></td>
                                 <td><input name="lr[{{ $lrIndex }}][less_advance]" type="number" class="form-control"
                                    value="{{ $lr['less_advance'] ?? '' }}" placeholder="Less Advance Amount" required readonly></td>
                                 <td><input name="lr[{{ $lrIndex }}][balance_freight]" type="number" class="form-control"
                                    value="{{ $lr['balance_freight'] ?? '' }}" placeholder="Balance Freight Amount" required readonly></td>
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
                       
                        <input type="text" id="totalDeclaredValue-{{ $index }}" name="lr[{{ $index }}][total_declared_value]" value="{{ $lr['total_declared_value'] ?? '' }}" class="form-control" readonly>

                     </div>
                  </div>
               </div>
               <!-- Remove / Add More LR Buttons -->
               <div class="d-flex justify-content-end gap-2 mt-3">
                  <!-- <button type="button" class="btn btn-outline-warning btn-sm removeLRBtn" data-id="lrItem${counter}" onclick="removeLrRow(this)">
                  <i class="fas fa-trash-alt"></i> Remove
                  </button>
                  <button type="button" class="btn btn-sm addMoreLRBtn" data-id="lrItem${counter}" style="background-color: #ca2639; color: #fff;" onclick="addLrRow()">
                  <i class="fas fa-plus-circle"></i> Add More LR - Consignment
                  </button> -->
               </div>
               <div class="row">
                  <!-- Submit Button -->
                  <div class="row mt-4 mb-4">
                     <div class="col-12 text-center">
                        <!-- <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Consignment 
                        </button> -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- lr -->
         @endforeach
         <div id="lr-container"></div>
      </div>
   </div>
</form>
<script>
   function setCustomerDetails() {
       const selected = document.getElementById('customer_id');
       const gst = selected.options[selected.selectedIndex].getAttribute('data-gst');
       const address = selected.options[selected.selectedIndex].getAttribute('data-address');
   
       document.getElementById('gst_number').value = gst || '';
       document.getElementById('customer_address').value = address || '';
   }
   
   // Call on page load (for edit mode)
   document.addEventListener('DOMContentLoaded', function () {
       const customerSelect = document.getElementById('customer_id');
       if (customerSelect.value !== '') {
           setCustomerDetails();
       }
   });
</script>
<!-- Script to Set Values -->
<script>
   function setConsignorDetails(index) {
       const select = document.getElementById(`consignor_id_${index}`);
       const gst = select.options[select.selectedIndex].getAttribute('data-gst-consignor');
       const address = select.options[select.selectedIndex].getAttribute('data-address-consignor');
   
       document.getElementById(`consignor_gst_${index}`).value = gst || '';
       document.getElementById(`consignor_loading_${index}`).value = address || '';
   }
   
   // Run on page load (edit mode)
   document.addEventListener('DOMContentLoaded', function () {
       const totalLrCount = {{ count($order->lr) }};
       for (let i = 0; i < totalLrCount; i++) {
           const select = document.getElementById(`consignor_id_${i}`);
           if (select && select.value !== '') {
               setConsignorDetails(i);
           }
       }
   });
   
   
   
       
</script>
<script>
   function setConsigneeDetails(index) {
      const selected = document.getElementById('consignee_id_' + index);
      const gst = selected.options[selected.selectedIndex].getAttribute('data-gst-consignee');
      const address = selected.options[selected.selectedIndex].getAttribute('data-address-consignee');
   
      document.getElementById('consignee_gst_' + index).value = gst || '';
      document.getElementById('consignee_unloading_' + index).value = address || '';
   }
   
   // Call on page load (for edit mode)
   document.addEventListener('DOMContentLoaded', function () {
      const lrCount = {{ count($order['lr'] ?? []) }}; // Total LR entries
      for (let i = 0; i < lrCount; i++) {
         const consigneeSelect = document.getElementById('consignee_id_' + i);
         if (consigneeSelect && consigneeSelect.value !== '') {
            setConsigneeDetails(i);
         }
      }
   });
</script>
<!-- JavaScript to Add & Remove LR Consignments -->
<script>
   var vehicles = @json($vehicles);
   
   // Function जो vehicles array से options generate करेगा
   function generateVehicleOptions() {
       let options = '<option value="">Select Vehicle</option>';
       vehicles.forEach(function(vehicle) {
           // यहाँ आप अपनी आवश्यकता के अनुसार vehicle का display नाम बना सकते हैं
           options += `<option value="${vehicle.id}">${vehicle.vehicle_type} - ${vehicle.vehicle_no}</option>`;
       });
       return options;
   }
</script>
<!-- add more lr  -->
<script>
   function addLrRow() {
    // Get the current count of LR sections
    const lrSections = document.querySelectorAll('#lr-section');
    const counter = lrSections.length;
    
    // Create a new LR section with the same HTML structure
    const newLrSection = document.createElement('div');
    newLrSection.className = 'row mt-4';
    newLrSection.id = 'lr-section';
    
    // Set the HTML content with updated counter values
    newLrSection.innerHTML = `
        <h4 style="margin-bottom: 2%;">🚚 Update LR - Consignment Details</h4>
        <div class="row g-3 mb-3 single-lr-row">
            <div class="col-md-3">
                <label class="form-label">Lr Number</label>
                <input 
                    type="number" 
                    name="lr[${counter}][lr_number]" 
                    class="form-control" 
                    placeholder="Enter lr number" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Lr Date</label>
                <input 
                    type="date" 
                    name="lr[${counter}][lr_date]" 
                    class="form-control" 
                    placeholder="Enter lr number" required>
            </div>
            <!-- Consignor Name -->
            <div class="col-md-3">
                <label class="form-label">🚚 Consignor Name</label>
                <select name="lr[${counter}][consignor_id]" class="form-select" onchange="setConsignorDetails(this)" required>
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
                <input type="text" name="lr[${counter}][consignor_gst]" class="form-control" readonly required>
            </div>
   
            <!-- Consignor Loading Address -->
            <div class="col-md-3">
                <label class="form-label">📍 Loading Address</label>
                <input type="text" name="lr[${counter}][consignor_loading]" class="form-control" readonly required>
            </div>
            
            <!-- Consignee Name -->
            <div class="col-md-3">
                <label class="form-label">🏢 Consignee Name</label>
                <select name="lr[${counter}][consignee_id]" class="form-select" onchange="setConsigneeDetails(this)" required>
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
                <input type="text" name="lr[${counter}][consignee_gst]" class="form-control" readonly required>
            </div>
            
            <!-- Consignee Unloading Address -->
            <div class="col-md-3">
                <label class="form-label">📍 Unloading Address</label>
                <input type="text" name="lr[${counter}][consignee_unloading]" class="form-control" readonly required>
            </div>
        </div>
        
        <div class="row">
            <!-- Vehicle Date -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">📅 Vehicle Date</label>
                    <input type="date" name="lr[${counter}][vehicle_date]" class="form-control" required>
                </div>
            </div>
            
            <!-- Vehicle Type -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">🚛 Vehicle Type</label>
                    <select name="lr[${counter}][vehicle_type]" class="form-select" required>
                        <option value="">Select Vehicle</option>
                        @foreach ($vehicles as $vehicle)
                            <option value="{{ $vehicle->vehicle_type }}|{{ $vehicle->vehicle_no }}">
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
                        <input class="form-check-input" type="radio" name="lr[${counter}][vehicle_ownership]" value="Own" required>
                        <label class="form-check-label">Own</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="lr[${counter}][vehicle_ownership]" value="Other" required>
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
                    <select name="lr[${counter}][delivery_mode]" class="form-select" required>
                        <option value="">Select Mode</option>
                        <option value="Road">Road</option>
                        <option value="Rail">Rail</option>
                        <option value="Air">Air</option>
                    </select>
                </div>
            </div>
            
            <!-- From Location -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">📍 From (Origin)</label>
                    <select name="lr[${counter}][from_location]" class="form-select" required>
                        <option value="">Select Origin</option>
                        <option value="Mumbai">Mumbai</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Chennai">Chennai</option>
                    </select>
                </div>
            </div>
            
            <!-- To Location -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">📍 To (Destination)</label>
                    <select name="lr[${counter}][to_location]" class="form-select" required>
                        <option value="">Select Destination</option>
                        <option value="Kolkata">Kolkata</option>
                        <option value="Hyderabad">Hyderabad</option>
                        <option value="Pune">Pune</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <h5 class="mb-3 pb-3">📦 Cargo Description</h5>
                <!-- Documentation Selection -->
                <div class="mb-3 d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="lr[${counter}][cargo_description_type]" value="single" checked required>
                        <label class="form-check-label">Single Document</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="lr[${counter}][cargo_description_type]" value="multiple" required>
                        <label class="form-check-label">Multiple Documents</label>
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
                        <tbody>
                            <tr>
                                <td><input type="number" name="lr[${counter}][cargo][0][packages_no]" class="form-control" required></td>
                                <td>
                                    <select name="lr[${counter}][cargo][0][package_type]" class="form-select" required>
                                        <option value="Pallets">Pallets</option>
                                        <option value="Cartons">Cartons</option>
                                        <option value="Bags">Bags</option>
                                    </select>
                                </td>
                                <td><input type="text" name="lr[${counter}][cargo][0][package_description]" class="form-control" required></td>
                                <td><input type="number" name="lr[${counter}][cargo][0][weight]" class="form-control" required></td>
                                <td><input type="number" name="lr[${counter}][cargo][0][actual_weight]" class="form-control" required></td>
                                <td><input type="number" name="lr[${counter}][cargo][0][charged_weight]" class="form-control" required></td>
                                <td><input type="text" name="lr[${counter}][cargo][0][document_no]" class="form-control" required></td>
                                <td><input type="text" name="lr[${counter}][cargo][0][document_name]" class="form-control" required></td>
                                <td><input type="date" name="lr[${counter}][cargo][0][document_date]" class="form-control" required></td>
                                <td><input type="text" name="lr[${counter}][cargo][0][eway_bill]" class="form-control"required></td>
                                <td><input type="date" name="lr[${counter}][cargo][0][valid_upto]" class="form-control" required></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Add Row Button -->
                <div class="text-end mt-2">
                    <button type="button" class="btn btn-sm" style="background: #ca2639; color: white;" onclick="addCargoRow(this, ${counter})">
                        <span style="filter: invert(1);">➕</span> Add Row
                    </button>
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
                                    <td><input name="lr[${counter}][freight_amount]" type="number" class="form-control" placeholder="Enter Freight Amount" required></td>
                                    <td><input name="lr[${counter}][lr_charges]" type="number" class="form-control" placeholder="Enter LR Charges" required></td>
                                    <td><input name="lr[${counter}][hamali]" type="number" class="form-control" placeholder="Enter Hamali Charges" required></td>
                                    <td><input name="lr[${counter}][other_charges]" type="number" class="form-control" placeholder="Enter Other Charges" required></td>
                                    <td><input name="lr[${counter}][gst_amount]" type="number" class="form-control" placeholder="Enter GST Amount" required></td>
                                    <td><input name="lr[${counter}][total_freight]" type="number" class="form-control" placeholder="Total Freight" required></td>
                                    <td><input name="lr[${counter}][less_advance]" type="number" class="form-control" placeholder="Less Advance Amount" required></td>
                                    <td><input name="lr[${counter}][balance_freight]" type="number" class="form-control" placeholder="Balance Freight Amount" required></td>
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
                        <input type="number" name="lr[${counter}][declared_value]" class="form-control" required>
                    </div>
                </div>
            </div>
            
            <!-- Remove / Add More LR Buttons -->
            <div class="d-flex justify-content-end gap-2 mt-3">
                // <button type="button" class="btn btn-outline-warning btn-sm removeLRBtn" onclick="removeLrRow(this)">
                //     <i class="fas fa-trash-alt"></i> Remove
                // </button>
                // <button type="button" class="btn btn-sm addMoreLRBtn" style="background-color: #ca2639; color: #fff;" onclick="addLrRow()">
                //     <i class="fas fa-plus-circle"></i> Add More LR - Consignment
                // </button>
            </div>
        </div>
    `;
    
    // Append the new LR section to the container
    const lrContainer = document.querySelector('#lr-container') || document.body;
    lrContainer.appendChild(newLrSection);
    
    // Initialize any required JavaScript for the new section
    initNewLrSection(newLrSection);
   }
   
   // Helper function to initialize JavaScript for new LR sections
   function initNewLrSection(section) {
    // Initialize any date pickers, select2, etc.
    // You can add any initialization code needed for the new elements here
   }
   
   // Function to remove an LR section
   function removeLrRow(button) {
    const lrSection = button.closest('.row.mt-4');
    if (lrSection) {
        lrSection.remove();
    }
   }
   
   // Function to add a new cargo row
   function addCargoRow(button, lrIndex) {
    const tbody = button.closest('.row.mt-4').querySelector('#cargoTableBody') || 
                 button.closest('.row.mt-4').querySelector('table tbody');
    
    const rowCount = tbody.querySelectorAll('tr').length;
    
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td><input type="number" name="lr[${lrIndex}][cargo][${rowCount}][packages_no]" class="form-control"></td>
        <td>
            <select name="lr[${lrIndex}][cargo][${rowCount}][package_type]" class="form-select">
                <option value="Pallets">Pallets</option>
                <option value="Cartons">Cartons</option>
                <option value="Bags">Bags</option>
            </select>
        </td>
        <td><input type="text" name="lr[${lrIndex}][cargo][${rowCount}][package_description]" class="form-control" required></td>
        <td><input type="number" name="lr[${lrIndex}][cargo][${rowCount}][weight]" class="form-control" required></td>
        <td><input type="number" name="lr[${lrIndex}][cargo][${rowCount}][actual_weight]" class="form-control" required></td>
        <td><input type="number" name="lr[${lrIndex}][cargo][${rowCount}][charged_weight]" class="form-control" required></td>
        <td><input type="text" name="lr[${lrIndex}][cargo][${rowCount}][document_no]" class="form-control" required></td>
        <td><input type="text" name="lr[${lrIndex}][cargo][${rowCount}][document_name]" class="form-control" required></td>
        <td><input type="date" name="lr[${lrIndex}][cargo][${rowCount}][document_date]" class="form-control" required></td>
        <td><input type="text" name="lr[${lrIndex}][cargo][${rowCount}][eway_bill]" class="form-control" required></td>
        <td><input type="date" name="lr[${lrIndex}][cargo][${rowCount}][valid_upto]" class="form-control" required></td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button>
        </td>
    `;
    
    tbody.appendChild(newRow);
   }
   
   // Function to remove a row from cargo table
   function removeRow(button) {
    const row = button.closest('tr');
    if (row) {
        row.remove();
    }
   }
</script>

<!-- JS -->
<script>
   function addRow(lrIndex) {
      const tableBody = document.getElementById(`cargoTableBody-${lrIndex}`);
      const rowCount = tableBody.rows.length;
      const newRow = tableBody.rows[0].cloneNode(true);
   
      // Update name attributes and clear values
      [...newRow.querySelectorAll('input, select')].forEach((input) => {
         if (input.name) {
            input.name = input.name.replace(
               /lr\[\d+]\[cargo]\[\d+]/,
               `lr[${lrIndex}][cargo][${rowCount}]`
            );
            input.value = '';
         }
      });
   
      tableBody.appendChild(newRow);
   }
   
   function removeRow(button) {
      const row = button.closest('tr');
      const tbody = row.parentElement;
      if (tbody.rows.length > 1) {
         row.remove();
      }
   }
</script>
<!-- add cargo row -->
@endsection