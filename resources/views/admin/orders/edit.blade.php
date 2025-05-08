
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
                  <input type="number"  min="0" name="byOrder" class="form-control" placeholder="Enter Amount" value="{{ $orderAmount }}" oninput="showOrderAmountAlert(this.value)" {{ $method == 'order' ? 'required' : '' }}>
               </div>
                <div class="mb-3 {{ $method == 'contract' ? '' : 'd-none' }}" id="contractNumberDiv">
                        <label class="form-label">📜 CONTRACT NUMBER</label>
                        <input type="text" name="byContract" class="form-control" placeholder="Enter Contract Number" value="{{ $contractNumber }}" {{ $method == 'contract' ? 'required' : '' }}>
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
                  <label class="form-label">LR Date</label>
                  <input required type="date" name="lr[{{ $index }}][lr_date]" class="form-control" placeholder="Enter LR date" value="{{ $lr['lr_date'] ?? '' }}">
               </div>
               <div class="col-md-3">
                  <label class="form-label">🚚 Consignor Name</label>
                  <select name="lr[{{ $index }}][consignor_id]" id="consignor_id_{{ $index }}" class="form-select" onchange="setConsignorDetailsExisting({{ $index }})" required>
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
                  <select name="lr[{{ $index }}][consignee_id]" id="consignee_id_{{ $index }}" class="form-select" onchange="setConsigneeDetailsExisting({{ $index }})" required>
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
                  <select name="lr[{{ $index }}][vehicle_no]" id="vehicle_id_{{ $index }}" class="form-select" onchange="fillVehicleDetailsExisting({{ $index }})" required>
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
                  <select name="lr[{{ $index }}][vehicle_type]" class="form-select" onchange="fetchRateForLRExisting({{ $index }})" required>
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
                     <select name="lr[{{ $index }}][from_location]" class="form-select" onchange="fetchRateForLRExisting({{ $index }})" required>
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
                     <select name="lr[{{ $index }}][to_location]" class="form-select" onchange="fetchRateForLRExisting({{ $index }})" required>
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
                  <input type="number" name="lr[{{ $index }}][order_rate]" step="0.01" class="form-control" id="rate_input_{{ $index }}" value="{{ $lr['order_rate'] ?? '' }}" readonly>
               </div>
            </div>
            <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
               <label class="form-label mb-0">🛡️ Insurance?</label>
               <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio"
                        name="lr[{{ $index }}][insurance_status]"
                        value="yes"
                        id="insurance_yes_{{ $index }}"
                        onchange="toggleInsuranceInputExisting({{ $index }})"
                        {{ old("lr.$index.insurance_status", $lr['insurance_status'] ?? '') == 'yes' ? 'checked' : '' }}>
                  <label class="form-check-label" for="insurance_yes_{{ $index }}">Yes</label>
               </div>
               <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio"
                        name="lr[{{ $index }}][insurance_status]"
                        value="no"
                        id="insurance_no_{{ $index }}"
                        onchange="toggleInsuranceInputExisting({{ $index }})"
                        {{ old("lr.$index.insurance_status", $lr['insurance_status'] ?? 'no') == 'no' ? 'checked' : '' }}>
                  <label class="form-check-label" for="insurance_no_{{ $index }}">No</label>
               </div>
               <input type="text"
                     class="form-control insurance-input {{ old("lr.$index.insurance_status", $lr['insurance_status'] ?? 'no') != 'yes' ? 'd-none' : '' }}"
                     name="lr[{{ $index }}][insurance_description]"
                     id="insurance_input_{{ $index }}"
                     placeholder="Enter Insurance Number"
                     style="max-width: 450px;"
                     value="{{ old("lr.$index.insurance_description", $lr['insurance_description'] ?? '') }}">
            </div>
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
                              <th >Actual Weight (kg) </th>
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
                        <tbody id="cargo_table_body_{{ $index }}">
                           @foreach ($cargoData as $cargoIndex => $cargo)
                           <tr>
                              <td><input type="number" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][packages_no]" class="form-control" value="{{ $cargo['packages_no'] ?? '' }}"  min="0" step="0.01" required></td>
                              <td>
                                 <select name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][package_type]" class="form-select" required>
                                    <option value="Pallets" {{ $cargo['package_type'] == 'Pallets' ? 'selected' : '' }}>Pallets</option>
                                    <option value="Cartons" {{ $cargo['package_type'] == 'Cartons' ? 'selected' : '' }}>Cartons</option>
                                    <option value="Bags" {{ $cargo['package_type'] == 'Bags' ? 'selected' : '' }}>Bags</option>
                                 </select>
                              </td>
                              <td><input type="text" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][package_description]" class="form-control" value="{{ $cargo['package_description'] ?? '' }}" required></td>
                              <td><input type="number" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][actual_weight]" class="form-control" value="{{ $cargo['actual_weight'] ?? '' }}" placeholder="0"  min="0" step="0.01" required></td>
                              <td><input type="number" name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][charged_weight]" class="form-control charged-weight" value="{{ $cargo['charged_weight'] ?? '' }}" placeholder="0"  min="0" step="0.01" required oninput="calculateTotalsExisting({{ $index }})"></td>
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
                                 <input name="lr[{{ $index }}][cargo][{{ $cargoIndex }}][declared_value]" placeholder="0"  min="0" step="0.01" type="number" value="{{ $cargo['declared_value'] ?? '' }}" class="form-control declared-value" placeholder="0" required oninput="calculateTotalsExisting({{ $index }})">
                              </td>
                              <td>
                                 <button type="button" class="btn btn-danger btn-sm" onclick="removeRowExisting(this, {{ $index }})">🗑</button>
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                     <div class="text-end mt-2">
                        <button type="button" class="btn btn-sm btn-primary" onclick="addCargoRowExisting({{ $index }})">
                           ➕ Add Row
                        </button>
                     </div>
                  </div>
               </div>
               <div class="row mt-4">
                  <div class="col-12">
                     <h5 class="pb-3">🚚 Freight Details</h5>
                     @php $freightType = old("lr.$index.freightType", $lr['freightType'] ?? 'paid'); @endphp
                     <div class="mb-3 d-flex gap-3">
                        <div class="form-check form-check-inline">
                           <input class="form-check-input freight-type" type="radio" name="lr[{{ $index }}][freightType]" id="freight_paid_{{ $index }}" value="paid" onchange="toggleFreightTableExisting({{ $index }})" {{ $freightType === 'paid' ? 'checked' : '' }}>
                           <label class="form-check-label" for="freight_paid_{{ $index }}">Paid</label>
                        </div>
                        <div class="form-check form-check-inline">
                           <input class="form-check-input freight-type" type="radio" name="lr[{{ $index }}][freightType]" id="freight_to_pay_{{ $index }}" value="to_pay" onchange="toggleFreightTableExisting({{ $index }})" {{ $freightType === 'to_pay' ? 'checked' : '' }}>
                           <label class="form-check-label" for="freight_to_pay_{{ $index }}">To Pay</label>
                        </div>
                        <div class="form-check form-check-inline">
                           <input class="form-check-input freight-type" type="radio" name="lr[{{ $index }}][freightType]" id="freight_to_be_billed_{{ $index }}" value="to_be_billed" onchange="toggleFreightTableExisting({{ $index }})" {{ $freightType === 'to_be_billed' ? 'checked' : '' }}>
                           <label class="form-check-label" for="freight_to_be_billed_{{ $index }}">To Be Billed</label>
                        </div>
                     </div>
                     <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center" id="freight_table_{{ $index }}">
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
                           <tbody id="freight_table_body_{{ $index }}">
                              <tr>
                                 <td><input name="lr[{{ $index }}][freight_amount]" id="freight_amount_{{ $index }}" type="number" class="form-control freight-amount" value="{{ $lr['freight_amount'] ?? '' }}" step="0.01"  min="0" placeholder="Enter Freight Amount" readonly></td>
                                 <td><input name="lr[{{ $index }}][lr_charges]" type="number" class="form-control lr-charges" value="{{ $lr['lr_charges'] ?? '' }}" step="0.01"  min="0" placeholder="Enter LR Charges" oninput="updateFreightAndTotalsExisting({{ $index }})"></td>
                                 <td><input name="lr[{{ $index }}][hamali]" type="number" class="form-control hamali" value="{{ $lr['hamali'] ?? '' }}" step="0.01"  min="0" placeholder="Enter Hamali Charges" oninput="updateFreightAndTotalsExisting({{ $index }})"></td>
                                 <td><input name="lr[{{ $index }}][other_charges]" type="number" class="form-control other-charges" value="{{ $lr['other_charges'] ?? '' }}" step="0.01"  min="0" placeholder="Enter Other Charges" oninput="updateFreightAndTotalsExisting({{ $index }})"></td>
                                 <td><input name="lr[{{ $index }}][gst_amount]" type="number" class="form-control gst" value="{{ $lr['gst_amount'] ?? '' }}" step="0.01"  min="0" placeholder="Enter GST Amount" readonly></td>
                                 <td><input name="lr[{{ $index }}][total_freight]" type="number" class="form-control total-freight" value="{{ $lr['total_freight'] ?? '' }}" step="0.01"  min="0" placeholder="Enter Total Freight" readonly></td>
                                 <td><input name="lr[{{ $index }}][less_advance]" type="number" class="form-control less-advance" value="{{ $lr['less_advance'] ?? '' }}" step="0.01"  min="0" placeholder="Enter Less Advance" oninput="updateFreightAndTotalsExisting({{ $index }})"></td>
                                 <td><input name="lr[{{ $index }}][balance_freight]" type="number" class="form-control balance-freight" value="{{ $lr['balance_freight'] ?? '' }}" step="0.01"  min="0" placeholder="Enter Balance Freight" readonly></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="row mt-3">
                  <div class="col-md-6">
                     <div class="mt-3">
                        {{-- <label><strong>💰 Total Charged Weight (Kg)</strong></label> --}}
                        <input type="hidden" id="total_charged_weight_{{ $index }}" name="lr[{{ $index }}][total_charged_weight]" class="form-control" value="{{ $lr['total_charged_weight'] ?? '' }}" readonly>
                        <label><strong>💰 Total Declared Value (Rs.)</strong></label>
                        <input type="text" id="total_declared_value_{{ $index }}" name="lr[{{ $index }}][total_declared_value]" class="form-control" value="{{ $lr['total_declared_value'] ?? '' }}" readonly>
                     </div>
                  </div>
               </div>
            </div>
         @endforeach
         <div id="lr_container"></div>
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

<!-- JavaScript for Existing LRs -->
<script>
// Global variables for existing LRs
let existingLrRates = {};
let existingCargoCounters = {};
let currentOrderAmount = parseFloat('{{ old("byOrder", $order->byorder ?? 0) }}') || 0;
let currentContractAmount = '{{ old("contract_number", $order->bycontract ?? "") }}';

// Initialize on page load
document.addEventListener('DOMContentLoaded', function () {
    // Initialize cargo counters and calculations
    document.querySelectorAll('[id^="cargo_table_body_"]').forEach(tbody => {
        const index = tbody.id.split('_')[3];
        existingCargoCounters[index] = document.querySelectorAll(`#cargo_table_body_${index} tr`).length;
        calculateTotalsExisting(index);
    });

    // Initialize rates for existing LRs
    @foreach($lrData as $index => $lr)
        existingLrRates[{{ $index }}] = parseFloat('{{ $lr["order_rate"] ?? 0 }}') || 0;
        const rateInput{{ $index }} = document.getElementById(`rate_input_{{ $index }}`);
        if (rateInput{{ $index }}) rateInput{{ $index }}.value = existingLrRates[{{ $index }}].toFixed(2);
        updateFreightAndTotalsExisting({{ $index }});
    @endforeach

    // Set initial customer details
    const customerSelect = document.getElementById('customer_id');
    if (customerSelect?.value) setCustomerDetails();

    // Initialize consignor/consignee, freight tables, and insurance
    document.querySelectorAll('.lr-section').forEach(section => {
        const index = section.dataset.lrIndex;
        if (document.getElementById(`consignor_id_${index}`)?.value) setConsignorDetailsExisting(index);
        if (document.getElementById(`consignee_id_${index}`)?.value) setConsigneeDetailsExisting(index);
        toggleFreightTableExisting(index);
        toggleInsuranceInputExisting(index);
    });

    // Initialize order method
    toggleOrderMethod();
});

// Customer details
function setCustomerDetails() {
    const select = document.getElementById('customer_id');
    const gst = select.options[select.selectedIndex]?.dataset.gst || '';
    const address = select.options[select.selectedIndex]?.dataset.address || '';
    document.getElementById('gst_number').value = gst;
    document.getElementById('customer_address').value = address;

    // Update rates for contract method
    if (document.querySelector('input[name="order_method"]:checked')?.value === 'contract') {
        document.querySelectorAll('.lr-section').forEach(section => {
            const index = section.dataset.lrIndex;
            fetchRateForLRExisting(index);
        });
        // Trigger rate fetch for new LRs (handled in new LR script)
        document.querySelectorAll('#lr_container .row.mt-4').forEach(section => {
            const index = section.querySelector('input[name^="lr["]')?.name.match(/lr\[(\d+)\]/)[1];
            fetchRateForLRNew(index);
        });
    }
}

// Consignor details for existing LRs
function setConsignorDetailsExisting(index) {
    const select = document.getElementById(`consignor_id_${index}`);
    const gst = select.options[select.selectedIndex]?.dataset.gstConsignor || '';
    const address = select.options[select.selectedIndex]?.dataset.addressConsignor || '';
    document.getElementById(`consignor_gst_${index}`).value = gst;
    document.getElementById(`consignor_loading_${index}`).value = address;
}

// Consignee details for existing LRs
function setConsigneeDetailsExisting(index) {
    const select = document.getElementById(`consignee_id_${index}`);
    const gst = select.options[select.selectedIndex]?.dataset.gstConsignee || '';
    const address = select.options[select.selectedIndex]?.dataset.addressConsignee || '';
    document.getElementById(`consignee_gst_${index}`).value = gst;
    document.getElementById(`consignee_unloading_${index}`).value = address;
}

// Vehicle details (stub)
function fillVehicleDetailsExisting(index) {
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

        // Update rates for existing LRs
        document.querySelectorAll('.lr-section').forEach(section => {
            const index = section.dataset.lrIndex;
            existingLrRates[index] = currentOrderAmount;
            const rateInput = document.getElementById(`rate_input_${index}`);
            if (rateInput) rateInput.value = currentOrderAmount.toFixed(2);
            updateFreightAndTotalsExisting(index);
        });

        // Update rates for new LRs
        document.querySelectorAll('#lr_container .row.mt-4').forEach(section => {
            const index = section.querySelector('input[name^="lr["]')?.name.match(/lr\[(\d+)\]/)[1];
            newLrRates[index] = currentOrderAmount;
            const rateInput = document.getElementById(`rate_input_${index}`);
            if (rateInput) rateInput.value = currentOrderAmount.toFixed(2);
            updateFreightAndTotalsNew(index);
        });
    } else if (contractRadio.checked) {
        contractNumberDiv.classList.remove('d-none');
        contractNumberDiv.querySelector('input').setAttribute('required', 'required');
        orderAmountDiv.classList.add('d-none');
        orderAmountDiv.querySelector('input').removeAttribute('required');
        currentContractAmount = document.querySelector('input[name="byContract"]')?.value || '';
        currentOrderAmount = 0;

        // Fetch rates for existing LRs
        document.querySelectorAll('.lr-section').forEach(section => {
            const index = section.dataset.lrIndex;
            fetchRateForLRExisting(index);
        });

        // Fetch rates for new LRs
        document.querySelectorAll('#lr_container .row.mt-4').forEach(section => {
            const index = section.querySelector('input[name^="lr["]')?.name.match(/lr\[(\d+)\]/)[1];
            fetchRateForLRNew(index);
        });
    }
}

// Fetch rate for existing LRs (unchanged, included for reference)
function fetchRateForLRExisting(index) {
    const orderMethod = document.querySelector('input[name="order_method"]:checked')?.value;

    const vehicle_type = document.querySelector(`select[name="lr[${index}][vehicle_type]"]`)?.value || '';
    const from_location = document.querySelector(`select[name="lr[${index}][from_location]"]`)?.value || '';
    const to_location = document.querySelector(`select[name="lr[${index}][to_location]"]`)?.value || '';
    const customer_id = document.getElementById('customer_id')?.value || '';

    const rateInput = document.getElementById(`rate_input_${index}`);

    // If orderMethod is 'order', use currentOrderAmount and skip AJAX
    if (orderMethod === 'order' && currentOrderAmount) {
        existingLrRates[index] = parseFloat(currentOrderAmount) || 0;
        rateInput.value = existingLrRates[index].toFixed(2);
        updateFreightAndTotalsExisting(index);
        return;
    }

    // Proceed with AJAX only if orderMethod is 'contract'
    if (!vehicle_type || !from_location || !to_location || !customer_id) {
        updateFreightAndTotalsExisting(index);
        return;
    }

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
        existingLrRates[index] = parseFloat(data.rate) || 0;
        rateInput.value = existingLrRates[index].toFixed(2);
        updateFreightAndTotalsExisting(index);
    })
    .catch(err => {
        console.error('Error fetching rate:', err);
        updateFreightAndTotalsExisting(index);
    });
}

// Calculate totals for existing LRs
function calculateTotalsExisting(index) {
    let totalChargedWeight = 0;
    let totalDeclaredValue = 0;

    document.querySelectorAll(`#cargo_table_body_${index} tr`).forEach(row => {
        const chargedWeight = parseFloat(row.querySelector('.charged-weight')?.value) || 0;
        const declaredValue = parseFloat(row.querySelector('.declared-value')?.value) || 0;
        totalChargedWeight += chargedWeight;
        totalDeclaredValue += declaredValue;
    });

    document.getElementById(`total_charged_weight_${index}`).value = totalChargedWeight.toFixed(2);
    document.getElementById(`total_declared_value_${index}`).value = totalDeclaredValue.toFixed(2);

    updateFreightAndTotalsExisting(index);
}

// Update freight and totals for existing LRs
function updateFreightAndTotalsExisting(index) {
    const freightType = document.querySelector(`input[name="lr[${index}][freightType]"]:checked`)?.value;
    const freightInput = document.getElementById(`freight_amount_${index}`);
    if (!freightInput) return;

    const row = freightInput.closest('tr');

    if (freightType === 'to_be_billed') {
        freightInput.value = 0;
        row.querySelectorAll('input').forEach(input => input.value = '');
        return;
    }

    const orderMethod = document.querySelector('input[name="order_method"]:checked')?.value;
    const rate = orderMethod === 'order' ? currentOrderAmount : (existingLrRates[index] || 0);
    const totalChargedWeight = parseFloat(document.getElementById(`total_charged_weight_${index}`).value) || 0;
    const freightAmount = totalChargedWeight * rate;

    freightInput.value = freightAmount.toFixed(2);

    const lrCharges = parseFloat(row.querySelector('.lr-charges')?.value) || 0;
    const hamali = parseFloat(row.querySelector('.hamali')?.value) || 0;
    const otherCharges = parseFloat(row.querySelector('.other-charges')?.value) || 0;
    const lessAdvance = parseFloat(row.querySelector('.less-advance')?.value) || 0;

    const subtotal = freightAmount + lrCharges + hamali + otherCharges;
    const gstPercent = 12;
    const gstAmount = subtotal * gstPercent / 100;
    const totalFreight = subtotal + gstAmount;
    const balance = totalFreight - lessAdvance;

    row.querySelector('.gst').value = gstAmount.toFixed(2);
    row.querySelector('.total-freight').value = totalFreight.toFixed(2);
    row.querySelector('.balance-freight').value = balance.toFixed(2);
}

// Toggle freight table for existing LRs
function toggleFreightTableExisting(index) {
    const freightType = document.querySelector(`input[name="lr[${index}][freightType]"]:checked`)?.value;
    const freightTable = document.getElementById(`freight_table_${index}`);
    if (freightTable) {
        freightTable.closest('.table-responsive').style.display = freightType === 'to_be_billed' ? 'none' : '';
    }
    updateFreightAndTotalsExisting(index);
}

// Toggle insurance input for existing LRs
function toggleInsuranceInputExisting(index) {
    const insuranceYes = document.getElementById(`insurance_yes_${index}`);
    const insuranceInput = document.getElementById(`insurance_input_${index}`);

    if (insuranceYes?.checked) {
        insuranceInput.classList.remove('d-none');
        insuranceInput.required = true;
    } else {
        insuranceInput.classList.add('d-none');
        insuranceInput.required = false;
        insuranceInput.value = '';
    }
}

// Add cargo row for existing LRs
function addCargoRowExisting(index) {
    if (!(index in existingCargoCounters)) existingCargoCounters[index] = 0;
    const tbody = document.getElementById(`cargo_table_body_${index}`);
    const cargoIndex = existingCargoCounters[index]++;

    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type="number" name="lr[${index}][cargo][${cargoIndex}][packages_no]" class="form-control" placeholder="0" required></td>
        <td>
            <select name="lr[${index}][cargo][${cargoIndex}][package_type]" class="form-select" required>
                <option value="Pallets">Pallets</option>
                <option value="Cartons">Cartons</option>
                <option value="Bags">Bags</option>
            </select>
        </td>
        <td><input type="text" name="lr[${index}][cargo][${cargoIndex}][package_description]" class="form-control" placeholder="Enter description" required></td>
        <td><input type="number" name="lr[${index}][cargo][${cargoIndex}][actual_weight]" class="form-control" placeholder="0" required></td>
        <td><input type="number" name="lr[${index}][cargo][${cargoIndex}][charged_weight]" class="form-control charged-weight" placeholder="0" required oninput="calculateTotalsExisting(${index})"></td>
        <td>
            <select name="lr[${index}][cargo][${cargoIndex}][unit]" class="form-select" required>
                <option value="">Select Unit</option>
                <option value="kg">Kg</option>
                <option value="ton">Ton</option>
            </select>
        </td>
        <td><input type="text" name="lr[${index}][cargo][${cargoIndex}][document_no]" class="form-control" placeholder="Doc No." required></td>
        <td><input type="text" name="lr[${index}][cargo][${cargoIndex}][document_name]" class="form-control" placeholder="Doc Name" required></td>
        <td><input type="date" name="lr[${index}][cargo][${cargoIndex}][document_date]" class="form-control" required></td>
        <td><input type="file" name="lr[${index}][cargo][${cargoIndex}][document_file]" class="form-control"></td>
        <td><input type="text" name="lr[${index}][cargo][${cargoIndex}][eway_bill]" class="form-control" placeholder="Eway Bill No." required></td>
        <td><input type="date" name="lr[${index}][cargo][${cargoIndex}][valid_upto]" class="form-control" required></td>
        <td><input type="number" name="lr[${index}][cargo][${cargoIndex}][declared_value]" class="form-control declared-value" placeholder="0" required oninput="calculateTotalsExisting(${index})"></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRowExisting(this, ${index})">🗑</button></td>
    `;
    tbody.appendChild(row);
    calculateTotalsExisting(index);
}

// Remove cargo row for existing LRs
function removeRowExisting(button, index) {
    const row = button.closest('tr');
    if (row) {
        row.remove();
        calculateTotalsExisting(index);
    }
}

// Handle order amount changes
function showOrderAmountAlert(value) {
    currentOrderAmount = parseFloat(value) || 0;
    currentContractAmount = '';
    if (document.querySelector('input[name="order_method"]:checked')?.value === 'order') {
        // Update existing LRs
        document.querySelectorAll('.lr-section').forEach(section => {
            const index = section.dataset.lrIndex;
            existingLrRates[index] = currentOrderAmount;
            const rateInput = document.getElementById(`rate_input_${index}`);
            if (rateInput) rateInput.value = currentOrderAmount.toFixed(2);
            updateFreightAndTotalsExisting(index);
        });
        // Update new LRs
        document.querySelectorAll('#lr_container .row.mt-4').forEach(section => {
            const index = section.querySelector('input[name^="lr["]')?.name.match(/lr\[(\d+)\]/)[1];
            newLrRates[index] = currentOrderAmount;
            const rateInput = document.getElementById(`rate_input_${index}`);
            if (rateInput) rateInput.value = currentOrderAmount.toFixed(2);
            updateFreightAndTotalsNew(index);
        });
    }
}
</script>

<!-- JavaScript for New LRs -->
<script>
// Global variables for new LRs
let lrIndex = {{ count($lrData) ?? 0 }};
let newCargoCounters = {};
let newLrRates = {};

// Add new LR row
function addLrRow() {
    const container = document.getElementById('lr_container');
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
                <select name="lr[${lrIndex}][consignor_id]" id="consignor_id_${lrIndex}" class="form-select" onchange="setConsignorDetailsNew(${lrIndex})" required>
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
            <div class="col-md-3">
                <h5>📦 Consignee (Receiver)</h5>
                <select name="lr[${lrIndex}][consignee_id]" id="consignee_id_${lrIndex}" class="form-select" onchange="setConsigneeDetailsNew(${lrIndex})" required>
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
                <input type="text" name="lr[${lrIndex}][consignee_unloading]" id="consignee_unloading_${lrIndex}" class="form-control" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">Consignee GST</label>
                <input type="text" name="lr[${lrIndex}][consignee_gst]" id="consignee_gst_${lrIndex}" class="form-control" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">🚚 Vehicle Number</label>
                <select name="lr[${lrIndex}][vehicle_no]" class="form-select" required>
                    <option value="">Select Vehicle NO.</option>
                    @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->vehicle_no }}">{{ $vehicle->vehicle_no }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">🚛 Vehicle Type</label>
                <select name="lr[${lrIndex}][vehicle_type]" id="vehicle_type_${lrIndex}" class="form-select" onchange="fetchRateForLRNew(${lrIndex})" required>
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
                    <option value="godown_delivery">Godown Delivery</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">📍 From (Origin)</label>
                <select name="lr[${lrIndex}][from_location]" id="from_location_${lrIndex}" class="form-select" onchange="fetchRateForLRNew(${lrIndex})" required>
                    <option value="">Select Origin</option>
                    @foreach ($destination as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->destination }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">📍 To (Destination)</label>
                <select name="lr[${lrIndex}][to_location]" id="to_location_${lrIndex}" class="form-select" onchange="fetchRateForLRNew(${lrIndex})" required>
                    <option value="">Select Destination</option>
                    @foreach ($destination as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->destination }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">💰 Order Rate</label>
            <input type="number" name="lr[${lrIndex}][order_rate]" class="form-control" id="rate_input_${lrIndex}" placeholder="Enter Amount" readonly>
        </div>
        <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
            <label class="form-label mb-0">🛡️ Insurance?</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="lr[${lrIndex}][insurance_status]" value="yes" id="insurance_yes_${lrIndex}" onchange="toggleInsuranceInputNew(${lrIndex})">
                <label class="form-check-label" for="insurance_yes_${lrIndex}">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="lr[${lrIndex}][insurance_status]" value="no" id="insurance_no_${lrIndex}" onchange="toggleInsuranceInputNew(${lrIndex})" checked>
                <label class="form-check-label" for="insurance_no_${lrIndex}">No</label>
            </div>
            <input type="text" class="form-control d-none" name="lr[${lrIndex}][insurance_description]" id="insurance_input_${lrIndex}" placeholder="Enter Insurance Number" style="max-width: 450px;">
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <h5 class="mb-3 pb-3">📦 Cargo Description</h5>
                <div class="mb-3 d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cargo_description_type_${lrIndex}" id="single_doc_${lrIndex}" value="single" checked required>
                        <label class="form-check-label" for="single_doc_${lrIndex}">Single Document</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cargo_description_type_${lrIndex}" id="multiple_doc_${lrIndex}" value="multiple" required>
                        <label class="form-check-label" for="multiple_doc_${lrIndex}">Multiple Documents</label>
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
                        <tbody id="cargo_table_body_${lrIndex}">
                            <tr>
                                <td><input type="number" class="form-control" name="lr[${lrIndex}][cargo][0][packages_no]" step="0.01" placeholder="0" required></td>
                                <td>
                                    <select class="form-select" name="lr[${lrIndex}][cargo][0][package_type]" required>
                                        <option value="Pallets">Pallets</option>
                                        <option value="Cartons">Cartons</option>
                                        <option value="Bags">Bags</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="lr[${lrIndex}][cargo][0][package_description]" placeholder="Enter description" required></td>
                                <td><input type="number" class="form-control" name="lr[${lrIndex}][cargo][0][actual_weight]" step="0.01" placeholder="0" required></td>
                                <td>
                                    <input type="number" class="form-control charged-weight" name="lr[${lrIndex}][cargo][0][charged_weight]" step="0.01" placeholder="0" required oninput="calculateTotalsNew(${lrIndex})">
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
                                <td><input type="file" class="form-control" name="lr[${lrIndex}][cargo][0][document_file]"></td>
                                <td><input type="text" class="form-control" name="lr[${lrIndex}][cargo][0][eway_bill]" placeholder="Eway Bill No." required></td>
                                <td><input type="date" class="form-control" name="lr[${lrIndex}][cargo][0][valid_upto]" required></td>
                                <td>
                                    <input type="number" class="form-control declared-value" name="lr[${lrIndex}][cargo][0][declared_value]" step="0.01" placeholder="0" oninput="calculateTotalsNew(${lrIndex})">
                                </td>
                                <td><button class="btn btn-danger btn-sm" onclick="removeRowNew(this, ${lrIndex})">🗑</button></td>
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
        <div class="row mt-4">
            <div class="col-12">
                <h5 class="pb-3">🚚 Freight Details</h5>
                <div class="mb-3 d-flex gap-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input freight-type" type="radio" name="lr[${lrIndex}][freightType]" id="freight_paid_${lrIndex}" value="paid" checked onchange="toggleFreightTableNew(${lrIndex})">
                        <label class="form-check-label" for="freight_paid_${lrIndex}">Paid</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input freight-type" type="radio" name="lr[${lrIndex}][freightType]" id="freight_to_pay_${lrIndex}" value="to_pay" onchange="toggleFreightTableNew(${lrIndex})">
                        <label class="form-check-label" for="freight_to_pay_${lrIndex}">To Pay</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input freight-type" type="radio" name="lr[${lrIndex}][freightType]" id="freight_to_be_billed_${lrIndex}" value="to_be_billed" onchange="toggleFreightTableNew(${lrIndex})">
                        <label class="form-check-label" for="freight_to_be_billed_${lrIndex}">To Be Billed</label>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center" id="freight_table_${lrIndex}">
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
                        <tbody id="freight_table_body_${lrIndex}">
                            <tr>
                                <td><input type="number" name="lr[${lrIndex}][freight_amount]" class="form-control freight-amount" id="freight_amount_${lrIndex}"  step="0.01" placeholder="Enter Freight Amount" readonly></td>
                                <td><input type="number" name="lr[${lrIndex}][lr_charges]" class="form-control lr-charges"  step="0.01" placeholder="Enter LR Charges" oninput="updateFreightAndTotalsNew(${lrIndex})"></td>
                                <td><input type="number" name="lr[${lrIndex}][hamali]" class="form-control hamali"  step="0.01" placeholder="Enter Hamali" oninput="updateFreightAndTotalsNew(${lrIndex})"></td>
                                <td><input type="number" name="lr[${lrIndex}][other_charges]" class="form-control other-charges"  step="0.01" placeholder="Enter Other Charges" oninput="updateFreightAndTotalsNew(${lrIndex})"></td>
                                <td><input type="number" name="lr[${lrIndex}][gst_amount]" class="form-control gst"  step="0.01" placeholder="Enter GST Amount" readonly></td>
                                <td><input type="number" name="lr[${lrIndex}][total_freight]" class="form-control total-freight"  step="0.01" placeholder="Enter Total Freight" readonly></td>
                                <td><input type="number" name="lr[${lrIndex}][less_advance]" class="form-control less-advance"  step="0.01" placeholder="Enter Less Advance" oninput="updateFreightAndTotalsNew(${lrIndex})"></td>
                                <td><input type="number" name="lr[${lrIndex}][balance_freight]" class="form-control balance-freight"  step="0.01" placeholder="Enter Balance Freight" readonly></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
               
                <input type="hidden" class="form-control" id="total_charged_weight_${lrIndex}" name="lr[${lrIndex}][total_charged_weight]" step="0.01" placeholder="Total Charged Weight" readonly>
                <label class="form-label"><strong>💰 Total Declared Value (Rs.)</strong></label>
                <input type="text" class="form-control" id="total_declared_value_${lrIndex}" name="lr[${lrIndex}][total_declared_value]" step="0.01" placeholder="Total Declared Value" readonly>
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

    // toggleFreightTableNew(lrIndex);
    // toggleInsuranceInputNew(lrIndex);
    // calculateTotalsNew(lrIndex);

    lrContainer.appendChild(lrSection);

// Attach event listeners to the new dropdowns
attachEventListenersForLR(index);

// If orderMethod is 'contract', fetch the rate immediately after adding the LR
const orderMethod = document.querySelector('input[name="order_method"]:checked')?.value;
if (orderMethod === 'contract') {
    fetchRateForLRNew(index);
} else if (orderMethod === 'order' && currentOrderAmount) {
    newLrRates[index] = parseFloat(currentOrderAmount) || 0;
    document.getElementById(`rate_input_${index}`).value = newLrRates[index].toFixed(2);
    updateFreightAndTotalsNew(index);
}
    lrIndex++;
}
function attachEventListenersForLR(index) {
    const vehicleTypeSelect = document.querySelector(`select[name="lr[${index}][vehicle_type]"]`);
    const fromLocationSelect = document.querySelector(`select[name="lr[${index}][from_location]"]`);
    const toLocationSelect = document.querySelector(`select[name="lr[${index}][to_location]"]`);

    if (vehicleTypeSelect) {
        vehicleTypeSelect.addEventListener('change', () => fetchRateForLRNew(index));
    }
    if (fromLocationSelect) {
        fromLocationSelect.addEventListener('change', () => fetchRateForLRNew(index));
    }
    if (toLocationSelect) {
        toLocationSelect.addEventListener('change', () => fetchRateForLRNew(index));
    }
}

// Remove LR row
function removeLrRow(button) {
    const section = button.closest('.row.mt-4');
    if (section) section.remove();
}

// Consignor details for new LRs
function setConsignorDetailsNew(index) {
    const select = document.getElementById(`consignor_id_${index}`);
    const gst = select.options[select.selectedIndex]?.dataset.gstConsignor || '';
    const address = select.options[select.selectedIndex]?.dataset.addressConsignor || '';
    document.getElementById(`consignor_gst_${index}`).value = gst;
    document.getElementById(`consignor_loading_${index}`).value = address;
}

// Consignee details for new LRs
function setConsigneeDetailsNew(index) {
    const select = document.getElementById(`consignee_id_${index}`);
    const gst = select.options[select.selectedIndex]?.dataset.gstConsignee || '';
    const address = select.options[select.selectedIndex]?.dataset.addressConsignee || '';
    document.getElementById(`consignee_gst_${index}`).value = gst;
    document.getElementById(`consignee_unloading_${index}`).value = address;
}

// Fetch rate for new LRs
function fetchRateForLRNew(index) {
    const orderMethod = document.querySelector('input[name="order_method"]:checked')?.value;

    const vehicle_type = document.querySelector(`select[name="lr[${index}][vehicle_type]"]`)?.value || '';
    const from_location = document.querySelector(`select[name="lr[${index}][from_location]"]`)?.value || '';
    const to_location = document.querySelector(`select[name="lr[${index}][to_location]"]`)?.value || '';
    const customer_id = document.getElementById('customer_id')?.value || '';

    const rateInput = document.getElementById(`rate_input_${index}`);

    // Debugging: Log the values being sent in the AJAX request
    console.log(`Fetching rate for LR ${index}:`, {
        orderMethod,
        vehicle_type,
        from_location,
        to_location,
        customer_id
    });

    // If orderMethod is 'order', use currentOrderAmount and skip AJAX
    if (orderMethod === 'order' && currentOrderAmount) {
        newLrRates[index] = parseFloat(currentOrderAmount) || 0;
        rateInput.value = newLrRates[index].toFixed(2);
        updateFreightAndTotalsNew(index);
        return;
    }


    if (!vehicle_type || !from_location || !to_location || !customer_id) {
        console.log(`Missing required fields for LR ${index}, skipping AJAX.`);
        updateFreightAndTotalsNew(index);
        return;
    }

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
        console.log(`Rate fetched for LR ${index}:`, data.rate);
        newLrRates[index] = parseFloat(data.rate) || 0;
        rateInput.value = newLrRates[index].toFixed(2);
        updateFreightAndTotalsNew(index);
    })
    .catch(err => {
        console.error(`Error fetching rate for LR ${index}:`, err);
        updateFreightAndTotalsNew(index);
    });
}
// Calculate totals for new LRs
function calculateTotalsNew(index) {
    let totalChargedWeight = 0;
    let totalDeclaredValue = 0;

    document.querySelectorAll(`#cargo_table_body_${index} tr`).forEach(row => {
        const chargedWeight = parseFloat(row.querySelector('.charged-weight')?.value) || 0;
        const declaredValue = parseFloat(row.querySelector('.declared-value')?.value) || 0;
        totalChargedWeight += chargedWeight;
        totalDeclaredValue += declaredValue;
    });

    document.getElementById(`total_charged_weight_${index}`).value = totalChargedWeight.toFixed(2);
    document.getElementById(`total_declared_value_${index}`).value = totalDeclaredValue.toFixed(2);

    updateFreightAndTotalsNew(index);
}

// Update freight and totals for new LRs
function updateFreightAndTotalsNew(index) {
    const freightType = document.querySelector(`input[name="lr[${index}][freightType]"]:checked`)?.value;
    const freightInput = document.getElementById(`freight_amount_${lrIndex}`);
    if (!freightInput) return;

    const row = freightInput.closest('tr');

    if (freightType === 'to_be_billed') {
        freightInput.value = 0;
        row.querySelectorAll('input').forEach(input => input.value = '');
        return;
    }

    const orderMethod = document.querySelector('input[name="order_method"]:checked')?.value;
    const rate = orderMethod === 'order' ? currentOrderAmount : (newLrRates[index] || 0);
}

</script>
<script>
    function updateFreightAndTotalsNew(index) {
    const freightType = document.querySelector(`input[name="lr[${index}][freightType]"]:checked`)?.value;
    const freightInput = document.getElementById(`freight_amount_${index}`);
    const totalChargedWeightInput = document.getElementById(`total_charged_weight_${index}`);
    const rateInput = document.getElementById(`rate_input_${index}`);
    
    if (!freightInput || !totalChargedWeightInput || !rateInput) return;

    const row = freightInput.closest('tr');
    const lrChargesInput = row.querySelector(`input[name="lr[${index}][lr_charges]"]`);
    const hamaliInput = row.querySelector(`input[name="lr[${index}][hamali]"]`);
    const otherChargesInput = row.querySelector(`input[name="lr[${index}][other_charges]"]`);
    const gstInput = row.querySelector(`input[name="lr[${index}][gst_amount]"]`);
    const totalFreightInput = row.querySelector(`input[name="lr[${index}][total_freight]"]`);
    const lessAdvanceInput = row.querySelector(`input[name="lr[${index}][less_advance]"]`);
    const balanceFreightInput = row.querySelector(`input[name="lr[${index}][balance_freight]"]`);

    // Handle 'to_be_billed' case
    if (freightType === 'to_be_billed') {
        freightInput.value = 0;
        row.querySelectorAll('input').forEach(input => {
            if (!input.readOnly) input.value = '';
            else input.value = 0;
        });
        return;
    }

    // Get values
    const totalChargedWeight = parseFloat(totalChargedWeightInput.value) || 0;
    const orderRate = parseFloat(rateInput.value) || 0;
    const lrCharges = parseFloat(lrChargesInput.value) || 0;
    const hamali = parseFloat(hamaliInput.value) || 0;
    const otherCharges = parseFloat(otherChargesInput.value) || 0;
    const lessAdvance = parseFloat(lessAdvanceInput.value) || 0;

    // Calculate freight amount (total charged weight * rate)
    const freightAmount = totalChargedWeight * orderRate;
    freightInput.value = freightAmount.toFixed(2);

    // Calculate GST (assuming 5% rate, adjust as needed)
    const gstRate = 0.05; // 5% GST
    const taxableAmount = freightAmount + lrCharges + hamali + otherCharges;
    const gstAmount = taxableAmount * gstRate;
    gstInput.value = gstAmount.toFixed(2);

    // Calculate total freight
    const totalFreight = taxableAmount + gstAmount;
    totalFreightInput.value = totalFreight.toFixed(2);

    // Calculate balance freight
    const balanceFreight = totalFreight - lessAdvance;
    balanceFreightInput.value = balanceFreight.toFixed(2);
}
    </script>
    <script>
          // Function to remove a row
   function removeRow(lrIndex, rowIndex) {
   document.getElementById(`cargoRow_${lrIndex}_${rowIndex}`).remove();
   }
   
        // Function to generate and add a new cargo row
   function addCargoRowNew(lrIndex) {
   const rowCount = document.querySelectorAll(`#cargo_table_body_${lrIndex} tr`).length;
   const newRowId = `cargoRow_${lrIndex}_${rowCount}`;
   const newRow = `
   <tr id="${newRowId}">
   <td><input type="number" class="form-control" name="lr[${lrIndex}][cargo][${rowCount}][packages_no]" step="0.01" placeholder="0" required></td>
   <td>
   <select class="form-select" name="lr[${lrIndex}][cargo][${rowCount}][package_type]" required>
   <option>Pallets</option>
   <option>Cartons</option>
   <option>Bags</option>
   </select>
   </td>
   <td><input type="text" class="form-control" name="lr[${lrIndex}][cargo][${rowCount}][package_description]" placeholder="Enter description" required></td>
   <td><input type="number" class="form-control" name="lr[${lrIndex}][cargo][${rowCount}][actual_weight]" step="0.01" placeholder="0" required></td>
  
     <td>
        <input
            type="number"
            class="form-control charged-weight"
            name="lr[${lrIndex}][cargo][${rowCount}][charged_weight]"
            placeholder="0"
            required
            oninput="calculateTotalsNew(${lrIndex})">
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
        placeholder="0" step="0.01"
        oninput="calculateTotalsNew(${lrIndex})">
</td>

   <td><button class="btn btn-danger btn-sm" onclick="removeRow(${lrIndex}, ${rowCount})">🗑</button></td>
   </tr>
   `;
   document.querySelector(`#cargo_table_body_${lrIndex}`).insertAdjacentHTML('beforeend', newRow);
   }
   
   </script>
   <script>
function setConsigneeDetailsNew(lrIndex) {
    const select = document.getElementById(`consignee_id_${lrIndex}`);
    const gst = select.options[select.selectedIndex]?.dataset.gstConsignee || '';
    const address = select.options[select.selectedIndex]?.dataset.addressConsignee || '';
    document.getElementById(`consignee_gst_${lrIndex}`).value = gst;
    document.getElementById(`consignee_unloading_${lrIndex}`).value = address;
}
function setConsignorDetailsNew(lrIndex) {
    const select = document.getElementById(`consignor_id_${lrIndex}`);
    const gst = select.options[select.selectedIndex]?.dataset.gstConsignor || '';
    const address = select.options[select.selectedIndex]?.dataset.addressConsignor || '';
    document.getElementById(`consignor_gst_${lrIndex}`).value = gst;
    document.getElementById(`consignor_loading_${lrIndex}`).value = address;
}

   </script>
@endsection