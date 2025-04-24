@extends('frontend.layouts.dashboard-app')
@section('title') {{ 'contact' }} @endsection
@section('content')
<style>
   .navbar-nav .nav-link {
   color: #333;
   transition: color 0.3s ease;
   }
   .navbar-nav .nav-link:hover {
   color: #007bff;
   }
   .navbar-nav .badge {
   font-size: 10px;
   padding: 2px 5px;
   }
   .dropdown-menu {
   font-size: 0.9rem;
   border-radius: 8px;
   }
   .theme-btn:hover {
   background-color: #0056b3;
   color: #fff;
   }
   .theme-btn {
   background-color: #c72336;
   color: #fff;
   border: none;
   transition: background-color 0.3s ease;
   font-weight: 600 !important;
   border-radius: 10px !important;
   margin-left: 20px;
   }
   .navbar-nav .badge {
   font-size: 12px;
   padding: 2px 5px;
   margin-top: 23px;
   }
   /* Primary and Secondary Colors */
   .text-secondary-custom {
   color: #003F72 !important;
   }
   .custom-badge {
   background-color: #c72336;
   color: #fff;
   font-size: 0.7rem;
   padding: 4px 6px;
   border-radius: 10px;
   }
   .custom-dropdown {
   border: 1px solid #e0e0e0;
   border-radius: 8px;
   background-color: #f8f9fa;
   }
   .dropdown-item:hover {
   background-color: #003F72;
   color: #fff;
   }
   .dropdown-item i {
   min-width: 16px;
   }
   .view-all-link {
   color: #c72336;
   font-weight: 500;
   }
   .view-all-link:hover {
   color: #fff;
   background-color: #c72336;
   }
   .theme-btn {
   background-color: #003F72;
   color: #fff;
   transition: background 0.3s ease;
   }
   .theme-btn:hover {
   background-color: none !important;
   color: #fff;
   }
   .profile-dropdown {
   border: 1px solid #e0e0e0;
   border-radius: 8px;
   background-color: #f8f9fa;
   }
   .profile-dropdown .dropdown-item {
   font-size: 0.9rem;
   padding: 8px 12px;
   border-radius: 6px;
   }
   .profile-dropdown .dropdown-item:hover {
   background-color: #003F72;
   color: #fff;
   }
   .text-secondary-custom {
   color: #003F72;
   }
   .navbar .nav-item .dropdown-menu .dropdown-item:hover {
   background: none;
   color: #c72336 !important;
   }
   .bg-primary-custom {
   background-color: #c72336 !important;
   color: #fff;
   }
   .btn-danger {
   background-color: #c72336;
   border-color: #c72336;
   }
   .btn-danger:hover {
   background-color: #a31c2c;
   border-color: #a31c2c;
   }
   .table thead th {
   background-color: #f8f9fa;
   }
   .pagination .page-link {
   color: #003F72;
   }
   .pagination .active .page-link {
   background-color: #c72336 !important;
   border-color: #c72336 !important;
   }
   .res {
   margin-top: 4%;
   }
   .krl-btn {
   background-color: #c72336;
   border: none;
   color: #fff;
   }
   .krl-btn:hover {
   background-color: #a91e2c;
   }
   .krl-outline-btn {
   border: 1px solid #003F72;
   color: #003F72;
   background-color: #fff;
   }
   .krl-outline-btn:hover {
   background-color: #003F72;
   color: #fff;
   }
   .form-label {
   color: #003F72;
   font-weight: 500;
   }
   .form-control:focus,
   textarea:focus {
   border-color: #c72336;
   box-shadow: 0 0 0 0.2rem rgba(199, 35, 54, 0.25);
   }
   .profile-section h4,
   .profile-section h5 {
   color: #003F72;
   font-weight: 600;
   }
   .address-block {
   border-left: 5px solid #003F72;
   }
   .card {
   border-radius: 1rem;
   }
   .btn-sa {
   background-color: #c72336;
   border: none;
   font-weight: 600;
   color: #fff;
   padding: 5px 25px;
   border-radius: 10px;
   background-color: #c72336;
   }
   .dss {
   background: #003F72;
   border: none;
   padding: 8px;
   color: #fff;
   font-weight: 600;
   }
   .dss:hover {
   background: #003F72;
   }
   @media (max-width: 576px) {
   .table-responsive {
   font-size: 0.875rem;
   }
   }
   @media (max-width: 576px) {
   .nav-btn {
   margin-top: 10px;
   }
   .profile-dropdown {
   min-width: 100%;
   }
   }
   @media (max-width: 786px) {
   .custom-dropdown {
   min-width: 100%;
   }
   .navbar-toggler span {
   border: none;
   }
   .navbar-nav .badge {
   font-size: 12px;
   padding: 2px 5px;
   margin-top: 0;
   }
   }
   @media (max-width: 767.98px) {
   .res .col-custom {
   width: 50%;
   flex: 0 0 50%;
   }
   .portfolio-sidebar .widget {
   background: var(--color-white);
   padding: 15px;
   border-radius: 7px;
   margin-bottom: 0px;
   box-shadow: 0 0 12px 2px rgb(0 0 0 / 5%);
   height: 136px;
   }
   .portfolio-sidebar .widget .title {
   font-size: 18px;
   }
   .portfolio-sidebar h3 {
   color: #c72336;
   font-size: 32px;
   margin-top: -15px;
   }
   .navbar .offcanvas-header .btn-close {
   background-color: var(--color-red);
   background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 2l12 12M14 2L2 14'/%3E%3C/svg%3E");
   background-size: 1rem;
   background-repeat: no-repeat;
   background-position: center;
   }
   .btn-sa {
   background-color: #c72336;
   border: none;
   font-weight: 600;
   color: #fff;
   padding: 5px 25px;
   border-radius: 10px;
   width: 100%;
   background-color: #c72336;
   margin-top: 2%;
   }
   .profile-section{
   padding-top: 1rem !important;
   }
   }
</style>
<section class="profile-section py-5">
   <div class="container">
      <form action="{{ route('user.update') }}" method="POST">
         @csrf
         <div class="card shadow border-0 rounded-4 p-4">
            <h4 class="mb-4">🧾 Customer Information</h4>
            <!-- Row 1: Basic Info -->
            <div class="row g-3">
               <div class="col-md-4">
                  <label class="form-label">Customer Name</label>
                  <input type="text" name="name" class="form-control"
                     placeholder="Enter customer name"  value="{{ old('name', auth()->user()->name ?? '') }}" required>
               </div>
               <div class="col-md-4">
                  <label class="form-label">PAN Number</label>
                  <input type="text" name="pan_number" class="form-control" placeholder="Enter PAN number" value="{{ old('pan_number', auth()->user()->pan_number ?? '') }}"
                     required>
               </div>
               <div class="col-md-4">
                  <label class="form-label">TAN Number</label>
                  <input type="text" name="tan_number" class="form-control" placeholder="Enter TAN number" value="{{ old('tan_number', auth()->user()->tan_number ?? '') }}"
                     required>
               </div>
            </div>
            <hr class="my-4">
            <!-- Dynamic Address Block -->
            <h5 class="mb-3">🏠 Address Details</h5>
            <div id="address-blocks">
               @php
               $addresses = json_decode(auth()->user()->address ?? '[]', true);
               @endphp
               @foreach ($addresses as $index => $addr)
               <!-- Address Block -->
               <div class="address-block mb-4 border p-3 rounded bg-white">
                  <div class="row g-3">
                     <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <input type="text" name="address[{{ $index }}][city]" class="form-control"
                           placeholder="Enter location" value="{{ $addr['city'] ?? '' }}" required>
                     </div>
                     <div class="col-md-6">
                        <label class="form-label">GSTIN</label>
                        <input type="text" name="address[{{ $index }}][gstin]" class="form-control"
                           placeholder="Enter GSTIN" value="{{ $addr['gstin'] ?? '' }}" required>
                     </div>
                     <div class="col-md-6">
                        <label class="form-label">Billing Address</label>
                        <textarea name="address[{{ $index }}][billing_address]" class="form-control" rows="2"
                           placeholder="Enter billing address" required>{{ $addr['billing_address'] ?? '' }}</textarea>
                     </div>
                     <div class="col-md-6">
                        <label class="form-label">Consignment Address</label>
                        <textarea name="address[{{ $index }}][consignment_address]" class="form-control" rows="2"
                           placeholder="Enter consignment address" required>{{ $addr['consignment_address'] ?? '' }}</textarea>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label">Mobile Number</label>
                        <input type="tel" name="address[{{ $index }}][mobile_number]" class="form-control"
                           placeholder="Enter mobile number" value="{{ $addr['mobile_number'] ?? '' }}" required>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="address[{{ $index }}][email]" class="form-control"
                           placeholder="Enter email" value="{{ $addr['email'] ?? '' }}" required>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label">Point of Contact</label>
                        <input type="text" name="address[{{ $index }}][poc]" class="form-control"
                           placeholder="Enter name of contact person" value="{{ $addr['poc'] ?? '' }}" required>
                     </div>
                  </div>
                  <!-- Remove Button (only shown for extra addresses) -->
                  <div class="text-end mt-3 remove-btn-container" style="{{ $loop->first ? 'display: none;' : '' }}">
                     <button type="button" class="btn btn-danger btn-sm" onclick="removeAddress(this)">
                     Remove Address
                     </button>
                  </div>
               </div>
               @endforeach
               {{-- If no addresses found, show one empty block --}}
               @if (count($addresses) === 0)
               <div class="address-block mb-4 border p-3 rounded bg-white">
                  <div class="row g-3">
                     <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <input type="text" name="address[0][city]" class="form-control"
                           placeholder="Enter location" required>
                     </div>
                     <div class="col-md-6">
                        <label class="form-label">GSTIN</label>
                        <input type="text" name="address[0][gstin]" class="form-control"
                           placeholder="Enter GSTIN" required>
                     </div>
                     <div class="col-md-6">
                        <label class="form-label">Billing Address</label>
                        <textarea name="address[0][billing_address]" class="form-control" rows="2"
                           placeholder="Enter billing address" required></textarea>
                     </div>
                     <div class="col-md-6">
                        <label class="form-label">Consignment Address</label>
                        <textarea name="address[0][consignment_address]" class="form-control" rows="2"
                           placeholder="Enter consignment address" required></textarea>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label">Mobile Number</label>
                        <input type="tel" name="address[0][mobile_number]" class="form-control"
                           placeholder="Enter mobile number" required>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="address[0][email]" class="form-control"
                           placeholder="Enter email" required>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label">Point of Contact</label>
                        <input type="text" name="address[0][poc]" class="form-control"
                           placeholder="Enter name of contact person" required>
                     </div>
                  </div>
                  <div class="text-end mt-3 remove-btn-container" style="display: none;">
                     <button type="button" class="btn btn-danger btn-sm" onclick="removeAddress(this)">
                     Remove Address
                     </button>
                  </div>
               </div>
               @endif
            </div>
            <!-- Add Address Button -->
            <div class="text-start mb-3">
               <button type="button" class="btn dss btn-outline-primary btn-sm" onclick="addAddress()">+ Add More Address</button>
            </div>
            <div class="text-end">
               <button type="submit" class="btn-sa">Save Details</button>
            </div>
         </div>
      </form>
   </div>
</section>
<!-- Script -->
<script>
   let addressIndex = {{ count($addresses) > 0 ? count($addresses) : 1 }};
   
   function addAddress() {
       const originalBlock = document.querySelector('.address-block');
       const newBlock = originalBlock.cloneNode(true);
   
       // Clear values
       newBlock.querySelectorAll('input, textarea').forEach(el => el.value = '');
   
       // Update name attributes with new index
       newBlock.querySelectorAll('input, textarea').forEach(el => {
           if (el.name) {
               el.name = el.name.replace(/\[\d+\]/, `[${addressIndex}]`);
           }
       });
   
       // Show remove button
       newBlock.querySelector('.remove-btn-container').style.display = 'block';
   
       // Append
       document.getElementById('address-blocks').appendChild(newBlock);
       addressIndex++;
   }
   
   function removeAddress(button) {
       button.closest('.address-block').remove();
   }
</script>
@endsection