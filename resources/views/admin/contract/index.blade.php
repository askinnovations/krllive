@extends('admin.layouts.app')
@section('title', 'Package Type | KRL')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Contract</h4>
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
                     <li class="breadcrumb-item active">Contract</li>
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
                     <h4 class="card-title">🛞 Contract Listing</h4>
                     <p class="card-title-desc">
                        View, edit, or delete Contract details below. This table supports search,
                        sorting, and pagination via DataTables.
                     </p>
                  </div>
               </div>
               <div class="card-body">
                  <table id="" class="table table-bordered dt-responsive nowrap w-100">
                     <thead>
                        <tr>
                           <th>S.No</th>
                           <th>Contract</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $serial = 1; @endphp
                        @foreach ($users as $user)
                        @php
                        $addresses = json_decode($user->address, true);
                        @endphp
                        @if (!empty($addresses) && is_array($addresses))
                        @foreach ($addresses as $address)
                        <tr>
                           <td>{{ $serial++ }}</td>
                           <td class="w-75">
                              <div>
                                 <p class="mb-1"><strong>{{ $user->name }}</strong></p>
                                 <p class="mb-1"><strong>{{ $address['city'] ?? '' }},</strong></p>
                                 <p class="mb-0">
                                    {{ $address['billing_address'] ?? '' }},
                                    {{ $address['consignment_address'] ?? '' }},
                                    {{ $address['mobile_number'] ?? '' }},
                                    {{ $address['email'] ?? '' }},
                                    {{ $address['poc'] ?? '' }}
                                 </p>
                              </div>
                           </td>
                           
                           <td class="text-center">
                              <div class="d-flex align-items-center gap-2">
                              <a href="{{ route('admin.contract.view', $user->id) }}" class="btn btn-sm btn-light view-btn">
                                <i class="fas fa-eye text-primary"></i>
                              </a>

                              </div>
                           </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                           <td>{{ $serial++ }}</td>
                           <td>{{ $user->name }} - No Address Available</td>
                           <td class="text-center">
                              <button class="btn btn-sm btn-light view-btn">
                              <i class="fas fa-eye text-primary"></i>
                              </button>
                           </td>
                        </tr>
                        @endif
                        @endforeach
                     </tbody>
                  </table>
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<!-- end main content-->
@endsection