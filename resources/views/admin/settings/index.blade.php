@extends('admin.layouts.app')
@section('title', 'Package Type | KRL')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">settings</h4>
               @if(session('success'))
               <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
               @endif
               @if(session('error'))
               <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
               @endif
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                     <li class="breadcrumb-item active">settings</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <!-- end page title -->
      <div class="row listing-form">
         <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                     <h4 class="card-title">🛞  settings</h4>
                     <p class="card-title-desc">
                        View, edit, or delete settings details below. This table supports search,
                        sorting, and pagination via DataTables.
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- row add-->
      <div class="row listing-form">
         <div class="col-12">
            <form method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">
               @csrf
               <div class="row">
                  <div class="col-md-3">
                     <label for="logo" class="form-label">Logo</label>
                     <input class="form-control" type="file" id="logo" name="logo">

                     @if(!empty($settings->logo))
                     
                     <img src="{{ asset('uploads/' . $settings->logo) }}" alt="Logo" height="50" class="mt-2">
                     @endif

                  </div>
                  <div class="col-md-3">
                     <label class="form-label">Head Office</label>
                     
                     <input type="text" name="head_office" class="form-control" value="{{ old('head_office', $settings->head_office ?? '') }}">
                  </div>
                  <div class="col-md-3">
                     <label class="form-label">Mobile</label>
                     <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $settings->mobile ?? '') }}">
                  </div>
                  <div class="col-md-3">
                     <label class="form-label">offices</label>
                     <input type="text" name="offices" class="form-control" value="{{ old('offices', $settings->offices ?? '') }}">
                  </div>
                  <div class="col-md-3">
                     <label class="form-label">Email</label>
                     <input type="text" name="email" class="form-control" value="{{ old('email', $settings->email ?? '') }}">
                  </div>
                  <div class="col-md-3">
                     <label class="form-label">Website</label>
                     <input type="text" name="website" class="form-control" value="{{ old('website', $settings->website ?? '') }}">
                  </div>
                  <div class="col-md-3">
                     <label class="form-label">GSTIN / Transporter Id</label>
                     <input type="text" name="transporter" class="form-control" value="{{ old('transporter', $settings->transporter ?? '') }}">
                  </div>
                  <div class="col-md-3">
                     <label class="form-label">Type</label>
                     <div>
                        <input type="radio" name="type" id="type_rcm" value="rcm" 
                        {{ ($settings->type ?? '') == 'rcm' ? 'checked' : '' }}>
                        <label for="type_rcm">RCM</label>
                        <input type="radio" name="type" id="type_fcm" value="fcm" 
                        {{ ($settings->type ?? '') == 'fcm' ? 'checked' : '' }} class="ms-3">
                        <label for="type_fcm">FCM</label>
                     </div>
                  </div>
                  <div class="col-md-3 {{ old('type', $settings->type ?? '') != 'rcm' ? 'd-none' : '' }}" >
                  <label class="form-label">RCM Description</label>
                  <textarea name="rcm_description" class="form-control" rows="3">{{ old('rcm_description', $settings->rcm_description ?? '') }}</textarea>
                  </div>

                  <div class="col-md-3 {{ old('type', $settings->type ?? '') != 'fcm' ? 'd-none' : '' }}">
                     <label class="form-label">FCM Description</label>
                     <input type="text" name="fcm_code" class="form-control" value="{{ old('fcm_code', $settings->fcm_code ?? '') }}">
                  </div>

               </div>
               <div class="row">
                  <div class="col-lg-12 mt-4">
                     <button type="submit" class="btn btn-primary">Update</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <!-- row add -->
   </div>
</div>

<script>
   document.addEventListener("DOMContentLoaded", function () {
      function toggleTypeBoxes() {
         const selectedType = document.querySelector('input[name="type"]:checked')?.value;
         document.getElementById("rcmBox").classList.toggle("d-none", selectedType !== "rcm");
         document.getElementById("fcmBox").classList.toggle("d-none", selectedType !== "fcm");
      }
   
      document.querySelectorAll('input[name="type"]').forEach(input => {
         input.addEventListener('change', toggleTypeBoxes);
      });
   
      // Call once on load
      toggleTypeBoxes();
   });
</script>
<!-- end main content-->

@endsection