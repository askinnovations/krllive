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
               <textarea name="description" class="form-control">{{ $order->description }}</textarea required>
            </div>
            <div class="col-md-3">
               <label>📅 Date</label>
               <input type="date" name="order_date" class="form-control" value="{{ $order->order_date }}" required>
            </div>
            <div class="col-md-3">
               <label>📊 Status</label>
               <select name="status" class="form-select" required>
               <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
               <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
               <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
               <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
               </select>
            </div>
            <!-- CUSTOMER NAME DROPDOWN -->
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">👤 Freight A/c </label>
                  <select name="customer_id" id="customer_id" class="form-select" onchange="setCustomerDetails()" required>
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
                   <input type="text" name="pickup_addresss" id="pickup_addresss" value="{{ old('pickup_addresss', isset($order) ? $order->pickup_addresss : '') }}" class="form-control"  placeholder="Pickup Addresss" required>
                </div>
             </div>
             <!-- DEliver adddress   -->
             <div class="col-md-3">
                <div class="mb-3">
                   <label class="form-label">📍DELEIEIVER ADDRESS</label>
                   <input type="text" name="deleiver_addresss" id="deleiver_addresss" class="form-control" value="{{ old('deleiver_addresss', isset($order) ? $order->deleiver_addresss : '') }}"  placeholder="Deleiver Addresss" required>
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

  <!-- Order Amount Input -->
        <div class="mb-3 {{ $method == 'order' ? '' : 'd-none' }}" id="orderAmountDiv">
            <label class="form-label">💰 Order Amount</label>
            <input type="number" name="byOrder" class="form-control" value="{{ $orderAmount }}" placeholder="Enter Amount" {{ $method == 'order' ? 'required' : '' }}>
        </div>

        <!-- Contract Number Input -->
        <div class="mb-3 {{ $method == 'contract' ? '' : 'd-none' }}" id="contractNumberDiv">
            <label class="form-label">📄 Contract Number</label>
            <input type="text" name="byContract" class="form-control" value="{{ $contractNumber }}" placeholder="Enter Contract Number" {{ $method == 'contract' ? 'required' : '' }}>
        </div>
        </div>
      </div>
         <!-- lr  -->
         @php
         $lrData = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
         @endphp
        
        {{-- @foreach($lrData as $index => $lr) --}}
        @foreach($lrData as $index => $lr)

         <div class="row mt-4" >
            <h4 style="margin-bottom: 2%;">🚚 Update LR - Consignment Details</h4>
            <div class="row g-3 mb-3 single-lr-row">
            <div class="col-md-3">
               <label class="form-label">LR Number</label>
               <input 
                    type="text" 
                    class="form-control" 
                    value="{{ $lr['lr_number'] ?? '' }}" 
                    disabled>

                <!-- Hidden field to submit the lr_number -->
                <input 
                    type="hidden" 
                    name="lr[{{ $index }}][lr_number]" 
                    value="{{ $lr['lr_number'] ?? '' }}">
            </div>

               <div class="col-md-3">
                  <label class="form-label">Lr Date</label>
                  <input required
                     type="date" 
                     
                     name="lr[{{ $index  }}][lr_date]" 
                     class="form-control" 
                     placeholder="Enter lr number" 
                     value="{{ $lr['lr_date'] ?? '' }}">
               </div>
               <!-- Consignor Dropdown -->
               <div class="col-md-3">
                  <label class="form-label">🚚 Consignor Name</label>
                  <select name="lr[{{ $index }}][consignor_id]" 
                     id="consignor_id_{{ $index }}" 
                     class="form-select" 
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
                  <input type="text" 
                  name="lr[{{ $index }}][consignor_gst]" 
                  id="consignor_gst_{{ $index }}" 
                  value="{{ old("lr.$index.consignor_gst", $lr['consignor_gst'] ?? '') }}" 
                  class="form-control" readonly required>
               </div>
               <!-- Address Field -->
               <div class="col-md-3">
                  <label class="form-label">📍 Loading Address</label>
                  <input type="text" 
                  name="lr[{{ $index }}][consignor_loading]" 
                  id="consignor_loading_{{ $index }}" 
                  value="{{ old("lr.$index.consignor_loading", $lr['consignor_loading'] ?? '') }}" 
                  class="form-control" readonly required>
               </div>
               <!-- Consignee Name -->
               <div class="col-md-3">
                  <label class="form-label">🏢 Consignee Name</label>
                  <select name="lr[{{ $index }}][consignee_id]" 
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
                  <input type="text" 
                  name="lr[{{ $index }}][consignee_gst]" 
                  id="consignee_gst_{{ $index }}" 
                  value="{{ old("lr.$index.consignee_gst", $lr['consignee_gst'] ?? '') }}" 
                  class="form-control" readonly required>
               </div>
               <!-- Consignee Unloading Address -->
               <div class="col-md-3">
                  <label class="form-label">📍 Unloading Address</label>
                  <input type="text" 
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
                  <select name="lr[{{ $index }}][vehicle_no]" 
                          id="vehicle_id_{{ $index }}" 
                          class="form-select" 
                          onchange="fillVehicleDetails({{ $index }})">
                      <option value="">Select Vehicle</option>
                      @foreach ($vehicles as $vehicle)
                          <option 
                              value="{{ $vehicle->vehicle_no }}"
                              data-no="{{ $vehicle->vehicle_no }}"
                              {{ old("lr.$index.vehicle_no", isset($lr['vehicle_no']) ? $lr['vehicle_no'] : '') == $vehicle->id ? 'selected' : '' }}>
                              {{ $vehicle->vehicle_no }}
                          </option>
                      @endforeach
                  </select>
              </div>
              
               <!-- Vehicle Type (Vehicle ID from vehicles table) -->
               {{-- @php
               $selectedVehicle = collect($vehicles)->firstWhere('id', $lr['vehicle_id']);
               @endphp --}}
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
                     required>
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
                        <input class="form-check-input" 
                        type="radio" 
                        name="lr[{{ $index }}][vehicle_ownership]" 
                        id="ownership_own_{{ $index }}" 
                        value="Own"
                        {{ old("lr.$index.vehicle_ownership", $lr['vehicle_ownership']) == 'Own' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ownership_own_{{ $index }}">Own</label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" 
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
                     <select name="lr[{{ $index }}][from_location]" class="form-select" required>
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
                     <select name="lr[{{ $index }}][to_location]" class="form-select" required>
                        <option value="">Select Destination</option>
                        <option value="Kolkata" {{ old("lr.$index.to_location", $lr['to_location']) == 'Kolkata' ? 'selected' : '' }}>Kolkata</option>
                        <option value="Hyderabad" {{ old("lr.$index.to_location", $lr['to_location']) == 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
                        <option value="Pune" {{ old("lr.$index.to_location", $lr['to_location']) == 'Pune' ? 'selected' : '' }}>Pune</option>
                     </select>
                  </div>
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
                      name="lr[{{ $index }}][insurance_description]" 
                      id="insuranceInput" 
                      placeholder="Enter Insurance Number" 
                      style="max-width: 450px;" 
                      value="{{ old('insurance_description') }}">
           </div>
            <div class="row mt-4">
               @php
               $lrIndex = $loop->index ?? 0;
               $cargoData = isset($lr['cargo']) && is_array($lr['cargo']) 
               ? collect($lr['cargo'])->filter(fn($item) => isset($item['packages_no']) && $item['packages_no'] !== null)->values()
               : collect();
               @endphp
               <div class="col-12" data-lr-index="{{ $lrIndex }}">
                  <h5 class="mb-3 pb-3">📦 Cargo Description (LR #{{ $lrIndex  }})</h5>
                  <div class="table-responsive">
                     <table class="table table-bordered align-middle text-center">
                        <thead>
                           <tr>
                              <th>No. of Packages</th>
                              <th>Packaging Type</th>
                              <th>Description</th>
                              <th>Actual Weight (kg)</th>
                              <th>Charged Weight (kg)</th>
                              <th>&nbsp;Unit&nbsp;&nbsp;</th>
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
                        <tbody id="cargoTableBody-{{ $index }}">
                           
                           @foreach ($lr['cargo'] as $cargoIndex => $cargo)
                           <tr>
                              
                               <td><input type="number" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][packages_no]" class="form-control" value="{{ $cargo['packages_no'] }}" required></td>
                               <td>
                                   <select name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][package_type]" class="form-select" required>
                                       <option value="Pallets" {{ $cargo['package_type'] == 'Pallets' ? 'selected' : '' }}>Pallets</option>
                                       <option value="Cartons" {{ $cargo['package_type'] == 'Cartons' ? 'selected' : '' }}>Cartons</option>
                                       <option value="Bags" {{ $cargo['package_type'] == 'Bags' ? 'selected' : '' }}>Bags</option>
                                   </select>
                               </td>
                               <td><input type="text" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][package_description]" class="form-control" value="{{ $cargo['package_description'] }}" required></td>
                              
                               <td><input type="number" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][actual_weight]" class="form-control" value="{{ $cargo['actual_weight'] }}" required></td>
                               <td><input type="number" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][charged_weight]" class="form-control" value="{{ $cargo['charged_weight'] }}" required></td>
                               <td>
                                <select class="form-select" name="lr[{{ $lrIndex }}][cargo][0][unit]" required>
                                    <option value="">Select Unit</option>
                                    <option value="kg" {{ ($cargo['unit'] ?? '') == 'kg' ? 'selected' : '' }}>Kg</option>
                                    <option value="ton" {{ ($cargo['unit'] ?? '') == 'ton' ? 'selected' : '' }}>Ton</option>
                                </select>
                               </td>
                               <td><input type="text" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][document_no]" class="form-control" value="{{ $cargo['document_no'] }}" required></td>
                               <td><input type="text" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][document_name]" class="form-control" value="{{ $cargo['document_name'] }}" required></td>
                               <td><input type="date" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][document_date]" class="form-control" value="{{ $cargo['document_date'] }}" required></td>
                               <td>
                                 <input type="file" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][document_file]" class="form-control" value="" >
                                 {{-- <div>
                                    @if($cargo['document_file'])
                                    <button type="button" 
                                    class="btn  openImageModal"
                                    data-image="{{ asset('storage/'.$cargo['document_file']) }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#imageModal">
                                   <p  class="text-info"> View </p>
                                </button>
                                    @endif
                                </div> --}}
                        
                                 {{-- <img src="{{ asset('storage/' .$cargo['document_file']) }}" width="150" class="img-thumbnail" alt="Document Image"> --}}
                           
                               </td>
                               <td><input type="text" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][eway_bill]" class="form-control" value="{{ $cargo['eway_bill'] }}" required></td>
                               <td><input type="date" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][valid_upto]" class="form-control" value="{{ $cargo['valid_upto'] }}" required></td>
                               <td>
                                 <input  name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][declared_value]"
                                       type="number" 
                                       value="{{ $cargo['declared_value'] }}" 
                                       class="form-control declared-value" 
                                       placeholder="0" 
                                       required 
                                       oninput="calculateTotalDeclaredValue({{ $index }})"></td>
                                 
                               <td>
                                   <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button>
                               </td>
                           </tr>
                       @endforeach
                       
                        </tbody>
                     </table>
                     <!-- Add Row Button for this LR -->
                     <div class="text-end mt-2">
                        <button type="button" class="btn btn-sm btn-primary" onclick="addRow({{ $index }})">
                        ➕ Add Row
                        </button>
                     </div>
                  </div>
               </div>
               <!-- Freight Details Section  -->
               <div class="row mt-4">
                  <div class="col-12">
                     <h5 class="pb-3">🚚 Freight Details </h5>
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
                                 
                                 <td><input name="lr[{{ $index }}][freight_amount]" type="number" class="form-control"
                                    value="{{ $lr['freight_amount'] ?? '' }}" placeholder="Enter Freight Amount" required></td>
                                 <td><input name="lr[{{ $index }}][lr_charges]" type="number" class="form-control"
                                    value="{{ $lr['lr_charges'] ?? '' }}" placeholder="Enter LR Charges" required></td>
                                 <td><input name="lr[{{ $index }}][hamali]" type="number" class="form-control"
                                    value="{{ $lr['hamali'] ?? '' }}" placeholder="Enter Hamali Charges" required></td>
                                 <td><input name="lr[{{ $index }}][other_charges]" type="number" class="form-control"
                                    value="{{ $lr['other_charges'] ?? '' }}" placeholder="Enter Other Charges" required></td>
                                 <td><input name="lr[{{ $index }}][gst_amount]" type="number" class="form-control"
                                    value="{{ $lr['gst_amount'] ?? '' }}" placeholder="Enter GST Amount" required></td>
                                 <td><input name="lr[{{ $index }}][total_freight]" type="number" class="form-control"
                                    value="{{ $lr['total_freight'] ?? '' }}" placeholder="Total Freight" required></td>
                                 <td><input name="lr[{{ $index }}][less_advance]" type="number" class="form-control"
                                    value="{{ $lr['less_advance'] ?? '' }}" placeholder="Less Advance Amount" required></td>
                                 <td><input name="lr[{{ $index }}][balance_freight]" type="number" class="form-control"
                                    value="{{ $lr['balance_freight'] ?? '' }}" placeholder="Balance Freight Amount" required></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <!-- Declared Value -->
               <div class="row mt-3">
                  <div class="col-md-6">
                     <div class="mt-3">
                        <label><strong>💰 Total Declared Value (Rs.)</strong></label>
                        <input type="text" id="totalDeclaredValue-{{ $index }}" name="lr[{{ $index }}][total_declared_value]" class="form-control" readonly>
                     </div>
                  </div>
               </div>
               
            </div>
         </div>
         <!-- lr -->
         @endforeach
         <div id="lrContainer">
         </div>
         <!-- Remove / Add More LR Buttons -->
               <div class="d-flex justify-content-end gap-2 mt-3">
                  
                  <button type="button" class="btn btn-sm addMoreLRBtn" data-id="lrItem${counter}" style="background-color: #ca2639; color: #fff;" onclick="addLrRow()">
                  <i class="fas fa-plus-circle"></i> Add More LR - Consignment
                  </button>
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
   </div>
</form>
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
   
 
   function generateVehicleOptions() {
  const vehicleOptions = [
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

  let options = '<option value="">Select Vehicle</option>';
  options += vehicleOptions.map(option => `<option value="${option}">${option}</option>`).join('');
  return options;
}
   function generateVehicle_noOptions() {
       let options = '<option value="">Select Vehicle No.</option>';
       vehicles.forEach(function(vehicle) {
           // यहाँ आप अपनी आवश्यकता के अनुसार vehicle का display नाम बना सकते हैं
           options += `<option value="${vehicle.id}"> ${vehicle.vehicle_no}</option>`;
       });
       return options;
   }
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
<!-- JS -->
<script>
   function calculateTotalDeclaredValue(index) {
       let total = 0;
       document.querySelectorAll(`#cargoTableBody-${index} .declared-value`).forEach(input => {
           total += parseFloat(input.value) || 0;
       });
       document.getElementById(`totalDeclaredValue-${index}`).value = total;
   }
   
   function addRow(index) {
       const tbody = document.getElementById(`cargoTableBody-${index}`);
       const row = document.createElement('tr');
   
       row.innerHTML = `
           <td><input type="number" name="cargo[${index}][][packages_no]" class="form-control"></td>
           <td>
               <select name="cargo[${index}][][package_type]" class="form-select">
                   <option value="Pallets">Pallets</option>
                   <option value="Cartons">Cartons</option>
                   <option value="Bags">Bags</option>
               </select>
           </td>
           <td><input type="text" name="cargo[${index}][][package_description]" class="form-control"></td>
           <td><input type="number" name="cargo[${index}][][actual_weight]" class="form-control"></td>
           <td><input type="number" name="cargo[${index}][][charged_weight]" class="form-control"></td>
           <td><input type="text" name="cargo[${index}][][document_no]" class="form-control"></td>
           <td><input type="text" name="cargo[${index}][][document_name]" class="form-control"></td>
           <td><input type="date" name="cargo[${index}][][document_date]" class="form-control"></td>
           <td><input type="file" name="cargo[${index}][][document_file]" class="form-control"></td>
           <td><input type="text" name="cargo[${index}][][eway_bill]" class="form-control"></td>
           <td><input type="date" name="cargo[${index}][][valid_upto]" class="form-control"></td>
           <td><input type="number" name="cargo[${index}][][declared_value]" class="form-control declared-value" oninput="calculateTotalDeclaredValue(${index})" required></td>
           <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this, ${index})">🗑</button></td>
       `;
   
       tbody.appendChild(row);
       calculateTotalDeclaredValue(index);
   }
   
   function removeRow(button, index) {
       button.closest('tr').remove();
       calculateTotalDeclaredValue(index);
   }
   
   // Initial bind for declared inputs (existing ones loaded via Blade)
   document.addEventListener('DOMContentLoaded', function () {
       document.querySelectorAll('[id^="cargoTableBody-"]').forEach(tbody => {
           const index = tbody.id.split('-')[1];
   
           tbody.querySelectorAll('input[name$="[declared_value]"]').forEach(input => {
               input.classList.add('declared-value');
               input.addEventListener('input', () => calculateTotalDeclaredValue(index));
           });
   
           calculateTotalDeclaredValue(index); // Initial calculation
       });
   });
   </script>
   
   
   
   <script>
      function setConsigneeDetails(index) {
          const select = document.getElementById(`consignee_id_${index}`);
          const gst = select.options[select.selectedIndex].dataset.gstConsignee || '';
          const address = select.options[select.selectedIndex].dataset.addressConsignee || '';
          document.getElementById(`consignee_gst_${index}`).value = gst;
          document.getElementById(`consignee_unloading_${index}`).value = address;
      }
      </script>
      <script>
   let lrIndex = {{ count($lrData) }}; // Start from existing count
   
   function addLrRow() {
       const container = document.getElementById('lrContainer');
       const newRow = document.createElement('div');
       newRow.classList.add('row', 'mt-4');
       newRow.innerHTML = `
           <h4 style="margin-bottom: 2%;">🚚 New LR - Consignment Details</h4>
           <div class="row g-3 mb-3 single-lr-row">
               <div class="col-md-3">
                   <label class="form-label">LR Number</label>
                   <input type="text" name="lr[${lrIndex}][lr_number]" class="form-control" value="LR-${Date.now()}" readonly>
               </div>
               <div class="col-md-3">
                   <label class="form-label">LR Date</label>
                   <input type="date" name="lr[${lrIndex}][lr_date]" class="form-control" required>
               </div>
               <div class="col-md-3">
                   <label class="form-label">Consignor Name</label>
                   <select name="lr[${lrIndex}][consignor_id]" class="form-select" onchange="setConsignorDetails(${lrIndex})" required>
                       <option value="">Select Consignor</option>
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
                           <option value="{{ $user->id }}"
                               data-gst-consignor="{{ $user->gst_number }}"
                               data-address-consignor="{{ $formattedAddress }}">
                               {{ $user->name }}
                           </option>
                       @endforeach
                   </select>
               </div>
               <div class="col-md-3">
                   <label class="form-label">Consignor GST</label>
                   <input type="text" name="lr[${lrIndex}][consignor_gst]" id="consignor_gst_${lrIndex}" class="form-control" readonly>
               </div>
               <div class="col-md-3">
                   <label class="form-label">Loading Address</label>
                   <input type="text" name="lr[${lrIndex}][consignor_loading]" id="consignor_loading_${lrIndex}" class="form-control" readonly>
               </div>
               
               <!-- Consignee Details -->
                  <div class="col-md-3">
                  
                  <h5>📦 Consignee (Receiver)</h5>
                  <select name="lr[${lrIndex}][consignee_id]" id="consignee_id_${lrIndex}" class="form-select" onchange="setConsigneeDetails(${lrIndex})" required>
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
                  
                  <div class="col-md-3">
                     <label class="form-label">Consignee Unloading Address</label>
                     <textarea name="lr[${lrIndex}][consignee_unloading]" id="consignee_unloading_${lrIndex}" class="form-control" rows="2" placeholder="Enter unloading address" required></textarea>
                  </div>
                  
                  <div class="col-md-3">
                     <label class="form-label">Consignee GST</label>
                     <input type="text" name="lr[${lrIndex}][consignee_gst]" id="consignee_gst_${lrIndex}" class="form-control" placeholder="Enter GST number" required>
                  </div>

            </div>
   
           <!-- Vehicle & Delivery Info -->
           <div class="row">
               
                <div class="col-md-4 mb-3">
                  <label class="form-label">🚚 Vehicle Number</label>
                     <select name="lr[${lrIndex}][vehicle_no]" class="form-select" required>
                              ${generateVehicle_noOptions()}
                        </select>
                  </div>
               <div class="col-md-4 mb-3">
                   <label class="form-label">🚛 Vehicle Type</label>
                   <select name="lr[${lrIndex}][vehicle_type]" class="form-select" required>
                       ${generateVehicleOptions()}
                   </select>
               </div>
               <div class="col-md-4">
                   <label class="form-label">🛻 Vehicle Ownership</label>
                   <div class="d-flex gap-3">
                       <div class="form-check">
                           <input class="form-check-input" type="radio" name="lr[${lrIndex}][vehicle_ownership]" value="Own" checked required>
                           <label class="form-check-label">Own</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input" type="radio" name="lr[${lrIndex}][vehicle_ownership]" value="Other" required>
                           <label class="form-check-label">Other</label>
                       </div>
                   </div>
               </div>
           </div>
   
           <div class="row">
               <div class="col-md-4 mb-3">
                   <label class="form-label">🚢 Delivery Mode</label>
                   <select name="lr[${lrIndex}][delivery_mode]" class="form-select" required>
                       <option value="">Select Mode</option>
                       <option value="door_delivery">Door Delivery</option>
                       <option value="godwon_deliver">Dodwon  Deliver</option>
                   </select>
               </div>
               <div class="col-md-4 mb-3">
                   <label class="form-label">📍 From (Origin)</label>
                   <select name="lr[${lrIndex}][from_location]" class="form-select" required>
                       <option value="">Select Origin</option>
                       <option value="Mumbai">Mumbai</option>
                       <option value="Delhi">Delhi</option>
                       <option value="Chennai">Chennai</option>
                   </select>
               </div>
               <div class="col-md-4 mb-3">
                   <label class="form-label">📍 To (Destination)</label>
                   <select name="lr[${lrIndex}][to_location]" class="form-select" required>
                       <option value="">Select Destination</option>
                       <option value="Kolkata">Kolkata</option>
                       <option value="Hyderabad">Hyderabad</option>
                       <option value="Pune">Pune</option>
                   </select>
               </div>
           </div>
   
           <!-- Cargo Description Section -->
           <div class="row mt-4">
               <div class="col-12">
                   <h5 class="mb-3 pb-3">📦 Cargo Description</h5>
                   <div class="mb-3 d-flex gap-3">
                       <div class="form-check">
                           <input class="form-check-input" type="radio" name="cargo_description_type_${lrIndex}" id="singleDoc_${lrIndex}" value="single" checked required>
                           <label class="form-check-label" for="singleDoc_${lrIndex}">Single Document</label>
                       </div>
                       <div class="form-check">
                           <input class="form-check-input" type="radio" name="cargo_description_type_${lrIndex}" id="multipleDoc_${lrIndex}" value="multiple" required>
                           <label class="form-check-label" for="multipleDoc_${lrIndex}">Multiple Documents</label>
                       </div>
                   </div>
   
                   <div class="table-responsive">
                       <table class="table table-bordered align-middle text-center">
                           <thead>
                               <tr>
                                   <th>No. of Packages</th>
                                   <th>Packaging Type</th>
                                   <th>Description</th>
                                   <th>Actual Weight (kg)</th>
                                   <th>Charged Weight (kg)</th>
                                    <th> &nbsp;Unit&nbsp;&nbsp; </th>
                                   <th>Document No.</th>
                                   <th>Document Name</th>
                                   <th>Document Date</th>
                                    <th>Document Upload</th>
                                   <th>Eway Bill</th>
                                   <th>Valid Upto</th>
                                   <th>declared value</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody id="cargoTableBody-0">
                               <tr>
                                   <td><input type="number" class="form-control" name="lr[${lrIndex}][cargo][0][packages_no]" placeholder="0" required></td>
                                   <td>
                                       <select class="form-select" name="lr[${lrIndex}][cargo][0][package_type]" required>
                                           <option>Pallets</option>
                                           <option>Cartons</option>
                                           <option>Bags</option>
                                       </select>
                                   </td>
                                   <td><input type="text" class="form-control" name="lr[${lrIndex}][cargo][0][package_description]" placeholder="Enter description" required></td>
                                  
                                   <td><input type="number" class="form-control" name="lr[${lrIndex}][cargo][0][actual_weight]" placeholder="0" required></td>
                                   <td><input type="number" class="form-control" name="lr[${lrIndex}][cargo][0][charged_weight]" placeholder="0" required></td>
                                    <td>
                                    <select class="form-select" name="lr[${lrIndex}][cargo][0][unit]" required>
                                            <option value="">Select Unit</option>
                                            <option value="kg">Kg</option>
                                            <option value="ton">Ton</option>
                                    </select>
                                   </td>
                                   <td><input type="text" class="form-control" name="lr[${lrIndex}][cargo][0][document_no]" placeholder="Doc No." required></td>
                                   <td><input type="text" class="form-control" name="lr[${lrIndex}][cargo][0][document_name]" placeholder="Doc Name" required></td>
                                   <td><input type="date" class="form-control" name="lr[${lrIndex}][cargo][0][document_date]" required></td>
                                   <td><input type="file" class="form-control" name="lr[${lrIndex}][cargo][0][document_file]" required></td>
                                   <td><input type="text" class="form-control" name="lr[${lrIndex}][cargo][0][eway_bill]" placeholder="Eway Bill No." required></td>
                                   <td><input type="date" class="form-control" name="lr[${lrIndex}][cargo][0][valid_upto]" required></td>
                                  <td> <input type="number" name="lr[${lrIndex}][cargo][0][declared_value]" class="form-control declared-value" oninput="calculateTotalDeclaredValue(${lrIndex})" placeholder="0">
                                    </td>

                                   <td><button class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button></td>
                               </tr>
                           </tbody>
                       </table>
                   </div>
                   <div class="text-end mt-2">
                       <button type="button" class="btn btn-sm" style="background: #ca2639; color: white;" onclick="addRow(0)">
        <span style="filter: invert(1);">➕</span> Add Row
    </button>
                   </div>
               </div>
           </div>
   
           <!-- Freight Details -->
           <div class="row mt-4">
               <div class="col-12">
                   <h5 class="pb-3">🚚 Freight Details</h5>
                   <div class="mb-3 d-flex gap-3">
                  <div class="form-check form-check-inline">
                     <input class="form-check-input freight-type"
                           type="radio"
                           name="lr[${lrIndex}][freightType]"
                           id="freightPaid-${lrIndex}"
                           value="paid"
                           checked
                           onchange="toggleFreightTable(${lrIndex})">
                     <label class="form-check-label" for="freightPaid-${lrIndex}">Paid</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input freight-type"
                           type="radio"
                           name="lr[${lrIndex}][freightType]"
                           id="freightToPay-${lrIndex}"
                           value="to_pay"
                           onchange="toggleFreightTable(${lrIndex})">
                     <label class="form-check-label" for="freightToPay-${lrIndex}">To Pay</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input freight-type"
                           type="radio"
                           name="lr[${lrIndex}][freightType]"
                           id="freightToBeBilled-${lrIndex}"
                           value="to_be_billed"
                           onchange="toggleFreightTable(${lrIndex})">
                     <label class="form-check-label" for="freightToBeBilled-${lrIndex}">To Be Billed</label>
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
                          <tbody id="freightTableBody-${lrIndex}">
                               <tr>
                                   <td><input type="number" name="lr[${lrIndex}][freight_amount]" class="form-control" required></td>
                                   <td><input type="number" name="lr[${lrIndex}][lr_charges]" class="form-control" required></td>
                                   <td><input type="number" name="lr[${lrIndex}][hamali]" class="form-control" required></td>
                                   <td><input type="number" name="lr[${lrIndex}][other_charges]" class="form-control" required></td>
                                   <td><input type="number" name="lr[${lrIndex}][gst_amount]" class="form-control" required></td>
                                   <td><input type="number" name="lr[${lrIndex}][total_freight]" class="form-control" required></td>
                                   <td><input type="number" name="lr[${lrIndex}][less_advance]" class="form-control" required></td>
                                   <td><input type="number" name="lr[${lrIndex}][balance_freight]" class="form-control" required></td>
                               </tr>
                           </tbody>
                       </table>
                   </div>
               </div>
           </div>
   
           <!-- Declared Value -->
           <div class="row mt-3">
               <div class="col-md-6">
                   <label class="form-label"><strong>💰 Total Declared Value (Rs.)</strong></label>
                   
                  <input type="number" class="form-control" id="totalDeclaredValue-${lrIndex}" name="lr[${lrIndex}][total_declared_value]" placeholder="0" readonly>


               </div>
           </div>
            <div class="row mt-3">
           <div class="d-flex justify-content-end gap-2 mt-3">
                   <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLrRow(this)">
                       <i class="fas fa-trash-alt"></i> Remove
                   </button>
               </div>
               </div>
       `;
       container.appendChild(newRow);
       lrIndex++;
   }
   
   function removeLrRow(button) {
       const section = button.closest('.row.mt-4');
       if (section) section.remove();
   }
   
   function setConsignorDetails(index) {
       const select = document.querySelector(`select[name="lr[${index}][consignor_id]"]`);
       const gst = select.options[select.selectedIndex].dataset.gstConsignor || '';
       const address = select.options[select.selectedIndex].dataset.addressConsignor || '';
       document.getElementById(`consignor_gst_${index}`).value = gst;
       document.getElementById(`consignor_loading_${index}`).value = address;
   }
</script>
<script>
   function addRow(lrIndex) {
       const tbody = document.getElementById(`cargoTableBody-${lrIndex}`);
       const rows = tbody.querySelectorAll('tr');
       const newIndex = rows.length;
   
       const newRow = rows[0].cloneNode(true);
   
       newRow.querySelectorAll('input, select').forEach(input => {
           const name = input.getAttribute('name');
           if (name) {
               input.setAttribute('name', name.replace(/\[cargo\]\[\d+\]/, `[cargo][${newIndex}]`));
           }
   
           // Reset values
           if (input.type === 'file') {
               input.value = ''; // File inputs can't be set to empty string in all browsers
           } else if (input.tagName === 'SELECT') {
               input.selectedIndex = 0;
           } else {
               input.value = '';
           }
   
           input.removeAttribute('id'); // Prevent duplicate IDs
       });
   
       tbody.appendChild(newRow);
       calculateTotalDeclaredValue(lrIndex);
   }
   
   function removeRow(button) {
       const row = button.closest('tr');
       const tbody = row.closest('tbody');
       const lrIndex = tbody.id.split('-')[1];
   
       if (tbody.querySelectorAll('tr').length > 1) {
           row.remove();
           calculateTotalDeclaredValue(lrIndex);
       } else {
           alert('At least one cargo row is required.');
       }
   }
   
   function calculateTotalDeclaredValue(lrIndex) {
       const inputs = document.querySelectorAll(`#cargoTableBody-${lrIndex} .declared-value`);
       let total = 0;
   
       inputs.forEach(input => {
           total += parseFloat(input.value) || 0;
       });
   
       const totalInput = document.getElementById(`totalDeclaredValue-${lrIndex}`);
       if (totalInput) {
           totalInput.value = total.toFixed(2);
       }
   }
 
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
  <script>
   function toggleFreightTable() {
       const tbody = document.getElementById('freightBody');
       const paid = document.getElementById('freightPaid');
       const toPay = document.getElementById('freightToPay');
       const toBeBilled = document.getElementById('freightToBeBilled');
   
       const inputs = tbody.querySelectorAll('input');
   
       if (toBeBilled.checked) {
           tbody.style.display = 'none';
           inputs.forEach(input => input.removeAttribute('required'));
       } else {
           tbody.style.display = 'table-row-group';
           inputs.forEach(input => input.setAttribute('required', 'required'));
       }
   
       if (toPay.checked) {
           inputs.forEach(input => input.value = '');
       }
   }
   
   document.addEventListener("DOMContentLoaded", function () {
       toggleFreightTable();
   });
    </script>
   
   {{-- <script>
      function toggleFreightTable(lrIndex) {
        const toPayRadio = document.getElementById(`freightToPay-${lrIndex}`);
        const toBeBilledRadio = document.getElementById(`freightToBeBilled-${lrIndex}`);
        const tableBody = document.querySelector(`#freightTableBody-${lrIndex}`);
    
        if (!tableBody) return;
    
        const inputs = tableBody.querySelectorAll('input');
    
        // Hide table and remove required if "to_pay" or "to_be_billed" is selected
        if (toPayRadio.checked || toBeBilledRadio.checked) {
          tableBody.style.display = 'none';
          inputs.forEach(input => {
            input.removeAttribute('required');
            if (toPayRadio.checked) {
              input.value = ''; // Clear values only if 'to_pay'
            }
          });
        } else {
          tableBody.style.display = '';
          inputs.forEach(input => {
            input.setAttribute('required', 'required');
          });
        }
      }
    </script> --}}
    <script>
        function toggleOrderMethod() {
          const orderRadio = document.getElementById('byOrder');
          const contractRadio = document.getElementById('byContract');
          const orderAmountDiv = document.getElementById('orderAmountDiv');
          const contractNumberDiv = document.getElementById('contractNumberDiv');
      
          if (orderRadio.checked) {
            orderAmountDiv.classList.remove('d-none');
            orderAmountDiv.querySelector('input').setAttribute('required', 'required');
      
            contractNumberDiv.classList.add('d-none');
            contractNumberDiv.querySelector('input').removeAttribute('required');
          } else if (contractRadio.checked) {
            contractNumberDiv.classList.remove('d-none');
            contractNumberDiv.querySelector('input').setAttribute('required', 'required');
      
            orderAmountDiv.classList.add('d-none');
            orderAmountDiv.querySelector('input').removeAttribute('required');
          }
        }
      
        document.addEventListener('DOMContentLoaded', function () {
          toggleOrderMethod(); // Run once on load
        });
      </script>
      
    
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection