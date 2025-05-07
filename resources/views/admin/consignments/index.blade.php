@extends('admin.layouts.app')
@section('title', 'Order | KRL')
@section('content')

<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18"> LR / Consignment</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active"> LR / Consignment</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <!-- end page title -->
      <!-- Order Booking listing Page -->
      <div class="row listing-form">
         <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                     <h4 class="card-title">📦 LR / Consignment</h4>
                     <p class="card-title-desc">View, edit, or delete order details below.</p>
                  </div>
                  @if (hasAdminPermission('create lr_consignment'))
                  <a href="{{ route('admin.consignments.create') }}" class="btn" id="addOrderBtn"
                     style="background-color: #ca2639; color: white; border: none; margin-left: 46%;">
                  <i class="fas fa-plus"></i> Add LR / Consignment
                  </a>
                  @endif
                

                    <!-- Freight Bill Form -->
<form id="lrForm" action="{{ route('admin.freight-bill.store') }}" method="post" style="display: inline;">
    @csrf
    <input type="hidden" name="selected_lrs" id="orderInputHidden">
    {{-- @if (hasAdminPermission('add lr_consignment')) --}}
    <button type="submit" id="generateBtn" class="btn custom-btn"
        style="background-color: #ca2639; color: white; border: none; display: none;">
        Freight Bill LR Generate
    </button>
    {{-- @endif --}}
</form>



               </div>
               <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>  
                                <th>S.No</th>
                                <th>Order ID</th>
                                <th>LR NO</th>
                                <th>Consignor</th>
                                <th>Consignee</th>
                                <th>Date</th>
                                <th>From</th>
                                <th>To</th>
                                @if (hasAdminPermission('edit lr_consignment') || hasAdminPermission('delete lr_consignment')|| hasAdminPermission('view lr_consignment'))
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $rowCount = 1; @endphp
                            @foreach($orders as $order)
                                @php
                                    $lrDetails = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
                                @endphp
                                @if(!empty($lrDetails) && count($lrDetails) > 0)
                                    @foreach($lrDetails as $lr)
                                        <tr class="lr-row" data-id="{{ $order->id }}">
                                            <td>
                                                <input type="checkbox" class="lr-checkbox" value="{{ $order->order_id }}|{{ $lr['lr_number'] ?? '' }}">
                                            </td>
                                            <td>{{ $rowCount++ }}</td>
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ $lr['lr_number'] ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $consignorUser = \App\Models\User::find($lr['consignor_id'] ?? null);
                                                    $consignorName = $order->consignor->name ?? ($consignorUser->name ?? '-');
                                                @endphp
                                                {{ $consignorName }}
                                            </td>
                                            <td>
                                                @php
                                                    $consigneeUser = \App\Models\User::find($lr['consignee_id'] ?? null);
                                                    $consigneeName = $order->consignee->name ?? ($consigneeUser->name ?? '-');
                                                @endphp
                                                {{ $consigneeName }}
                                            </td>
                                            <td>{{ $lr['lr_date'] ?? '-' }}</td>
                                            @php
                                                $fromDestination = \App\Models\Destination::find($lr['from_location']);
                                                $toDestination = \App\Models\Destination::find($lr['to_location']);
                                            @endphp
                                            <td>{{ $fromDestination->destination ?? '-' }}</td>
                                            <td>{{ $toDestination->destination ?? '-' }}</td>


                                             @if (hasAdminPermission('edit lr_consignment') || hasAdminPermission('delete lr_consignment')|| hasAdminPermission('view lr_consignment'))
                                             <td>
                                                @if (hasAdminPermission('view lr_consignment'))
                                                <a href="{{ route('admin.consignments.documents', $lr['lr_number']) }}" class="btn btn-sm btn-light"><i class="fas fa-file-alt text-primary"></i></a>
                                                @endif
                                                @if (hasAdminPermission('view lr_consignment'))
                                                <a href="{{ route('admin.consignments.view', $lr['lr_number']) }}" class="btn btn-sm btn-light"><i class="fas fa-eye text-primary"></i></a>
                                                @endif
                                                @if (hasAdminPermission('edit lr_consignment'))
                                                <a href="{{ route('admin.consignments.edit', $order->order_id) }}" class="btn btn-sm btn-light"><i class="fas fa-pen text-warning"></i></a>
                                                @endif
                                                @if (hasAdminPermission('delete lr_consignment'))

                                                <a href="{{ route('admin.consignments.delete', $order->order_id) }}" class="btn btn-sm btn-light"><i class="fas fa-trash text-danger"></i></a>
                                               @endif
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

               
            </div>
         </div>
      </div>
   </div>
   <!-- End Page-content -->
</div>
<!-- end main content-->
<!-- Add this before any script that uses jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script to collect selected order IDs and submit the form -->
<!-- JavaScript -->
<script>
  const generateBtn = document.getElementById("generateBtn");
  const orderInputHidden = document.getElementById("orderInputHidden");

  function updateSelectedLRs() {
    const selectedData = [];

    document.querySelectorAll(".lr-checkbox:checked").forEach(cb => {
      const [order_id, lr_number] = cb.value.split("|");
      selectedData.push({ order_id, lr_number });
    });

    orderInputHidden.value = JSON.stringify(selectedData);
    generateBtn.style.display = selectedData.length > 0 ? "inline-block" : "none";
  }

  // Individual checkbox
  document.querySelectorAll(".lr-checkbox").forEach(cb =>
    cb.addEventListener("change", updateSelectedLRs)
  );

  // Select All checkbox
  document.getElementById("selectAll").addEventListener("change", function () {
    document.querySelectorAll(".lr-checkbox").forEach(cb => cb.checked = this.checked);
    updateSelectedLRs();
  });

  // On button click
  generateBtn.addEventListener("click", function (e) {
    e.preventDefault();
    document.getElementById("lrForm").submit();
  });

  // Initially hide
  generateBtn.style.display = "none";
</script>







<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="selected_rows[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>

<script>
    
   document.addEventListener('DOMContentLoaded', function () {
       document.querySelectorAll('.delete-btn').forEach(button => {
           button.addEventListener('click', function (e) {
               e.preventDefault();
   
               if (!confirm('Are you sure you want to delete all LR entries under this order ID?')) return;
   
               const url = this.getAttribute('href');
   
               fetch(url, {
                   method: 'DELETE',
                   headers: {
                       'X-CSRF-TOKEN': '{{ csrf_token() }}',
                       'Accept': 'application/json'
                   }
               })
               .then(response => response.json())
               .then(data => {
                   alert(data.message);
                   if (data.status === 'success') {
                       location.reload(); // or redirect
                   }
               })
               .catch(error => {
                   console.error('Error:', error);
                   alert('Something went wrong.');
               });
           });
       });
   });
</script>
@endsection