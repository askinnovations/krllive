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
   <a href="{{ route('admin.orders.create') }}" class="btn" id="backToListBtn"
      style="background-color: #ca2639; color: white; border: none;">
   ⬅ Back to Listing
   </a>
</div>
<form method="POST" action="{{ route('admin.orders.store') }}" enctype="multipart/form-data">
   @csrf
   <div class="card">
      <div class="card-header">
         <h4>Order Details</h4>
      </div>
      <div class="card-body">
         <div class="row">
            <!-- Description -->
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📝 Consignment Details</label>
                  <textarea name="description" class="form-control" rows="2" placeholder="Enter order description" required></textarea>
                  @error('description')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
               </div>
            </div>
            <!-- Order Date -->
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📅 Consignment Pickup Date</label>
                  <input type="date" name="order_date" class="form-control" required>
               </div>
            </div>
            <!-- Select2 CSS -->
            <!-- Status -->
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📊 Status</label>
                  <select name="status" class="form-select my-select" required >
                     <option value="">Select Status</option>
                     <option value="Pending">Pending</option>
                     <option value="Processing">Processing</option>
                     <option value="Completed">Completed</option>
                     <option value="Cancelled">Cancelled</option>
                  </select>
               </div>
            </div>
            <!-- CUSTOMER NAME DROPDOWN -->
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
                                      data-address="{{ $address['billing_address'] ?? '' }}"> 
                                      {{ $user->name }} - {{ $address['city'] ?? '' }}
                                  </option>
                              @endforeach
                          @endif
                      @endforeach
                  </select>
              </div>
          </div>
          
          <!-- GST NUMBER (Auto-filled) -->
          <div class="col-md-3">
              <div class="mb-3">
                  <label class="form-label">🧾 GST NUMBER</label>
                  <input type="text" name="gst_number" id="gst_number" class="form-control" readonly required>
              </div>
          </div>
          
          <!-- CUSTOMER ADDRESS (Auto-filled) -->
          <div class="col-md-3">
              <div class="mb-3">
                  <label class="form-label">📍 CUSTOMER ADDRESS</label>
                  <input type="text" name="customer_address" id="customer_address" class="form-control" readonly required>
              </div>
          </div>
          
            <!-- ORDER TYPE -->
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📊 Order Type</label>
                  <select name="order_type" class="form-select  my-select " required>
                     <option value="">Select Order</option>
                     <option value="import"> Import</option>
                     <option value="import-restoff">Import Restoff</option>
                     <option value="export">Export</option>
                     <option value="export-restoff">Export Restoff</option>
                     <option value="domestic">Domestic</option>
                  </select>
               </div>
            </div>
            {{-- oder contract --}}
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📑 ORDER METHOD</label><br>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="order_method" id="byOrder" value="order" onclick="toggleOrderMethod()">
                     <label class="form-check-label" for="byOrder">By Order</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="order_method" id="byContract" value="contract" onclick="toggleOrderMethod()">
                     <label class="form-check-label" for="byContract">By Contract</label>
                  </div>
               </div>
               <!-- Input field for By Order -->
               <div class="mb-3 d-none" id="orderAmountDiv">
                  <label class="form-label">💰 ORDER AMOUNT</label>
                  <input type="number" name="byOrder" class="form-control" placeholder="Enter Amount">
               </div>
               <!-- Input field for By Contract -->
               <div class="mb-3 d-none" id="contractNumberDiv">
                  <label class="form-label">📄 CONTRACT NUMBER</label>
                  <input type="text" name="byContract" id="rate_input" class="form-control" placeholder="Enter Contract " readonly>
               </div>
            </div>
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📍 PICKUP ADDRESS</label>
                  <input type="text" name="pickup_addresss" id="pickup_addresss" class="form-control"  placeholder="Pickup Addresss" required>
               </div>
            </div>
            <!-- DEliver adddress   -->
            <div class="col-md-3">
               <div class="mb-3">
                  <label class="form-label">📍DELEIEIVER ADDRESS</label>
                  <input type="text" name="deleiver_addresss" id="deleiver_addresss" class="form-control"  placeholder="Deleiver Addresss" required>
               </div>
            </div>
         </div>
         <!-- Button to Add LR - Consignment -->
         <div class="row">
            <div class="col-12 text-center">
               <button type="button" class="btn" id="addLRBtn" style="background-color: #ca2639; color: white; border: none;">
               <i class="fas fa-plus"></i> Add LR - Consignment
               </button>
            </div>
         </div>
         <!-- LR Consignment Section (Initially Hidden) -->
         <div class="mt-4" id="lrSection" style="display: none;">
            <h4 style="margin-bottom: 2%;">🚚 Add LR - Consignment Details</h4>
            <div class="accordion" id="lrAccordion"></div>
         </div>
         <!-- Submit Button -->
         <div class="row mt-4 mb-4">
            <div class="col-12 text-center">
               <button type="submit" class="btn btn-primary">
               <i class="fas fa-save"></i> Save Order & LR Details
               </button>
            </div>
         </div>
      </div>
   </div>
</form>
<!-- JavaScript to Add & Remove LR Consignments -->
<script>
   var vehicles = @json($vehicles);
   
   function generateVehicle_typeOptions() {
       let options = '<option value="">Select Vehicle</option>';
       vehicles.forEach(function(vehicle) {
           options += `<option value="${vehicle.id}">${vehicle.vehicle_no}</option>`;
       });
       return options;
   }
</script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
     let lrCounter = 0;
     const addLRBtn = document.getElementById("addLRBtn");
     const lrAccordion = document.getElementById("lrAccordion");
     const lrSection = document.getElementById("lrSection");
   
     function createLRAccordionItem(counter) {
       const newAccordionItem = document.createElement("div");
       newAccordionItem.classList.add("accordion-item");
       newAccordionItem.setAttribute("id", `lrItem${counter}`);
       newAccordionItem.innerHTML = `
         <h2 class="accordion-header" id="heading${counter}">
           <button class="accordion-button btn-light" type="button" data-bs-toggle="collapse"
             data-bs-target="#collapse${counter}" aria-expanded="true" aria-controls="collapse${counter}">
             LR - Consignment #${counter}
           </button>
         </h2>
         <div id="collapse${counter}" class="accordion-collapse collapse show" aria-labelledby="heading${counter}"
             data-bs-parent="#lrAccordion">
           <div class="accordion-body">
             <div class="card-body">
               <div class="row">
                 <!-- Consignor Details -->
                 <div class="col-md-6">
                 
                   
   
                   <h5>📦 Consignor (Sender)</h5>
               <select name="lr[${counter}][consignor_id]" id="consignor_id_${counter}" class="form-select" onchange="setConsignorDetails(${counter})" required>
    <option value="">Select Consignor Name</option>
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
                    data-gst="{{ $address['gstin'] ?? '' }}"
                    data-address="{{ $formattedAddress }}"
                >
                    {{ $user->name }} - {{ $address['city'] ?? '' }}
                </option>
            @endforeach
        @endif
    @endforeach
</select>

<div class="mb-3">
    <label class="form-label">Consignor Loading Address</label>
    <textarea name="lr[${counter}][consignor_loading]" id="consignor_loading_${counter}" class="form-control" rows="2" placeholder="Enter loading address" required></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Consignor GST</label>
    <input type="text" name="lr[${counter}][consignor_gst]" id="consignor_gst_${counter}" class="form-control" placeholder="Enter GST number" required>
</div>

                 </div>
                 
                 <!-- Consignee Details -->
                 <div class="col-md-6">
                 <div class="mb-3">
                     <label class="form-label">Lr date</label>
                     <input type="date" name="lr[${counter}][lr_date]" class="form-control" placeholder="Enter lr date" required>
                   </div>
                   <h5>📦 Consignee (Receiver)</h5>
                <select name="lr[${counter}][consignee_id]" id="consignee_id_${counter}" class="form-select" onchange="setConsigneeDetails(${counter})" required>
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
                >
                    {{ $user->name }} - {{ $address['city'] ?? '' }}
                </option>
            @endforeach
        @endif
    @endforeach
</select>

   
   <div class="mb-3">
   <label class="form-label">Consignee Unloading Address</label>
   <textarea name="lr[${counter}][consignee_unloading]" id="consignee_unloading_${counter}" class="form-control" rows="2" placeholder="Enter unloading address" required></textarea>
   </div>
   
   <div class="mb-3">
   <label class="form-label">Consignee GST</label>
   <input type="text" name="lr[${counter}][consignee_gst]" id="consignee_gst_${counter}" class="form-control" placeholder="Enter GST number" required>
   </div>
   
   
                 </div>
               </div>
               
               <div class="row">
                 <!-- LR Date -->
                 <div class="col-md-4">
                   <div class="mb-3">
                     <label class="form-label">🚚 Vehicle Number</label>
                    <select name="lr[${counter}][vehicle_no]" class="form-select search-select" required>
                                       ${generateVehicle_typeOptions()}
                      </select>
                   </div>
                 </div>
                 
                 
                 <!-- Vehicle Type (Vehicle ID from vehicles table) -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">🚛 Vehicle Type</label>
                        <select name="lr[${counter}][vehicle_type]" id="vehicle_type"  class="form-select " required>
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
                       <input class="form-check-input" type="radio" name="lr[${counter}][vehicle_ownership]" value="Own" checked required>
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
                     <select name="lr[${counter}][delivery_mode]" class="form-select " required>
                        <option value="">Select Mode</option>
                        <option value="door_delivery">Door Delivery</option>
                        <option value="godwon_deliver">Godown Delivery</option>
                      </select>
                   </div>
                 </div>
                 
                 <!-- From Location -->
                 <div class="col-md-4">
                   <div class="mb-3">
                     <label class="form-label">📍 From (Origin)</label>
                     
                     <select name="lr[${counter}][from_location]" class="form-select"  id="from_location" required>
                        <option value="">Select Destination</option>
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
                     <select name="lr[${counter}][to_location]" class="form-select" id="to_location" required>
                       <option value="">Select Destination</option>
                      @foreach ($destination as $loc)
                            <option value="{{ $loc->id }}">{{ $loc->destination }}</option>
                        @endforeach
                     </select>
                   </div>
                 </div>
               </div>
             <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
    <label class="form-label mb-0">🛡️ Insurance?</label>
   
    <div class="form-check form-check-inline">
        <input class="form-check-input"
               type="radio"
               name="lr[${counter}][insurance_status]"
               value="yes"
               id="insuranceYes${counter}"
               onchange="toggleInsuranceInput(${counter})">
        <label class="form-check-label" for="insuranceYes${counter}">Yes</label>
    </div>
   
    <div class="form-check form-check-inline">
        <input class="form-check-input"
               type="radio"
               name="lr[${counter}][insurance_status]"
               value="no"
               id="insuranceNo${counter}"
               onchange="toggleInsuranceInput(${counter})"
               checked>
        <label class="form-check-label" for="insuranceNo${counter}">No</label>
    </div>
   
    <!-- Insurance input field -->
    <input type="text"
           class="form-control d-none"
           name="lr[${counter}][insurance_description]"
           id="insuranceInput${counter}"
           placeholder="Enter Insurance Number"
           style="max-width: 450px;">
     </div>
   
                <!-- Cargo Description Section -->
                <div class="row mt-4">
                     <div class="col-12">
                         <h5 class="mb-3 pb-3">📦 Cargo Description</h5>
   
                         <!-- Documentation Selection -->
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
                                     <thead>
                                         <tr>
                                             <th>No. of Packages</th>
                                             <th>Packaging Type</th>
                                             <th>Description</th>
                                             <th>Actual Weight (kg)</th>
                                             <th>Charged Weight (kg)</th>
                                            <th >  &nbsp;Unit&nbsp;&nbsp;    </th>
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
                                     <tbody id="cargoTableBody-${counter}" data-lr-index="${counter}">
                                          <tr>
                                              <td><input type="number" class="form-control" name="lr[${counter}][cargo][0][packages_no]" placeholder="0" required></td>
                                              <td>
                                                  <select class="form-select" name="lr[${counter}][cargo][0][package_type]" required>
                                                      <option>Pallets</option>
                                                      <option>Cartons</option>
                                                      <option>Bags</option>
                                                  </select>
                                              </td>
                                              <td><input type="text" class="form-control" name="lr[${counter}][cargo][0][package_description]" placeholder="Enter description" required></td>
                                              <td><input type="number" class="form-control" name="lr[${counter}][cargo][0][actual_weight]" placeholder="0" required></td>
                                              <td><input type="number" class="form-control" name="lr[${counter}][cargo][0][charged_weight]" placeholder="0" required></td>
                                             <td>
                                                <select class="form-select" name="lr[${counter}][cargo][0][unit]" required>
                                                  <option value="">Select Unit</option>
                                                  <option value="kg">Kg</option>
                                                  <option value="ton">Ton</option>
                                                </select>
                                              </td>
                                              <td><input type="text" class="form-control" name="lr[${counter}][cargo][0][document_no]" placeholder="Doc No." required></td>
                                              <td><input type="text" class="form-control" name="lr[${counter}][cargo][0][document_name]" placeholder="Doc Name" required></td>
                                              <td><input type="date" class="form-control" name="lr[${counter}][cargo][0][document_date]" required></td>
                                              <td><input type="file" class="form-control" name="lr[${counter}][cargo][0][document_file]" required></td>
                                              <td><input type="text" class="form-control" name="lr[${counter}][cargo][0][eway_bill]" placeholder="Eway Bill No." required></td>
                                              <td><input type="date" class="form-control" name="lr[${counter}][cargo][0][valid_upto]" required></td>
                                              <td>
                                                  <input type="number" name="lr[${counter}][cargo][0][declared_value]" class="form-control declared-value" placeholder="0" oninput="calculateTotalDeclaredValue(${counter})">
                                               </td>
   
                                              <td>
                                                
                                                  <button class="btn btn-danger btn-sm" onclick="removeRow(this)">🗑</button>
                                              </td>
                                          </tr>
                                      </tbody>
   
                                 </table>
                             </div>
                         <!-- Add Row Button -->
                       <div class="text-end mt-2">
                             <button type="button" class="btn btn-sm" style="background: #ca2639; color: white;"
                     onclick="addRow(${counter})">
                     <span style="filter: invert(1);">➕</span> Add Row</button>
                      </div>
                    </div>
                </div>
   
    <!-- Freight Details Section -->
               <div class="row mt-4">
                 <div class="col-12">
                 
               <h5 class="pb-3">🚚 Freight Details</h5>
              <div class="mb-3 d-flex gap-3">
                <div class="form-check form-check-inline">
                  <input class="form-check-input freight-type" type="radio" name="lr[${counter}][freightType]" id="freightPaid-${counter}" value="paid" checked onchange="toggleFreightTable(${counter})">
                  <label class="form-check-label" for="freightPaid-${counter}">Paid</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input freight-type" type="radio" name="lr[${counter}][freightType]" id="freightToPay-${counter}" value="to_pay" onchange="toggleFreightTable(${counter})">
                  <label class="form-check-label" for="freightToPay-${counter}">To Pay</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input freight-type" type="radio" name="lr[${counter}][freightType]" id="freightToBeBilled-${counter}" value="to_be_billed" onchange="toggleFreightTable(${counter})">
                  <label class="form-check-label" for="freightToBeBilled-${counter}">To Be Billed</label>
                </div>
              </div>
                  
   <div class="table-responsive">
   <table class="table table-bordered align-middle text-center freight-table" id="freight-table-${counter}">
    <thead>
      <tr>
        <th>Freight</th>
        <th>LR Charges </th>
        <th>Hamali </th>
        <th>Other Charges </th>
        <th>GST (%)</th>
        <th>Total Freight</th>
        <th>Less Advance</th>
        <th>Balance Freight</th>
      </tr>
    </thead>
    <tbody id="freightBody-${counter}">
      <tr>
        <td>
          <input type="number" name="lr[${counter}][freight_amount]" class="form-control freight-amount" placeholder="Enter Freight Amount" required>
        </td>
        <td>
          <input type="number" name="lr[${counter}][lr_charges]" class="form-control lr-charges" placeholder="Enter LR " required>
        </td>
        <td>
          <input type="number" name="lr[${counter}][hamali]" class="form-control hamali" placeholder="Enter Hamali " required>
        </td>
        <td>
          <input type="number" name="lr[${counter}][other_charges]" class="form-control other-charges" placeholder="Enter Other " required>
        </td>
        <td>
          <input type="number" name="lr[${counter}][gst_amount]" class="form-control gst" placeholder="Enter GST %" required>
        </td>
        <td>
          <input type="number" name="lr[${counter}][total_freight]" class="form-control total-freight" placeholder="Total Freight" readonly>
        </td>
        <td>
          <input type="number" name="lr[${counter}][less_advance]" class="form-control less-advance" placeholder="Less Advance Amount" required>
        </td>
        <td>
          <input type="number" name="lr[${counter}][balance_freight]" class="form-control balance-freight" placeholder="Balance Freight" readonly>
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
                <label class="form-label fw-bold">💰 Total Declared Value (Rs.)</label>
          <input type="number" class="form-control"  id="totalDeclaredValue-${counter}" name="lr[${counter}][total_declared_value]" placeholder="0" ...>
   
            </div>
          </div>
        </div>
        
        <!-- Remove / Add More LR Buttons -->
        <div class="d-flex justify-content-end gap-2 mt-3">
          <button type="button" class="btn btn-outline-warning btn-sm removeLRBtn" data-id="lrItem${counter}">
            <i class="fas fa-trash-alt"></i> Remove
          </button>
          <button type="button" class="btn btn-sm addMoreLRBtn" data-id="lrItem${counter}" style="background-color: #ca2639; color: #fff;">
            <i class="fas fa-plus-circle"></i> Add More LR - Consignment
          </button>
        </div>
      </div>
    </div>
   </div>
   `;
       return newAccordionItem;
     }
   
     function addNewLR() {
       lrCounter++;
       lrSection.style.display = "block"; // Show LR Section
       const newAccordionItem = createLRAccordionItem(lrCounter);
       lrAccordion.appendChild(newAccordionItem);
   
      
       newAccordionItem.querySelector(".removeLRBtn").addEventListener("click", function () {
         removeLR(this.getAttribute("data-id"));
       });
       newAccordionItem.querySelector(".addMoreLRBtn").addEventListener("click", addNewLR);
       $(newAccordionItem).find('.search-select').select2({
        allowClear: true,
        width: '100%',
        minimumInputLength: 1
    });


     }
   

     function removeLR(removeId) {
       const element = document.getElementById(removeId);
       if (element) {
         element.remove();
       }
       // If no LR items left, hide the LR section
       if (lrAccordion.children.length === 0) {
         lrSection.style.display = "none";
       }
     }
    
    
   
     addLRBtn.addEventListener("click", addNewLR);
     bindDeclaredValueEvents(lrIndex);
     calculateTotalDeclaredValue(lrIndex);
     handleFreightType(counter);
   });
  
</script>
{{-- oder method --}}

{{-- <script>
 document.getElementById('customer_id').addEventListener('change', function(e) {
    const customer_id = e.target.value;
    const customer_text = e.target.options[e.target.selectedIndex].text;

    alert(`Customer ID: ${customer_id}\nCustomer: ${customer_text}`);
});

</script> --}}

 
  <script>
  // Event listener for customer selection
  document.getElementById('customer_id').addEventListener('change', function(e) {
      const customer_id = e.target.value;
      const customer_text = e.target.options[e.target.selectedIndex].text;

      // Display the selected customer details in alert
      alert(`Customer ID: ${customer_id}\nCustomer: ${customer_text}`);
  });

  // Event listener for the other selects (vehicle_type, from_location, to_location)
  document.addEventListener('change', function(e) {
      if (
          e.target.matches('select[name^="lr"][name$="[vehicle_type]"], select[name^="lr"][name$="[to_location]"], select[name^="lr"][name$="[from_location]"]')
      ) {
          // Get the selected values for vehicle_type, from_location, to_location
          const vehicle_type = document.querySelector('select[name$="[vehicle_type]"]').value;
          const from_location = document.querySelector('select[name$="[from_location]"]').value;
          const to_location = document.querySelector('select[name$="[to_location]"]').value;
          const customer_id = document.getElementById('customer_id').value;

          // Combine all values to show in alert
          const alertMessage = `Customer ID: ${customer_id}\nCustomer: ${document.getElementById('customer_id').options[document.getElementById('customer_id').selectedIndex].text}\nVehicle Type: ${vehicle_type}\nFrom Location: ${from_location}\nTo Location: ${to_location}`;
          alert(alertMessage);

          // Send data to server via AJAX (fetch)
          fetch('/admin/get-rate', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: JSON.stringify({
                  customer_id: customer_id,  // Add customer_id here
                  vehicle_type: vehicle_type,
                  from_location: from_location,
                  to_location: to_location
              })
          })
          .then(res => res.json())
          .then(data => {
              // If rate is available, populate it into the input field
              if (data.rate) {
                  document.getElementById('rate_input').value = data.rate; // Use the ID of the input field
              } else {
                  document.getElementById('rate_input').value = ''; // Clear the field if no rate found
                  alert('No rate found for this selection.'); // Show message if rate is not found
              }
          })
          .catch(err => {
              // If error occurs, show it in alert
              alert('Error: ' + err.message);
          });
      }
  });


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
   function addRow(lrIndex) {
     const tableBody = document.getElementById(`cargoTableBody-${lrIndex}`);
     const rowCount = tableBody.rows.length;
     const newRow = tableBody.rows[0].cloneNode(true);
   
     // Clear and update name/index of inputs
     [...newRow.querySelectorAll('input, select')].forEach((input) => {
       if (input.name) {
         // Update name attribute with new index
         input.name = input.name.replace(/lr\[\d+]\[cargo]\[\d+]/, `lr[${lrIndex}][cargo][${rowCount}]`);
         input.value = '';
   
         // Attach event for live total
         if (input.name.includes('declared_value')) {
           input.classList.add('declared-value');
           input.setAttribute('oninput', `calculateTotalDeclaredValue(${lrIndex})`);
         }
       }
     });
   
     tableBody.appendChild(newRow);
     calculateTotalDeclaredValue(lrIndex);
   }
   
   function removeRow(button) {
     const row = button.closest('tr');
     const tbody = row.closest('tbody');
     const lrIndex = tbody.dataset.lrIndex;
   
     if (tbody.rows.length > 1) {
       row.remove();
       calculateTotalDeclaredValue(lrIndex);
     }
   }
   
   function calculateTotalDeclaredValue(lrIndex) {
     let total = 0;
     const tableBody = document.getElementById(`cargoTableBody-${lrIndex}`);
     const inputs = tableBody.querySelectorAll(`input[name^="lr[${lrIndex}][cargo]"][name$="[declared_value]"]`);
   
     inputs.forEach(input => {
       total += parseFloat(input.value) || 0;
     });
   
     document.getElementById(`totalDeclaredValue-${lrIndex}`).value = total;
   }
   
   // Auto setup on page load for declared value rows
   document.addEventListener('DOMContentLoaded', function () {
     document.querySelectorAll('[id^="cargoTableBody-"]').forEach(tbody => {
       const lrIndex = tbody.dataset.lrIndex;
       const inputs = tbody.querySelectorAll('input[name$="[declared_value]"]');
   
       inputs.forEach(input => {
         input.classList.add('declared-value');
         input.setAttribute('oninput', `calculateTotalDeclaredValue(${lrIndex})`);
       });
   
       calculateTotalDeclaredValue(lrIndex);
     });
   });
</script>
<script>
  function setCustomerDetails() {
      const selected = document.getElementById('customer_id');
      const gst = selected.options[selected.selectedIndex].getAttribute('data-gst');
      const address = selected.options[selected.selectedIndex].getAttribute('data-address');

      document.getElementById('gst_number').value = gst || '';  // Set GST number
      document.getElementById('customer_address').value = address || '';  // Set customer address
  }
</script>
<script>
  function setConsignorDetails(counter) {
      const select = document.getElementById(`consignor_id_${counter}`);
      const selectedOption = select.options[select.selectedIndex];

      const gst = selectedOption.getAttribute('data-gst') || '';
      const address = selectedOption.getAttribute('data-address') || '';

      document.getElementById(`consignor_gst_${counter}`).value = gst;
      document.getElementById(`consignor_loading_${counter}`).value = address;
  }
</script>
<script>
  function setConsigneeDetails(counter) {
      const selected = document.getElementById(`consignee_id_${counter}`);
      const gst = selected.options[selected.selectedIndex].getAttribute('data-gst-consignee');
      const address = selected.options[selected.selectedIndex].getAttribute('data-address-consignee');

      document.getElementById(`consignee_gst_${counter}`).value = gst || '';
      document.getElementById(`consignee_unloading_${counter}`).value = address || '';
  }
</script>

<script>
   function toggleOrderMethod() {
       const orderRadio = document.getElementById('byOrder');
       const contractRadio = document.getElementById('byContract');
       const orderAmountDiv = document.getElementById('orderAmountDiv');
       const contractNumberDiv = document.getElementById('contractNumberDiv');
   
       if (orderRadio && orderRadio.checked) {
           orderAmountDiv.classList.remove('d-none');
           orderAmountDiv.querySelector('input').setAttribute('required', 'required');
   
           contractNumberDiv.classList.add('d-none');
           contractNumberDiv.querySelector('input').removeAttribute('required');
       } else if (contractRadio && contractRadio.checked) {
           contractNumberDiv.classList.remove('d-none');
           contractNumberDiv.querySelector('input').setAttribute('required', 'required');
   
           orderAmountDiv.classList.add('d-none');
           orderAmountDiv.querySelector('input').removeAttribute('required');
       }
   }
   
   // Call once on page load in case preselected value exists
   document.addEventListener('DOMContentLoaded', toggleOrderMethod);
</script>
<script>
   // This will be called when a radio button is clicked
   function toggleFreightTable(counter) {
       const tbody = document.getElementById(`freightBody-${counter}`);
       const freightPaidRadio = document.getElementById(`freightPaid-${counter}`);
       const freightToPayRadio = document.getElementById(`freightToPay-${counter}`);
       const freightToBeBilledRadio = document.getElementById(`freightToBeBilled-${counter}`);
   
       // Debugging: Check which radio is selected
       console.log('Selected Value:', freightPaidRadio.checked, freightToPayRadio.checked, freightToBeBilledRadio.checked);
   
       // Toggle table visibility based on the selected freight type
       if (freightToBeBilledRadio.checked) {
           tbody.style.display = 'none';  // Hide table body when 'To Be Billed' is selected
           const inputs = tbody.querySelectorAll('input');
           inputs.forEach(input => input.removeAttribute('required'));  // Remove required attribute
       } else {
           tbody.style.display = 'table-row-group'; // Show table body for other types
           const inputs = tbody.querySelectorAll('input');
           inputs.forEach(input => input.setAttribute('required', 'required'));  // Set required attribute
       }
   }
</script>
<script>
   $(document).ready(function () {
    $('input[name="order_method"]').on('change', function () {
        if ($(this).val() === 'order') {
            $('#orderAmountDiv').show();
            $('#contractNumberDiv').hide();
        } else if ($(this).val() === 'contract') {
            $('#contractNumberDiv').show();
            $('#orderAmountDiv').hide();
        }
    });
   
    // Trigger change on page load if radio already selected
    $('input[name="order_method"]:checked').trigger('change');
   });
</script>
<script>
   function toggleInsuranceInput(counter) {
       const yesRadio = document.getElementById(`insuranceYes${counter}`);
       const insuranceInput = document.getElementById(`insuranceInput${counter}`);
   
       if (yesRadio.checked) {
           insuranceInput.classList.remove('d-none');
       } else {
           insuranceInput.classList.add('d-none');
       }
   }
</script>



<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

@endsection