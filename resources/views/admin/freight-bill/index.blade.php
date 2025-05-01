@extends('admin.layouts.app')
@section('title', 'Freight-bill | KRL')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Freight Bill</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">Freight Bill</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <!-- end page title -->
      <!-- LR / Consignment Listing Page -->
      <div class="row listing-form">
         <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                     <h4 class="card-title">📑 Freight Bill</h4>
                     <p class="card-title-desc">View, edit, or delete freight bill details below.</p>
                  </div>
                  
               </div>
               <div class="card-body">
                  <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                     <thead>
                        <tr>
                           <th>S.No</th>
                           <th>Freight Bill</th>
                           <th>LR Nos</th>
                           <th>Consignors</th>
                           <th>Consignees</th>
                           <th>Dates</th>
                           <th>From</th>
                           <th>To</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($bills as $billNumber => $entries)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $billNumber }}</td>
                           <!-- All LR numbers under this bill -->
                           <td>
                              @foreach($entries as $e)
                              {{ $e->lr_number }}<br>
                              @endforeach
                           </td>
                           {{-- Consignors --}}
                           <td>
                              @foreach($entries as $e)
                              @php
                              // decode the original order->lr JSON
                              $lrArray   = is_array($e->order->lr)
                              ? $e->order->lr
                              : json_decode($e->order->lr, true);
                              // find the one matching this freight_bill row’s lr_number
                              $detail    = collect($lrArray)
                              ->firstWhere('lr_number', $e->lr_number);
                              // now load that consignor user
                              $consignor = \App\Models\User::find($detail['consignor_id'] ?? null);
                              @endphp
                              {{ $consignor->name ?? '-' }}<br>
                              @endforeach
                           </td>
                           {{-- Consignees --}}
                           <td>
                              @foreach($entries as $e)
                              @php
                              // same detail as above
                              $detail     = collect(
                              is_array($e->order->lr)
                              ? $e->order->lr
                              : json_decode($e->order->lr, true)
                              )
                              ->firstWhere('lr_number', $e->lr_number);
                              $consignee = \App\Models\User::find($detail['consignee_id'] ?? null);
                              @endphp
                              {{ $consignee->name ?? '-' }}<br>
                              @endforeach
                           </td>
                           <!-- **LR Dates** -->
                           <td>
                              @foreach($entries as $e)
                              @php
                              $lrArray = is_array($e->order->lr)
                              ? $e->order->lr
                              : json_decode($e->order->lr, true);
                              $detail  = collect($lrArray)
                              ->firstWhere('lr_number', $e->lr_number);
                              @endphp
                              {{ isset($detail['lr_date'])
                              ? \Carbon\Carbon::parse($detail['lr_date'])->format('Y-m-d')
                              : '-' 
                              }}<br>
                              @endforeach
                           </td>
                           <!-- From Location -->
                           <!-- From Location Name -->
                           <td>
                              @foreach($entries as $e)
                              @php
                              $lrArray = is_array($e->order->lr)
                              ? $e->order->lr
                              : json_decode($e->order->lr, true);
                              $detail  = collect($lrArray)
                              ->firstWhere('lr_number', $e->lr_number);
                              // Fetch from_location name
                              $fromLocation = \App\Models\Destination::find($detail['from_location'] ?? null);
                              @endphp
                              {{ $fromLocation->destination ?? 'Unknown Location' }}<br>
                              @endforeach
                           </td>
                           <!-- To Location Name -->
                           <td>
                              @foreach($entries as $e)
                              @php
                              $lrArray = is_array($e->order->lr)
                              ? $e->order->lr
                              : json_decode($e->order->lr, true);
                              $detail  = collect($lrArray)
                              ->firstWhere('lr_number', $e->lr_number);
                              // Fetch to_location name
                              $toLocation = \App\Models\Destination::find($detail['to_location'] ?? null);
                              @endphp
                              {{ $toLocation->destination ?? 'Unknown Location' }}<br>
                              @endforeach
                           </td>
                           <td>
                              <button class="btn btn-sm btn-light view-btn"><i
                                 class="fas fa-eye text-primary"></i></button>
                              <a href="" class="btn btn-sm btn-light"><i
                                 class="fas fa-pen text-warning"></i></a>
                              <button class="btn btn-sm btn-light delete-btn"><i
                                 class="fas fa-trash text-danger"></i></button>
                           </td>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- container-fluid -->
</div>
<!-- modal code -->
<!-- add modal -->
<div class="modal fade" id="addTyreModal" tabindex="-1" aria-labelledby="addTyreModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="addTyreModalLabel">🛞 Add Freight Bill</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form action="{{ route('admin.freight-bill.store') }}" method="post">
               @csrf
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label class="form-label">🏢 Freight Bill</label>
                     <input type="text" class="form-control" id="inputCompany"
                        placeholder="Enter Notes" name="notes" required>
                  </div>
               </div>
               <div class="text-end">
                  <button type="submit" class="btn btn-primary">Add
                  freight bill</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- add modal -->
<!-- update modal -->
{{-- //update tyre model --}}
<div class="modal fade" id="updateTyreModal" tabindex="-1" aria-labelledby="updateTyreModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">🛞 Edit FreightBill</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="editForm"  method="post" action="">
               @csrf
               @method('PUT')
               <div class="row">
                  <input type="hidden" id="editid">
                  <div class="col-md-6 mb-3">
                     <label class="form-label">🏢 FreightBill</label>
                     <input type="text" class="form-control" placeholder="Enter notes"
                        id="editCompany" name="notes" required>
                  </div>
               </div>
               <div class="text-end">
                  <button type="submit" class="btn btn-primary">Update FreightBill </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- update modal -->
<!-- modal code -->
<script>
   document.addEventListener('DOMContentLoaded', function () {
   // Event delegation from document since child rows are dynamically inserted
   document.addEventListener('click', function (e) {
     // Check if the clicked element or its parent has class 'edit-btn'
     const btn = e.target.closest('.edit-btn');
     if (!btn) return;
   
     const tyreData = {
         id: btn.dataset.id,
         name: btn.dataset.name,
         
     };
   
     // console.log("Clicked row data:", tyreData);
   
     // Fill modal fields
     $('#editid').val(tyreData.id);
     $('#editCompany').val(tyreData.name);
      
   
     let form = document.getElementById('editForm');
     form.action = `/admin/freight-bill/update/${tyreData.id}`;
     // Show modal
     $('#updateTyreModal').modal('show');
   });
   });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
       document.getElementById("addTyreBtn").addEventListener("click", function () {
           var addTyreModal = new bootstrap.Modal(document.getElementById("addTyreModal"));
           addTyreModal.show();
       });
       document.getElementById("updateTyreBtn").addEventListener("click", function () {
               var updateTyreBtnTyreModal = new bootstrap.Modal(document.getElementById("updateTyreModal"));
               updateTyreModal.show();
           });  
   });
</script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
       document.querySelectorAll('.delete-btn').forEach(button => {
           button.addEventListener('click', function (e) {
               e.preventDefault();
   
               if (!confirm('Are you sure you want to delete this freight-bill record?')) return;
   
               const url = this.getAttribute('data-url');
   
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
                       location.reload(); // Reload the page on success
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