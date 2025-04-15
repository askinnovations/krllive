@extends('admin.layouts.app')
@section('title', 'Order | KRL')
@section('content')
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
                                            <h5>📦 Consignor (Sender)</h5>
                                            
                                            <select name="consignor_id" id="consignor_id" class="form-select" onchange="setConsignorDetails()" required>
                    <option value="">Select Consignor Name</option>
                    @foreach($users as $user)
                        @php
                            $addresses = json_decode($user->address, true);
                            $formattedAddress = '';
                  
                            if (!empty($addresses) && is_array($addresses)) {
                                $first = $addresses[0]; // Use first address if multiple
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

                                            <div class="mb-3">
                                                <label class="form-label">Consignor Loading Address</label>
                                                <textarea name="consignor_loading" id="consignor_loading" class="form-control" rows="2"
                                                    placeholder="Enter all addresses" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Consignor GST</label>
                                                <input type="text" name="consignor_gst" id="consignor_gst" class="form-control" placeholder="Enter GST numbers" required>
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
                                            
                                            <select name="consignee_id" id="consignee_id" class="form-select" onchange="setConsigneeDetails()" required>
                     <option value="">Select Consignee Name</option>
                      @foreach($users as $user)
                        @php
                            $addresses = json_decode($user->address, true);
                            $formattedAddress = '';
                      
                            if (!empty($addresses) && is_array($addresses)) {
                                $first = $addresses[0]; // assuming only 1 or using the first
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
                                            <div class="mb-3">
                                                <label class="form-label">Consignee Unloading Address</label>
                                                <textarea name="consignee_unloading" id="consignee_unloading" class="form-control" rows="2"
                                                    placeholder="Enter all addresses" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Consignee GST</label>
                                                <input name="consignee_gst" id="consignee_gst" type="text" class="form-control" placeholder="Enter GST numbers" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Date -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">📅  Vehicle Date</label>
                                                <input name="vehicle_date" type="date" class="form-control" required>
                                            </div>
                                        </div>

                                        <!-- Vehicle Type -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">🚛 Vehicle Type</label>
                                                <select name="vehicle_type" class="form-select" required>
                                                    <option selected>Select Type</option>
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
                                                <select name="delivery_mode" class="form-select" required>
                                                    <option selected>Select Mode</option>
                                                    <option>Road</option>
                                                    <option>Rail</option>
                                                    <option>Air</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- From Location -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">📍 From (Origin)</label>
                                                <select name="from_location" class="form-select" required>
                                                    <option selected>Select Origin</option>
                                                    <option>Mumbai</option>
                                                    <option>Delhi</option>
                                                    <option>Chennai</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- To Location -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">📍 To (Destination)</label>
                                                <select name="to_location" class="form-select" required>
                                                    <option selected>Select Destination</option>
                                                    <option>Kolkata</option>
                                                    <option>Hyderabad</option>
                                                    <option>Pune</option>
                                                </select>
                                            </div>
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
                                                    <tbody id="cargoTableBody">
                                                        <tr>
                                                            <td><input type="number" name="cargo[0][packages_no]" class="form-control" placeholder="0" required></td>
                                                            <td>
                                                                <select name="cargo[0][package_type]" class="form-select" required>
                                                                    <option value="Pallets">Pallets</option>
                                                                    <option value="Cartons">Cartons</option>
                                                                    <option value="Bags">Bags</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="cargo[0][package_description]" class="form-control" placeholder="Enter description" required></td>
                                                            <td><input name="cargo[0][weight]" type="number" class="form-control" placeholder="0" required></td>
                                                            <td><input name="cargo[0][actual_weight]" type="number" class="form-control" placeholder="0" required></td>
                                                            <td><input name="cargo[0][charged_weight]" type="number" class="form-control" placeholder="0" required></td>
                                                            <td><input name="cargo[0][document_no]" type="text" class="form-control" placeholder="Doc No." required></td>
                                                            <td><input name="cargo[0][document_name]" type="text" class="form-control" placeholder="Doc Name" required></td>
                                                            <td><input name="cargo[0][document_date]" type="date" class="form-control" required></td>
                                                            <td><input name="cargo[0][eway_bill]" type="text" class="form-control" placeholder="Eway Bill No." required></td>
                                                            <td><input name="cargo[0][valid_upto]" type="date" class="form-control" required></td>
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

                                            

                                            <!-- Freight Charges Table -->
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
                                                            <td><input name="freight_amount" type="number" class="form-control"
                                                                    placeholder="Enter Freight Amount" required></td>
                                                            <td><input name="lr_charges" type="number" class="form-control"
                                                                    placeholder="Enter LR Charges" required></td>
                                                            <td><input name="hamali" type="number" class="form-control"
                                                                    placeholder="Enter Hamali Charges" required></td>
                                                            <td><input name="other_charges" type="number" class="form-control"
                                                                    placeholder="Enter Other Charges" required></td>
                                                            <td><input name="gst_amount" type="number" class="form-control"
                                                                    placeholder="Enter GST Amount" required></td>
                                                            <td><input name="total_freight" type="number" class="form-control"
                                                                    placeholder="Total Freight" required></td>
                                                            <td><input name="less_advance" type="number" class="form-control"
                                                                    placeholder="Less Advance Amount" required></td>
                                                            <td><input name="balance_freight" type="number" class="form-control"
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
                                                <label class="form-label " style="font-weight: bold;">💰 Declared Value
                                                    (Rs.)</label>
                                                <input type="number" name="declared_value" class="form-control" required>
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
            }
        });

        table.appendChild(newRow);
    }

    function removeRow(button) {
        let table = document.getElementById('cargoTableBody');
        if (table.rows.length > 1) {
            button.closest('tr').remove();

            // Reindex rows
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
        }
    }
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
       const selected = document.getElementById('consignee_id');
       const gst = selected.options[selected.selectedIndex].getAttribute('data-gst-consignee');
       const address = selected.options[selected.selectedIndex].getAttribute('data-address-consignee');
   
       document.getElementById('consignee_gst').value = gst || '';
       document.getElementById('consignee_unloading').value = address || '';
   }
</script>
@endsection