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
               <textarea name="description" class="form-control" required>{{ $order->description }}</textarea>
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
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">👤 Freight A/c</label>
                  <select name="customer_id" id="customer_id" class="form-select" onchange="setCustomerDetails()" required>
                     <option value="">Select Customer</option>
                     @foreach($users as $user)
                        @php
                        $addresses = json_decode($user->address, true);
                        @endphp
                        @if(!empty($addresses) && is_array($addresses))
                           @foreach($addresses as $address)
                              <option value="{{ $user->id }}"
                                 data-gst="{{ $address['gstin'] ?? '' }}"
                                 data-address="{{ $address['billing_address'] ?? '' }}"
                                 @if($user->id == $order->customer_id) selected @endif>
                                 {{ $user->name }} - {{ $address['city'] ?? '' }}
                              </option>
                           @endforeach
                        @endif
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">🧾 GST NUMBER</label>
                  <input type="text" name="gst_number" id="gst_number" value="{{ old('gst_number', $order->customer_gst ?? '') }}" class="form-control" readonly required>
               </div>
            </div>
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📍 CUSTOMER ADDRESS</label>
                  <input type="text" name="customer_address" id="customer_address" value="{{ old('customer_address', $order->customer_address ?? '') }}" class="form-control" readonly required>
               </div>
            </div>
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📊 Order Type</label>
                  <select name="order_type" class="form-select" required>
                     <option value="">Select Order Type</option>
                     @php
                     $orderType = old('order_type', $order->order_type ?? '');
                     @endphp
                     <option value="import" {{ $orderType === 'import' ? 'selected' : '' }}>Import</option>
                     <option value="import-restoff" {{ $orderType === 'import-restoff' ? 'selected' : '' }}>Import Restoff</option>
                     <option value="export" {{ $orderType === 'export' ? 'selected' : '' }}>Export</option>
                     <option value="export-restoff" {{ $orderType === 'export-restoff' ? 'selected' : '' }}>Export Restoff</option>
                     <option value="domestic" {{ $orderType === 'domestic' ? 'selected' : '' }}>Domestic</option>
                  </select>
               </div>
            </div>
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📍 PICKUP ADDRESS</label>
                  <input type="text" name="pickup_addresss" id="pickup_address" value="{{ old('pickup_addresss', $order->pickup_addresss ?? '') }}" class="form-control" placeholder="Pickup Address" required>
               </div>
            </div>
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📍 DELIVER ADDRESS</label>
                  <input type="text" name="deleiver_addresss" id="deleiver_addresss" class="form-control" value="{{ old('deleiver_addresss', $order->deleiver_addresss ?? '') }}" placeholder="Deliver Address" required>
               </div>
            </div>
            @php
            $method = old('order_method', $order->order_method ?? '');
            $orderAmount = old('order_amount', $order->byorder ?? '');
            $contractNumber = old('contract_number', $order->bycontract ?? '');
            @endphp
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📑 Order Method</label><br>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="order_method" id="byOrder" value="order" onclick="toggleOrderMethod()" {{ $method == 'order' ? 'checked' : '' }}>
                     <label class="form-check-label" for="byOrder">By Order</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="order_method" id="byContract" value="contract" onclick="toggleOrderMethod()" {{ $method == 'contract' ? 'checked' : '' }}>
                     <label class="form-check-label" for="byContract">By Contract</label>
                  </div>
               </div>
               <div class="mb-3 {{ $method == 'order' ? '' : 'd-none' }}" id="orderAmountDiv">
                  <label class="form-label">💰 ORDER AMOUNT</label>
                  <input type="number" name="byOrder" class="form-control" placeholder="Enter Amount" value="{{ $orderAmount }}" oninput="showOrderAmountAlert(this.value)" {{ $method == 'order' ? 'required' : '' }}>
               </div>
               <div class="mb-3 {{ $method == 'contract' ? '' : 'd-none' }}" id="contractNumberDiv">
                  
                  <input type="hidden" >
               </div>
            </div>
         </div>
         @php
         $lrData = is_array($order->lr) ? $order->lr : (json_decode($order->lr ?? '[]', true) ?? []);
         @endphp
         @foreach($lrData as $index => $lr)
         <div class="row mt-4 lr-section" data-lr-index="{{ $index }}">
            <h4 style="margin-bottom: 2%;">🚚 Update LR - Consignment Details</h4>
            <div class="row g-3 mb-3 single-lr-row">
               <div class="col-md-3">
                  <label class="form-label">LR Number</label>
                  <input type="text" class="form-control" value="{{ $lr['lr_number'] ?? '' }}" disabled>
                  <input type="hidden" name="lr[{{ $index }}][lr_number]" value="{{ $lr['lr_number'] ?? '' }}">
               </div>
               <div class="col-md-3">
                  <label class="form-label">Lr Date</label>
                  <input required type="date" name="lr[{{ $index }}][lr_date]" class="form-control" placeholder="Enter lr date" value="{{ $lr['lr_date'] ?? '' }}">
               </div>
               <div class="col-md-3">
                  <label class="form-label">🚚 Consignor Name</label>
                  <select name="lr[{{ $index }}][consignor_id]" id="consignor_id_{{ $index }}" class="form-select" onchange="setConsignorDetails({{ $index }})" required>
                     <option value="">Select Consignor Name</option>
                     @foreach($users as $user)
                        @php
                        $addresses = json_decode($user->address, true);
                        @endphp
                        @if(!empty($addresses) && is_array($addresses))
                           @foreach($addresses as $address)
                              <option value="{{ $user->id }}"
                                 data-gst-consignor="{{ $address['gstin'] ?? '' }}"
                                 data-address-consignor="{{ $address['billing_address'] ?? '' }}"
                                 {{ old("lr.$index.consignor_id", $lr['consignor_id'] ?? '') == $user->id ? 'selected' : '' }}>
                                 {{ $user->name }} - {{ $address['city'] ?? '' }}
                              </option>
                           @endforeach
                        @endif
                     @endforeach
                  </select>
               </div>
               <div class="col-md-3">
                  <label class="form-label">🧾 Consignor GST</label>
                  <input type="text" name="lr[{{ $index }}][consignor_gst]" id="consignor_gst_{{ $index }}" value="{{ old("lr.$index.consignor_gst", $lr['consignor_gst'] ?? '') }}" class="form-control" readonly required>
               </div>
               <div class="col-md-3">
                  <label class="form-label">📍 Loading Address</label>
                  <input type="text" name="lr[{{ $index }}][consignor_loading]" id="consignor_loading_{{ $index }}" value="{{ old("lr.$index.consignor_loading", $lr['consignor_loading'] ?? '') }}" class="form-control" readonly required>
               </div>
               <div class="col-md-3">
                  <label class="form-label">🏢 Consignee Name</label>
                  <select name="lr[{{ $index }}][consignee_id]" id="consignee_id_{{ $index }}" class="form-select" onchange="setConsigneeDetails({{ $index }})" required>
                     <option value="">Select Consignee Name</option>
                     @foreach($users as $user)
                        @php
                        $addresses = json_decode($user->address, true);
                        @endphp
                        @if(!empty($addresses) && is_array($addresses))
                           @foreach($addresses as $address)
                              <option value="{{ $user->id }}"
                                 data-gst-consignee="{{ $address['gstin'] ?? '' }}"
                                 data-address-consignee="{{ $address['billing_address'] ?? '' }}"
                                 {{ old("lr.$index.consignee_id", $lr['consignee_id'] ?? '') == $user->id ? 'selected' : '' }}>
                                 {{ $user->name }} - {{ $address['city'] ?? '' }}
                              </option>
                           @endforeach
                        @endif
                     @endforeach
                  </select>
               </div>
               <div class="col-md-3">
                  <label class="form-label">🧾 Consignee GST</label>
                  <input type="text" name="lr[{{ $index }}][consignee_gst]" id="consignee_gst_{{ $index }}" value="{{ old("lr.$index.consignee_gst", $lr['consignee_gst'] ?? '') }}" class="form-control" readonly required>
               </div>
               <div class="col-md-3">
                  <label class="form-label">📍 Unloading Address</label>
                  <input type="text" name="lr[{{ $index }}][consignee_unloading]" id="consignee_unloading_{{ $index }}" value="{{ old("lr.$index.consignee_unloading", $lr['consignee_unloading'] ?? '') }}" class="form-control" readonly required>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <label class="form-label">🚛 Vehicle Number</label>
                  <select name="lr[{{ $index }}][vehicle_no]" id="vehicle_id_{{ $index }}" class="form-select" onchange="fillVehicleDetails({{ $index }})" required>
                     <option value="">Select Vehicle</option>
                     @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->vehicle_no }}"
                           data-no="{{ $vehicle->vehicle_no }}"
                           {{ old("lr.$index.vehicle_no", $lr['vehicle_no'] ?? '') == $vehicle->vehicle_no ? 'selected' : '' }}>
                           {{ $vehicle->vehicle_no }}
                        </option>
                     @endforeach
                  </select>
               </div>
               <div class="col-md-4">
                  <label class="form-label">🚛 Vehicle Type</label>
                  <select name="lr[{{ $index }}][vehicle_type]" class="form-select" required>
                     <option value="">Select Vehicle Type</option>
                     @foreach ($vehiclesType as $type)
                        <option value="{{ $type->id }}"
                           {{ old("lr.$index.vehicle_type", $lr['vehicle_type'] ?? '') == $type->id ? 'selected' : '' }}>
                           {{ $type->vehicletype }}
                        </option>
                     @endforeach
                  </select>
               </div>
               <div class="col-md-4">
                  <label class="form-label">🛻 Vehicle Ownership</label>
                  <div class="d-flex gap-3">
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="lr[{{ $index }}][vehicle_ownership]" id="ownership_own_{{ $index }}" value="Own" {{ old("lr.$index.vehicle_ownership", $lr['vehicle_ownership'] ?? '') == 'Own' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="ownership_own_{{ $index }}">Own</label>
                     </div>
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="lr[{{ $index }}][vehicle_ownership]" id="ownership_other_{{ $index }}" value="Other" {{ old("lr.$index.vehicle_ownership", $lr['vehicle_ownership'] ?? '') == 'Other' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ownership_other_{{ $index }}">Other</label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="mb-3">
                     <label class="form-label">🚢 Delivery Mode</label>
                     <select name="lr[{{ $index }}][delivery_mode]" class="form-select" required>
                        <option value="">Select Mode</option>
                        <option value="door_delivery" {{ old("lr.$index.delivery_mode", $lr['delivery_mode'] ?? '') == 'door_delivery' ? 'selected' : '' }}>Door Delivery</option>
                        <option value="godown_delivery" {{ old("lr.$index.delivery_mode", $lr['delivery_mode'] ?? '') == 'godown_delivery' ? 'selected' : '' }}>Godown Delivery</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="mb-3">
                     <label class="form-label">📍 From (Origin)</label>
                     <select name="lr[{{ $index }}][from_location]" class="form-select" required>
                        <option value="">Select Origin</option>
                        @foreach ($destination as $loc)
                           <option value="{{ $loc->id }}"
                              {{ old("lr.$index.from_location", $lr['from_location'] ?? '') == $loc->id ? 'selected' : '' }}>
                              {{ $loc->destination }}
                           </option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="mb-3">
                     <label class="form-label">📍 To (Destination)</label>
                     <select name="lr[{{ $index }}][to_location]" class="form-select" required>
                        <option value="">Select Destination</option>
                        @foreach ($destination as $loc)
                           <option value="{{ $loc->id }}"
                              {{ old("lr.$index.to_location", $lr['to_location'] ?? '') == $loc->id ? 'selected' : '' }}>
                              {{ $loc->destination }}
                           </option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="mb-3">
                  <label class="form-label">💰 Order Rate</label>
                  <input type="number" name="lr[{{ $index }}][order_rate]" class="form-control" id="rate_input{{ $index }}" placeholder="Enter Amount" readonly>
                  </div>
            </div>
            {{-- @dd($lr['insurance_status']); --}}
           

            <!-- Insurance -->
            <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
               <label class="form-label mb-0">🛡️ Insurance?</label>

               <!-- YES Option -->
               <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio"
                        name="lr[{{ $index }}][insurance_status]"
                        value="yes"
                        id="insuranceYes_{{ $index }}"
                        onchange="toggleInsuranceInput({{ $index }})"
                        {{ old("lr.$index.insurance_status", $lr['insurance_status'] ?? '') == 'yes' ? 'checked' : '' }}>
                  <label class="form-check-label" for="insuranceYes_{{ $index }}">Yes</label>
               </div>

               <!-- NO Option -->
               <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio"
                        name="lr[{{ $index }}][insurance_status]"
                        value="no"
                        id="insuranceNo_{{ $index }}"
                        onchange="toggleInsuranceInput({{ $index }})"
                        {{ old("lr.$index.insurance_status", $lr['insurance_status'] ?? 'no') == 'no' ? 'checked' : '' }}>
                  <label class="form-check-label" for="insuranceNo_{{ $index }}">No</label>
               </div>

               <!-- Insurance Number Input -->
               <input type="text"
                     class="form-control insurance-input {{ old("lr.$index.insurance_status", $lr['insurance_status'] ?? 'no') != 'yes' ? 'd-none' : '' }}"
                     name="lr[{{ $index }}][insurance_description]"
                     id="insuranceInput_{{ $index }}"
                     placeholder="Enter Insurance Number"
                     style="max-width: 450px;"
                     value="{{ old("lr.$index.insurance_description", $lr['insurance_description'] ?? '') }}">
            </div>

            <!-- Insurance -->
            <div class="row mt-4">
               @php
               $cargoData = isset($lr['cargo']) && is_array($lr['cargo']) ? collect($lr['cargo'])->filter(fn($item) => isset($item['packages_no']) && $item['packages_no'] !== null)->values() : collect();
               @endphp
               <div class="col-12" data-lr-index="{{ $index }}">
                  <h5 class="mb-3 pb-3">📦 Cargo Description (LR #{{ $index }})</h5>
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
                              <th>Declared Value</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody id="cargoTableBody-{{ $index }}">
                           @foreach ($cargoData as $cargoIndex => $cargo)
                           <tr>
                              <td><input type="number" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][packages_no]" class="form-control" value="{{ $cargo['packages_no'] ?? '' }}" required></td>
                              <td>
                                 <select name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][package_type]" class="form-select" required>
                                    <option value="Pallets" {{ $cargo['package_type'] == 'Pallets' ? 'selected' : '' }}>Pallets</option>
                                    <option value="Cartons" {{ $cargo['package_type'] == 'Cartons' ? 'selected' : '' }}>Cartons</option>
                                    <option value="Bags" {{ $cargo['package_type'] == 'Bags' ? 'selected' : '' }}>Bags</option>
                                 </select>
                              </td>
                              <td><input type="text" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][package_description]" class="form-control" value="{{ $cargo['package_description'] ?? '' }}" required></td>
                              <td><input type="number" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][actual_weight]" class="form-control" value="{{ $cargo['actual_weight'] ?? '' }}" required></td>
                              <td><input type="number" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][charged_weight]" class="form-control charged-weight" value="{{ $cargo['charged_weight'] ?? '' }}" required oninput="calculateTotal({{ $index }}, 'charged-weight', 'totalChargedWeight-{{ $index }}')"></td>
                              <td>
                                 <select class="form-select" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][unit]" required>
                                    <option value="">Select Unit</option>
                                    <option value="kg" {{ ($cargo['unit'] ?? '') == 'kg' ? 'selected' : '' }}>Kg</option>
                                    <option value="ton" {{ ($cargo['unit'] ?? '') == 'ton' ? 'selected' : '' }}>Ton</option>
                                 </select>
                              </td>
                              <td><input type="text" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][document_no]" class="form-control" value="{{ $cargo['document_no'] ?? '' }}" required></td>
                              <td><input type="text" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][document_name]" class="form-control" value="{{ $cargo['document_name'] ?? '' }}" required></td>
                              <td><input type="date" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][document_date]" class="form-control" value="{{ $cargo['document_date'] ?? '' }}" required></td>
                              <td>
                                 <input type="file" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][document_file]" class="form-control">
                                 <input type="hidden" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][old_document_file]" value="{{ $cargo['document_file'] ?? '' }}">
                              </td>
                              <td><input type="text" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][eway_bill]" class="form-control" value="{{ $cargo['eway_bill'] ?? '' }}" required></td>
                              <td><input type="date" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][valid_upto]" class="form-control" value="{{ $cargo['valid_upto'] ?? '' }}" required></td>
                              <td>
                                 <input name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][declared_value]" type="number" value="{{ $cargo['declared_value'] ?? '' }}" class="form-control declared-value" placeholder="0" required oninput="calculateTotal({{ $index }}, 'declared-value', 'totalDeclaredValue-{{ $index }}')">
                              </td>
                              <td>
                                 <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this, {{ $index }})">🗑</button>
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                     <div class="text-end mt-2">
                        <button type="button" class="btn btn-sm btn-primary" onclick="addCargoRowOld({{ $index }})">
                           ➕ Add Row
                        </button>
                     </div>
                  </div>
               </div>
               <div class="row mt-4">

                 <!--  Freight Details -->
                 <div class="col-12">
                  <h5 class="pb-3">🚚 Freight Details</h5>
                  @php $freightType = old("lr.$index.freightType", $lr['freightType'] ?? 'paid'); @endphp
                  <div class="mb-3 d-flex gap-3">
                     <div class="form-check form-check-inline">
                           <input class="form-check-input freight-type" type="radio" name="lr[{{ $index }}][freightType]" id="freightPaid_{{ $index }}" value="paid" onchange="toggleFreightTable({{ $index }})" {{ $freightType === 'paid' ? 'checked' : '' }}>
                           <label class="form-check-label" for="freightPaid_{{ $index }}">Paid</label>
                     </div>
                     <div class="form-check form-check-inline">
                           <input class="form-check-input freight-type" type="radio" name="lr[{{ $index }}][freightType]" id="freightToPay_{{ $index }}" value="to_pay" onchange="toggleFreightTable({{ $index }})" {{ $freightType === 'to_pay' ? 'checked' : '' }}>
                           <label class="form-check-label" for="freightToPay_{{ $index }}">To Pay</label>
                     </div>
                     <div class="form-check form-check-inline">
                           <input class="form-check-input freight-type" type="radio" name="lr[{{ $index }}][freightType]" id="freightToBeBilled_{{ $index }}" value="to_be_billed" onchange="toggleFreightTable({{ $index }})" {{ $freightType === 'to_be_billed' ? 'checked' : '' }}>
                           <label class="form-check-label" for="freightToBeBilled_{{ $index }}">To Be Billed</label>
                     </div>
                  </div>
                  <div class="table-responsive">
                     <table class="table table-bordered align-middle text-center" id="freight-table-{{ $index }}">
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
                           <tbody id="freightBody-{{ $index }}">
                              <tr>
                                 <td><input name="lr[{{ $index }}][freight_amount]" id="finalResult-{{$index}}" type="number" class="form-control freight-amount" value="{{ $lr['freight_amount'] ?? '' }}" placeholder="Enter Freight Amount" required></td>
                                 <td><input name="lr[{{ $index }}][lr_charges]" type="number" class="form-control lr-charges" value="{{ $lr['lr_charges'] ?? '' }}" placeholder="Enter LR Charges" required></td>
                                 <td><input name="lr[{{ $index }}][hamali]" type="number" class="form-control hamali" value="{{ $lr['hamali'] ?? '' }}" placeholder="Enter Hamali Charges" required></td>
                                 <td><input name="lr[{{ $index }}][other_charges]" type="number" class="form-control other-charges" value="{{ $lr['other_charges'] ?? '' }}" placeholder="Enter Other Charges" required></td>
                                 <td><input name="lr[{{ $index }}][gst_amount]" type="number" class="form-control gst" value="{{ $lr['gst_amount'] ?? '' }}" placeholder="Enter GST Amount" required readonly></td>
                                 <td><input name="lr[{{ $index }}][total_freight]" type="number" class="form-control total-freight" value="{{ $lr['total_freight'] ?? '' }}" placeholder="Total Freight" required readonly></td>
                                 <td><input name="lr[{{ $index }}][less_advance]" type="number" class="form-control less-advance" value="{{ $lr['less_advance'] ?? '' }}" placeholder="Less Advance Amount" required></td>
                                 <td><input name="lr[{{ $index }}][balance_freight]" type="number" class="form-control balance-freight" value="{{ $lr['balance_freight'] ?? '' }}" placeholder="Balance Freight Amount" required readonly></td>
                              </tr>
                           </tbody>
                     </table>
                  </div>
            </div>
            <!--  Freight Details -->

               </div>
               <div class="row mt-3">
                  <div class="col-md-6">
                     <div class="mt-3">
                        <input type="hidden" id="totalChargedWeight-{{ $index }}" name="lr[{{ $index }}][total_charged_weight]" class="form-control" onchange="updateFinalResult({{ $index }})">
                        <label><strong>💰 Total Declared Value (Rs.)</strong></label>
                        <input type="text" id="totalDeclaredValue-{{ $index }}" name="lr[{{ $index }}][total_declared_value]" class="form-control" value="{{ $lr['total_declared_value'] ?? '' }}" readonly>
                     </div>
                  </div>
               </div>
            </div>
         @endforeach
         <div id="lrContainer"></div>
         <div class="d-flex justify-content-end gap-2 mt-3">
            <button type="button" class="btn btn-sm addMoreLRBtn" style="background-color: #ca2639; color: #fff;" onclick="addLrRow()">
               <i class="fas fa-plus-circle"></i> Add More LR - Consignment
            </button>
         </div>
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

<script>
let lrCounter = {{ count($lrData) }};
let cargoCounters = {};
let currentOrderAmount = 0;
let currentContractAmount = 0;
window.lrRates = {}; // Store rates for each LR

// Initialize on page load
document.addEventListener('DOMContentLoaded', function () {
    // Initialize existing LR calculations
    document.querySelectorAll('[id^="cargoTableBody-"]').forEach(tbody => {
        const index = tbody.id.split('-')[1];
        cargoCounters[index] = document.querySelectorAll(`#cargoTableBody-${index} tr`).length;
        initializeCargoTable(index);
    });

    // Set initial customer details
    const customerSelect = document.getElementById('customer_id');
    if (customerSelect?.value) setCustomerDetails();

    // Set initial consignor/consignee details, freight tables, and insurance
    for (let i = 0; i < lrCounter; i++) {
        if (document.getElementById(`consignor_id_${i}`)?.value) setConsignorDetails(i);
        if (document.getElementById(`consignee_id_${i}`)?.value) setConsigneeDetails(i);
        toggleFreightTable(i);
        toggleInsuranceInput(i); // Initialize insurance visibility
    }

    // Initialize order method
    toggleOrderMethod();

    // Set initial order/contract amount
    currentOrderAmount = parseFloat(document.querySelector('input[name="byOrder"]')?.value) || 0;
    currentContractAmount = document.querySelector('input[name="byContract"]')?.value || '';

    // Update all freight amounts
    updateAllFinalResults();
});

// Customer details
function setCustomerDetails() {
    const select = document.getElementById('customer_id');
    const gst = select.options[select.selectedIndex]?.dataset.gst || '';
    const address = select.options[select.selectedIndex]?.dataset.address || '';
    document.getElementById('gst_number').value = gst;
    document.getElementById('customer_address').value = address;
    // Update rates for contract method if selected
    const orderMethod = document.querySelector('input[name="order_method"]:checked')?.value;
    if (orderMethod === 'contract') {
        for (let i = 0; i < lrCounter; i++) {
            fetchRateForLR(i);
        }
    }
}

// Consignor details
function setConsignorDetails(index) {
    const select = document.getElementById(`consignor_id_${index}`);
    const gst = select.options[select.selectedIndex]?.dataset.gstConsignor || '';
    const address = select.options[select.selectedIndex]?.dataset.addressConsignor || '';
    document.getElementById(`consignor_gst_${index}`).value = gst;
    document.getElementById(`consignor_loading_${index}`).value = address;
}

// Consignee details
function setConsigneeDetails(index) {
    const select = document.getElementById(`consignee_id_${index}`);
    const gst = select.options[select.selectedIndex]?.dataset.gstConsignee || '';
    const address = select.options[select.selectedIndex]?.dataset.addressConsignee || '';
    document.getElementById(`consignee_gst_${index}`).value = gst;
    document.getElementById(`consignee_unloading_${index}`).value = address;
}

// Vehicle details (stub, as implementation not provided)
function fillVehicleDetails(index) {
    // Implement if needed
}

// Order method toggle
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
        currentOrderAmount = parseFloat(document.querySelector('input[name="byOrder"]')?.value) || 0;
        currentContractAmount = '';
        // Update rates for order method
        for (let i = 0; i < lrCounter; i++) {
            window.lrRates[i] = currentOrderAmount;
            document.getElementById(`rate_input${i}`).value = currentOrderAmount.toFixed(2);
            updateFinalResult(i);
        }
    } else {
        contractNumberDiv.classList.remove('d-none');
        contractNumberDiv.querySelector('input').setAttribute('required', 'required');
        orderAmountDiv.classList.add('d-none');
        orderAmountDiv.querySelector('input').removeAttribute('required');
        currentContractAmount = document.querySelector('input[name="byContract"]')?.value || '';
        currentOrderAmount = 0;
        // Fetch rates for contract method
        for (let i = 0; i < lrCounter; i++) {
            fetchRateForLR(i);
        }
    }
}

// Fetch rate for a specific LR via AJAX
// Initialize window.lrRates with old order_rate on page load
window.lrRates = window.lrRates || {};
document.addEventListener('DOMContentLoaded', () => {
    // Assuming index is available from Blade loop
    const index = '{{ $index }}'; // Replace with actual index from Blade
    const oldRate = parseFloat('{{ $lr["order_rate"] ?? 0 }}') || 0;
    window.lrRates[index] = oldRate;
    // Ensure rate_input is set to old value (already handled by Blade, but just in case)
    document.getElementById(`rate_input${index}`).value = oldRate.toFixed(2);
    updateFinalResult(index); // Call to update calculations with old rate
});

function fetchRateForLR(index) {
    const vehicle_type = document.querySelector(`select[name="lr[${index}][vehicle_type]"]`)?.value || '';
    const from_location = document.querySelector(`select[name="lr[${index}][from_location]"]`)?.value || '';
    const to_location = document.querySelector(`select[name="lr[${index}][to_location]"]`)?.value || '';
    const customer_id = document.getElementById('customer_id')?.value || '';

    // If any field is missing, retain the old rate instead of setting to 0
    if (!vehicle_type || !from_location || !to_location || !customer_id) {
        // Keep window.lrRates[index] and rate_input unchanged
        updateFinalResult(index); // Update calculations with existing rate
        return;
    }

    // Fetch new rate only if all fields are valid
    fetch('/admin/get-rate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            customer_id: customer_id,
            vehicle_type: vehicle_type,
            from_location: from_location,
            to_location: to_location
        })
    })
    .then(res => res.json())
    .then(data => {
        const rateInput = document.getElementById(`rate_input${index}`);
        window.lrRates[index] = parseFloat(data.rate) || 0;
        rateInput.value = window.lrRates[index].toFixed(2);
        updateFinalResult(index);
    })
    .catch(err => {
        console.error('Error:', err);
        // On error, retain old rate instead of setting to 0
        updateFinalResult(index);
    });
}
// Freight calculations
document.addEventListener('input', function (e) {
    const row = e.target.closest('tr');
    if (!row || !row.closest('.lr-section')) return;

    const index = row.closest('.lr-section').dataset.lrIndex;
    const freight = parseFloat(row.querySelector('.freight-amount')?.value) || 0;
    const lrCharges = parseFloat(row.querySelector('.lr-charges')?.value) || 0;
    const hamali = parseFloat(row.querySelector('.hamali')?.value) || 0;
    const otherCharges = parseFloat(row.querySelector('.other-charges')?.value) || 0;
    const lessAdvance = parseFloat(row.querySelector('.less-advance')?.value) || 0;

    const subtotal = freight + lrCharges + hamali + otherCharges;
    const gstPercent = 12;
    const gstAmount = subtotal * gstPercent / 100;
    const totalFreight = subtotal + gstAmount;
    const balance = totalFreight - lessAdvance;

    row.querySelector('.gst').value = gstAmount.toFixed(2);
    row.querySelector('.total-freight').value = totalFreight.toFixed(2);
    row.querySelector('.balance-freight').value = balance.toFixed(2);
});

// Freight table visibility
function toggleFreightTable(index) {
    const tbody = document.getElementById(`freightBody-${index}`);
    const toBeBilled = document.getElementById(`freightToBeBilled_${index}`);

    if (!tbody || !toBeBilled) return;

    if (toBeBilled.checked) {
        tbody.style.display = 'none';
        tbody.querySelectorAll('input').forEach(input => input.removeAttribute('required'));
    } else {
        tbody.style.display = '';
        tbody.querySelectorAll('input').forEach(input => input.setAttribute('required', 'required'));
    }
}

// Order and contract amount handling
function showOrderAmountAlert(value) {
    currentOrderAmount = parseFloat(value) || 0;
    currentContractAmount = '';
    for (let i = 0; i < lrCounter; i++) {
        window.lrRates[i] = currentOrderAmount;
        document.getElementById(`rate_input${i}`).value = currentOrderAmount.toFixed(2);
        updateFinalResult(i);
    }
}

// Update final freight result
function updateFinalResult(index) {
    const totalChargedWeight = parseFloat(document.getElementById(`totalChargedWeight-${index}`)?.value) || 0;
    const finalResultInput = document.getElementById(`finalResult-${index}`);
    if (!finalResultInput) return;

    const rate = window.lrRates[index] || 0;
    finalResultInput.value = (totalChargedWeight * rate).toFixed(2);

    // Trigger freight calculations
    const row = finalResultInput.closest('tr');
    const event = new Event('input');
    row.querySelector('.freight-amount').dispatchEvent(event);
}

function updateAllFinalResults() {
    for (let i = 0; i < lrCounter; i++) {
        updateFinalResult(i);
    }
}

// Cargo calculations
function calculateTotal(index, className, totalId) {
    let total = 0;
    document.querySelectorAll(`#cargoTableBody-${index} .${className}`).forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    const totalInput = document.getElementById(totalId);
    if (totalInput) {
        totalInput.value = total.toFixed(2);
        if (totalId.includes('totalChargedWeight')) updateFinalResult(index);
    }
}

// Initialize cargo table
function initializeCargoTable(index) {
    const tbody = document.getElementById(`cargoTableBody-${index}`);
    if (!tbody) return;

    // Remove existing listeners to prevent duplicates
    tbody.querySelectorAll('.declared-value').forEach(input => {
        input.removeEventListener('input', calculateDeclaredValue);
        input.addEventListener('input', calculateDeclaredValue);
    });
    tbody.querySelectorAll('.charged-weight').forEach(input => {
        input.removeEventListener('input', calculateChargedWeight);
        input.addEventListener('input', calculateChargedWeight);
    });

    function calculateDeclaredValue() {
        calculateTotal(index, 'declared-value', `totalDeclaredValue-${index}`);
    }

    function calculateChargedWeight() {
        calculateTotal(index, 'charged-weight', `totalChargedWeight-${index}`);
    }

    // Initial calculation for existing rows
    calculateTotal(index, 'declared-value', `totalDeclaredValue-${index}`);
    calculateTotal(index, 'charged-weight', `totalChargedWeight-${index}`);
}

// Add cargo row
function addCargoRowOld(index) {
if (!(index in cargoCounters)) cargoCounters[index] = 0;
const tbody = document.getElementById(`cargoTableBody-${index}`);
const cargoIndex = cargoCounters[index]++;

const row = document.createElement('tr');
row.innerHTML = `
<td><input type="number" name="lr[${index}][cargo][${cargoIndex}][packages_no]" class="form-control" required></td>
<td>
<select name="lr[${index}][cargo][${cargoIndex}][package_type]" class="form-select" required>
<option value="Pallets">Pallets</option>
<option value="Cartons">Cartons</option>
<option value="Bags">Bags</option>
</select>
</td>
<td><input type="text" name="lr[${index}][cargo][${cargoIndex}][package_description]" class="form-control" required></td>
<td><input type="number" name="lr[${index}][cargo][${cargoIndex}][actual_weight]" class="form-control" required></td>
<td><input type="number" name="lr[${index}][cargo][${cargoIndex}][charged_weight]" class="form-control charged-weight" required oninput="calculateTotal(${index}, 'charged-weight', 'totalChargedWeight-${index}')"></td>
<td>
<select name="lr[${index}][cargo][${cargoIndex}][unit]" class="form-select" required>
<option value="">Select Unit</option>
<option value="kg">Kg</option>
<option value="ton">Ton</option>
</select>
</td>
<td><input type="text" name="lr[${index}][cargo][${cargoIndex}][document_no]" class="form-control" required></td>
<td><input type="text" name="lr[${index}][cargo][${cargoIndex}][document_name]" class="form-control" required></td>
<td><input type="date" name="lr[${index}][cargo][${cargoIndex}][document_date]" class="form-control" required></td>
<td><input type="file" name="lr[${index}][cargo][${cargoIndex}][document_file]" class="form-control"></td>
<td><input type="text" name="lr[${index}][cargo][${cargoIndex}][eway_bill]" class="form-control" required></td>
<td><input type="date" name="lr[${index}][cargo][${cargoIndex}][valid_upto]" class="form-control" required></td>
<td><input type="number" name="lr[${index}][cargo][${cargoIndex}][declared_value]" class="form-control declared-value" required oninput="calculateTotal(${index}, 'declared-value', 'totalDeclaredValue-${index}')"></td>
<td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this, ${index})">🗑</button></td>
`;

tbody.appendChild(row);
initializeCargoTable(index);
}

// Remove cargo row
function removeRow(button, index) {
    button.closest('tr').remove();
    calculateTotal(index, 'declared-value', `totalDeclaredValue-${index}`);
    calculateTotal(index, 'charged-weight', `totalChargedWeight-${index}`);
}



// Handle vehicle_type, from_location, to_location changes for contract method
document.addEventListener('change', function (e) {
    if (e.target.matches('select[name^="lr"][name$="[vehicle_type]"], select[name^="lr"][name$="[from_location]"], select[name^="lr"][name$="[to_location]"]')) {
        const nameAttr = e.target.name;
        const match = nameAttr.match(/lr\[(\d+)\]/);
        if (!match) return;
        const counter = match[1];

        const orderMethod = document.querySelector('input[name="order_method"]:checked')?.value;
        if (orderMethod === 'contract') {
            fetchRateForLR(counter);
        }
    }
});

// Initialize insurance visibility on load
for (let i = 0; i < lrCounter; i++) {
    toggleInsuranceInput(i);
}
</script>




<
{{-- add lr code-----------------------------addlr code------------------------------------------------ --}}
<script>
let lrIndex = {{ count($lrData)?? 0  }}; // Start from existing count


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
               <select name="lr[${lrIndex}][consignor_id]" id="consignor_id_${lrIndex}" class="form-select" onchange="setConsignorDetails(${lrIndex})" required>
    <option value="">Select Consignor</option>
    @foreach($users as $user)
        @php
            $addresses = json_decode($user->address, true);
        @endphp
        @if(!empty($addresses) && is_array($addresses))
            @foreach($addresses as $address)
                <option value="{{ $user->id }}"
                    data-gst-consignor="{{ $address['gstin'] ?? '' }}"
                    data-address-consignor="{{ $address['billing_address'] ?? '' }}">
                    {{ $user->name }} - {{ $address['city'] ?? '' }}
                </option>
            @endforeach
        @endif
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
        @endphp
        @if(!empty($addresses) && is_array($addresses))
            @foreach($addresses as $address)
                <option value="{{ $user->id }}"
                    data-gst-consignee="{{ $address['gstin'] ?? '' }}"
                    data-address-consignee="{{ $address['billing_address'] ?? '' }}">
                    {{ $user->name }} - {{ $address['city'] ?? '' }}
                </option>
            @endforeach
        @endif
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
                   <option >Select Vehicle NO.</option>
                           @foreach ($vehicles as $vehicle)
                           <option value="{{ $vehicle->vehicle_no }}">
                              {{ $vehicle->vehicle_no }}
                           </option>
                         @endforeach              
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">🚛 Vehicle Type</label>
                <select name="lr[${lrIndex}][vehicle_type]" id="vehicle_type${lrIndex}" class="form-select" fetchRateForLR(${lrIndex})" required>
                    <option value="">Select Vehicle Type</option>
                    @foreach ($vehiclesType as $type)
                        <option value="{{ $type->id }}">{{ $type->vehicletype }}</option>
                    @endforeach
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
                    <option value="godwon_deliver">Godown Deliver</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">📍 From (Origin)</label>
                <select name="lr[${lrIndex}][from_location]" id="from_location${lrIndex}" class="form-select" fetchRateForLR(${lrIndex})" required>
                    <option value="">Select Origin</option>
                    @foreach ($destination as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->destination }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">📍 To (Destination)</label>
                <select name="lr[${lrIndex}][to_location]" id="to_location${lrIndex}" class="form-select" fetchRateForLR(${lrIndex})" required>
                    <option value="">Select Destination</option>
                    @foreach ($destination as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->destination }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3">
                <label class="form-label">💰 Order Rate</label>
                <input type="number" name="lr[${lrIndex}][order_rate]" class="form-control" id="rate_input${lrIndex}"  placeholder="Enter Amount" readonly>
            </div>
        <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
            <label class="form-label mb-0">🛡️ Insurance?</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input"
                       type="radio"
                       name="lr[${lrIndex}][insurance_status]"
                       value="yes"
                       id="insuranceYes${lrIndex}"
                       onchange="toggleInsuranceInput(${lrIndex})">
                <label class="form-check-label" for="insuranceYes${lrIndex}">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input"
                       type="radio"
                       name="lr[${lrIndex}][insurance_status]"
                       value="no"
                       id="insuranceNo${lrIndex}"
                       onchange="toggleInsuranceInput(${lrIndex})"
                       checked>
                <label class="form-check-label" for="insuranceNo${lrIndex}">No</label>
            </div>
            <input type="text"
                   class="form-control d-none"
                   name="lr[${lrIndex}][insurance_description]"
                   id="insuranceInput${lrIndex}"
                   placeholder="Enter Insurance Number"
                   style="max-width: 450px;">
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
                <div class="table-responsive" id="lr_section_${lrIndex}">
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
            <th>Declared Value</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="cargoTableBody_${lrIndex}">
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
            <td>
                <input
                    type="number"
                    class="form-control charged-weight"
                    name="lr[${lrIndex}][cargo][0][charged_weight]"
                    placeholder="0"
                    required
                    oninput="calculateTotals(${lrIndex})">
            </td>
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
            <td>
                <input
                    type="number"
                    class="form-control declared-value"
                    name="lr[${lrIndex}][cargo][0][declared_value]"
                    placeholder="0"
                    oninput="calculateTotals(${lrIndex})">
            </td>
            <td><button class="btn btn-danger btn-sm" onclick="removeRow(this, ${lrIndex})">🗑</button></td>
        </tr>
    </tbody>
</table>
                </div>
                <div class="text-end mt-2">
                    <button type="button" class="btn btn-sm btn-add-cargo-row" onclick="addCargoRowNew(${lrIndex})" style="background: #ca2639; color: white;">
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
                    <table class="table table-bordered align-middle text-center" id="freightTable-${lrIndex}">
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
                                <td>
                                    <input type="number" name="lr[${lrIndex}][freight_amount]" class="form-control" id="finalResult-${lrIndex}" required readonly>
                                </td>
                               
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
    <label class="form-label"><strong>💰 Total Charged Weight (Kg)</strong></label>
    <input
        type="text"
        class="form-control"
        id="total_charged_weight_${lrIndex}"
        name="lr[${lrIndex}][total_charged_weight]"
        placeholder="Total Charged Weight"
        readonly>
    <label class="form-label"><strong>💰 Total Declared Value (Rs.)</strong></label>
    <input
        type="text"
        class="form-control"
        id="total_declared_value_${lrIndex}"
        name="lr[${lrIndex}][total_declared_value]"
        placeholder="Total Declared Value"
        readonly>
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
    function initializeNewLR(lrIndex) {
    toggleFreightTable(lrIndex);
    calculateTotals(lrIndex);
    fetchRateForLR(lrIndex);
}
    lrIndex++;
  
}

function removeLrRow(button) {
    const section = button.closest('.row.mt-4');
    if (section) section.remove();
}

function removeRow(button) {
    const row = button.closest('tr');
    if (row) row.remove();
}
</script>
<script>

function toggleInsuranceInput(lrIndex) {
    const insuranceYes = document.getElementById(`insuranceYes${lrIndex}`);
    const insuranceInput = document.getElementById(`insuranceInput${lrIndex}`);
    if (insuranceYes.checked) {
        insuranceInput.classList.remove('d-none');
        insuranceInput.required = true;
    } else {
        insuranceInput.classList.add('d-none');
        insuranceInput.required = false;
        insuranceInput.value = '';
    }
}

</script>




<script>
   // Function to remove a row
   function removeRow(lrIndex, rowIndex) {
   document.getElementById(`cargoRow_${lrIndex}_${rowIndex}`).remove();
   }
   
   // Function to generate and add a new cargo row
   function addCargoRowNew(lrIndex) {
   const rowCount = document.querySelectorAll(`#cargoTableBody_${lrIndex} tr`).length;
   const newRowId = `cargoRow_${lrIndex}_${rowCount}`;
   const newRow = `
   <tr id="${newRowId}">
   <td><input type="number" class="form-control" name="lr[${lrIndex}][cargo][${rowCount}][packages_no]" placeholder="0" required></td>
   <td>
   <select class="form-select" name="lr[${lrIndex}][cargo][${rowCount}][package_type]" required>
   <option>Pallets</option>
   <option>Cartons</option>
   <option>Bags</option>
   </select>
   </td>
   <td><input type="text" class="form-control" name="lr[${lrIndex}][cargo][${rowCount}][package_description]" placeholder="Enter description" required></td>
   <td><input type="number" class="form-control" name="lr[${lrIndex}][cargo][${rowCount}][actual_weight]" placeholder="0" required></td>
  
     <td>
        <input
            type="number"
            class="form-control charged-weight"
            name="lr[${lrIndex}][cargo][${rowCount}][charged_weight]"
            placeholder="0"
            required
            oninput="calculateTotals(${lrIndex})">
    </td>
   <td>
   <select class="form-select" name="lr[${lrIndex}][cargo][${rowCount}][unit]" required>
   <option value="">Select Unit</option>
   <option value="kg">Kg</option>
   <option value="ton">Ton</option>
   </select>
   </td>
   <td><input type="text" class="form-control" name="lr[${lrIndex}][cargo][${rowCount}][document_no]" placeholder="Doc No." required></td>
   <td><input type="text" class="form-control" name="lr[${lrIndex}][cargo][${rowCount}][document_name]" placeholder="Doc Name" required></td>
   <td><input type="date" class="form-control" name="lr[${lrIndex}][cargo][${rowCount}][document_date]" required></td>
   <td><input type="file" class="form-control" name="lr[${lrIndex}][cargo][${rowCount}][document_file]" required></td>
   <td><input type="text" class="form-control" name="lr[${lrIndex}][cargo][${rowCount}][eway_bill]" placeholder="Eway Bill No." required></td>
   <td><input type="date" class="form-control" name="lr[${lrIndex}][cargo][${rowCount}][valid_upto]" required></td>
   <td>
    <input
        type="number"
        class="form-control declared-value"
        name="lr[${lrIndex}][cargo][${rowCount}][declared_value]"
        placeholder="0"
        oninput="calculateTotals(${lrIndex})">
</td>
   <td><button class="btn btn-danger btn-sm" onclick="removeRow(${lrIndex}, ${rowCount})">🗑</button></td>
   </tr>
   `;
   document.querySelector(`#cargoTableBody_${lrIndex}`).insertAdjacentHTML('beforeend', newRow);
   }
   </script>
   
   
   <!-- ADD CARGONEW LR -->
   

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

<script>
    // Function to toggle the visibility of the insurance input field
    function toggleInsuranceInput(lrIndex) {
        const insuranceYes = document.getElementById(`insuranceYes${lrIndex}`);
        const insuranceNo = document.getElementById(`insuranceNo${lrIndex}`);
        const insuranceInput = document.getElementById(`insuranceInput${lrIndex}`);

        if (insuranceYes.checked) {
            // If 'Yes' is selected, show the input field
            insuranceInput.classList.remove('d-none');
        } else {
            // If 'No' is selected, hide the input field
            insuranceInput.classList.add('d-none');
        }
    }

    
    document.addEventListener("DOMContentLoaded", function() {
        const lrIndex = 1; // Replace with dynamic value if needed
        toggleInsuranceInput(lrIndex); // Call function on page load to set the initial state
    });
</script>
{{-- new lr insourance  --}}
<script>
   function toggleFreightTable(lrIndex) {
    const toBeBilled = document.getElementById(`freightToBeBilled-${lrIndex}`);
    const tableBody = document.getElementById(`freightTableBody-${lrIndex}`);
   
    if (toBeBilled.checked) {
        tableBody.style.display = 'none'; 
    } else {
        tableBody.style.display = ''; 
    }
   }
    
</script>
<script>
    function calculateTotals(lrIndex) {
    let totalChargedWeight = 0;
    let totalDeclaredValue = 0;

    document.querySelectorAll(`#cargoTableBody_${lrIndex} tr`).forEach(row => {
        const chargedWeight = parseFloat(row.querySelector('.charged-weight')?.value) || 0;
        const declaredValue = parseFloat(row.querySelector('.declared-value')?.value) || 0;
        totalChargedWeight += chargedWeight;
        totalDeclaredValue += declaredValue;
    });

    document.getElementById(`total_charged_weight_${lrIndex}`).value = totalChargedWeight.toFixed(2);
    document.getElementById(`total_declared_value_${lrIndex}`).value = totalDeclaredValue.toFixed(2);

    updateFreightAndTotals(lrIndex);
}

// Event listener for cargo row inputs
document.addEventListener('input', function(e) {
    if (e.target.matches(`#cargoTableBody_${e.target.closest('tbody').id.replace('cargoTableBody_', '')} .charged-weight, #cargoTableBody_${e.target.closest('tbody').id.replace('cargoTableBody_', '')} .declared-value`)) {
        const lrIndex = e.target.closest('tbody').id.replace('cargoTableBody_', '');
        calculateTotals(lrIndex);
    }
});
</script>
<Script>
 function toggleOrderMethod() {
    const orderMethod = document.querySelector('input[name="order_method"]:checked')?.value;
    const orderAmountDiv = document.getElementById('orderAmountDiv');
    orderAmountDiv.classList.toggle('d-none', orderMethod !== 'order');

    if (orderMethod === 'order') {
        const orderAmount = document.querySelector('input[name="byOrder"]').value || 0;
        document.querySelectorAll('input[id^="rate_input"]').forEach(input => {
            const lrIndex = input.id.replace('rate_input', '');
            input.value = orderAmount;
            window.lrRates = window.lrRates || {};
            window.lrRates[lrIndex] = parseFloat(orderAmount) || 0;
            updateFreightAndTotals(lrIndex);
        });
    } else {
        // For contract, fetch rates for each LR
        document.querySelectorAll('select[name^="lr"][name$="[vehicle_type]"]').forEach(select => {
            const lrIndex = select.name.match(/lr\[(\d+)\]/)[1];
            fetchRateForLR(lrIndex);
        });
    }
}

function fetchRateForLR(lrIndex) {
    const vehicleType = document.querySelector(`select[name="lr[${lrIndex}][vehicle_type]"]`)?.value;
    const fromLocation = document.querySelector(`select[name="lr[${lrIndex}][from_location]"]`)?.value;
    const toLocation = document.querySelector(`select[name="lr[${lrIndex}][to_location]"]`)?.value;
    const customerId = document.getElementById('customer_id')?.value;

    if (!vehicleType || !fromLocation || !toLocation || !customerId) return;

    const orderMethod = document.querySelector('input[name="order_method"]:checked')?.value;
    if (orderMethod === 'contract') {
        fetch('/admin/get-rate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                customer_id: customerId,
                vehicle_type: vehicleType,
                from_location: fromLocation,
                to_location: toLocation
            })
        })
        .then(res => res.json())
        .then(data => {
            const rateInput = document.getElementById(`rate_input${lrIndex}`);
            window.lrRates = window.lrRates || {};
            if (data.rate) {
                rateInput.value = data.rate;
                window.lrRates[lrIndex] = parseFloat(data.rate) || 0;
            } else {
                rateInput.value = 0;
                window.lrRates[lrIndex] = 0;
            }
            updateFreightAndTotals(lrIndex);
        })
        .catch(err => console.error('Error:', err));
    }
}

// Event listener for changes in vehicle_type, from_location, to_location
document.addEventListener('change', function(e) {
    if (e.target.matches('select[name^="lr"][name$="[vehicle_type]"], select[name^="lr"][name$="[from_location]"], select[name^="lr"][name$="[to_location]"]')) {
        const lrIndex = e.target.name.match(/lr\[(\d+)\]/)[1];
        fetchRateForLR(lrIndex);
    }
});

// Event listener for order amount input
document.querySelector('input[name="byOrder"]').addEventListener('input', function() {
    toggleOrderMethod();
});
</script>
<script>
   function updateFreightAndTotals(lrIndex) {
    const freightType = document.querySelector(`input[name="lr[${lrIndex}][freightType]"]:checked`)?.value;
    if (freightType === 'to_be_billed') {
        document.getElementById(`finalResult-${lrIndex}`).value = 0;
        return;
    }

    const totalChargedWeight = parseFloat(document.getElementById(`total_charged_weight_${lrIndex}`).value) || 0;
    const rate = window.lrRates?.[lrIndex] || 0;
    const freightAmount = totalChargedWeight * rate;

    const freightInput = document.getElementById(`finalResult-${lrIndex}`);
    freightInput.value = freightAmount.toFixed(2);

    // Recalculate freight table
    const row = freightInput.closest('tr');
    const lrCharges = parseFloat(row.querySelector('input[name^="lr"][name$="[lr_charges]"]')?.value) || 0;
    const hamali = parseFloat(row.querySelector('input[name^="lr"][name$="[hamali]"]')?.value) || 0;
    const otherCharges = parseFloat(row.querySelector('input[name^="lr"][name$="[other_charges]"]')?.value) || 0;
    const lessAdvance = parseFloat(row.querySelector('input[name^="lr"][name$="[less_advance]"]')?.value) || 0;

    const subtotal = freightAmount + lrCharges + hamali + otherCharges;
    const gstPercent = 12;
    const gstAmount = subtotal * gstPercent / 100;
    const totalFreight = subtotal + gstAmount;
    const balance = totalFreight - lessAdvance;

    row.querySelector('input[name^="lr"][name$="[gst_amount]"]').value = gstAmount.toFixed(2);
    row.querySelector('input[name^="lr"][name$="[total_freight]"]').value = totalFreight.toFixed(2);
    row.querySelector('input[name^="lr"][name$="[balance_freight]"]').value = balance.toFixed(2);
}

// Event listener for freight table inputs
document.addEventListener('input', function(e) {
    if (e.target.matches('input[name^="lr"][name$="[lr_charges]"], input[name^="lr"][name$="[hamali]"], input[name^="lr"][name$="[other_charges]"], input[name^="lr"][name$="[less_advance]"]')) {
        const lrIndex = e.target.name.match(/lr\[(\d+)\]/)[1];
        updateFreightAndTotals(lrIndex);
    }
}); 
</script>
<script>
   function toggleFreightTable(lrIndex) {
    const freightType = document.querySelector(`input[name="lr[${lrIndex}][freightType]"]:checked`)?.value;
    const freightTable = document.getElementById(`freightTable-${lrIndex}`);
    freightTable.classList.toggle('d-none', freightType === 'to_be_billed');
    updateFreightAndTotals(lrIndex);
}

// Add event listener for freight type change
document.addEventListener('change', function(e) {
    if (e.target.matches('input[name^="lr"][name$="[freightType]"]')) {
        const lrIndex = e.target.name.match(/lr\[(\d+)\]/)[1];
        toggleFreightTable(lrIndex);
    }
}); 
</script>

          
 {{-- ------------------------------------------------------------------------------------------------------ --}}
            <script>
                function toggleInsuranceInput(index) {
                   const isYes = $(`#insuranceYes_${index}`).is(':checked');
                   const input = $(`#insuranceInput_${index}`);
             
                   if (isYes) {
                      input.removeClass('d-none');
                   } else {
                      input.addClass('d-none').val('');
                   }
                }
             
                // Optional: initialize on page load
                $(document).ready(function () {
                   $('[id^="insuranceYes_"]').each(function () {
                      const index = $(this).attr('id').split('_')[1];
                      toggleInsuranceInput(index);
                   });
                });
             </script>
             <!-- Freight -->
             <script>
                function toggleFreightTable(index) {
                    const selectedType = $(`input[name="lr[${index}][freightType]"]:checked`).val();
                    const table = $(`#freight-table-${index}`);
             
                  
                    if (selectedType === 'to_be_billed') {
                        table.closest('.table-responsive').hide(); // Hide the table container
                    } else {
                        table.closest('.table-responsive').show(); // Show the table if Paid or To Pay is selected
                    }
                }
             
                // Initialize visibility on page load
                $(document).ready(function () {
                    $('[id^="freight-table-"]').each(function () {
                        const index = $(this).attr('id').split('-')[2]; // extract index from table ID
                        toggleFreightTable(index); // Set visibility based on the current selected radio button
                    });
                });
             </script>
    <script>
    function setConsignorDetails(lrIndex) {
    const select = document.getElementById(`consignor_id_${lrIndex}`);
    const selected = select.options[select.selectedIndex];
    const gst = selected?.dataset.gstConsignor || '';
    const address = selected?.dataset.addressConsignor || '';
    document.getElementById(`consignor_gst_${lrIndex}`).value = gst;
    document.getElementById(`consignor_loading_${lrIndex}`).value = address;
}

function setConsigneeDetails(lrIndex) {
    const select = document.getElementById(`consignee_id_${lrIndex}`);
    const selected = select.options[select.selectedIndex];
    const gst = selected?.dataset.gstConsignee || '';
    const address = selected?.dataset.addressConsignee || '';
    document.getElementById(`consignee_gst_${lrIndex}`).value = gst;
    document.getElementById(`consignee_unloading_${lrIndex}`).value = address;
}

    </script>
  
   
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection