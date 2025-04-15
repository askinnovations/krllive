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
                  <a href="{{ route('admin.consignments.create') }}" class="btn" id="addOrderBtn"
                     style="background-color: #ca2639; color: white; border: none; margin-left: 46%;">
                  <i class="fas fa-plus"></i> Add LR / Consignment
                  </a>

                  
                  <form id="lrForm" action="{{ route('admin.freight-bill.view') }}" method="post" style="display: inline;">
                    @csrf
                        <input type="hidden" id="lrInputVisible" readonly style="width: 300px;">
                        <input type="hidden" name="lr[]" id="lrInputHidden">
                        <button type="submit" id="generateBtn" class="btn custom-btn" 
                        style="background-color: #ca2639; color: white; border: none;">Freight Bill LR Generate  </button>
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rowCount = 1; @endphp
                    @foreach($orders as $order)
                        @php
                            $lrDetails = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
                        @endphp
                        @foreach($lrDetails as $lr)
                            <tr class="lr-row" data-id="{{ $order->id }}">
                            <td>
                            <input type="checkbox" class="lr-checkbox" value="{{ $lr['lr_number'] }}">


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
                            <td>{{ $lr['from_location'] ?? '-' }}</td>
                            <td>{{ $lr['to_location'] ?? '-' }}</td>
                            <td>
   


                                <a href="{{ route('admin.consignments.view', $lr['lr_number']) }}" class="btn btn-sm btn-light view-btn"><i class="fas fa-eye text-primary"></i></a>
                                <a href="{{ route('admin.consignments.edit', $order->order_id) }}" class="btn btn-sm btn-light edit-btn"><i class="fas fa-pen text-warning"></i></a>
                                <a href="{{ route('admin.consignments.delete', $order->order_id) }}" class="btn btn-sm btn-light delete-btn"><i class="fas fa-trash text-danger"></i></a>
                            </td>
                            </tr>
                        @endforeach
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
<script>
    const checkboxes = document.querySelectorAll('.lr-checkbox');
    const selectAllCheckbox = document.getElementById('selectAll');
    const visibleInput = document.getElementById('lrInputVisible');
    const hiddenContainer = document.getElementById('lrForm');
    const generateBtn = document.getElementById('generateBtn');

    function updateInputs() {
        const selected = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        // Update visible input for debugging or preview (optional)
        visibleInput.value = selected.join(', ');

        // Show or hide the button
        generateBtn.style.display = selected.length > 0 ? 'inline-block' : 'none';

        // Remove existing hidden inputs
        document.querySelectorAll('#lrForm input[name="lr[]"]').forEach(el => el.remove());

        // Create new hidden inputs
        selected.forEach(val => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'lr[]';
            input.value = val;
            hiddenContainer.appendChild(input);
        });
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateInputs));

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateInputs();
        });
    }

    // Just in case - initialize visibility on page load
    updateInputs();
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