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
   </div>
</div>
</div>
<!-- end main content-->
@endsection