@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row add form">
                    <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4>🚛 Edit Employee Details</h4>
                                        <p>Enter the  details for the driver.</p>
                                    </div>
                                  <a  href="{{ route('admin.employees.index')}}" class="btn" id="backToListBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        ⬅ Back to Listing
                                    </a>
                                </div>
                                <form method="POST" action="{{ route('admin.employees.update',$employee->id) }}" style="padding: 20px;" >
                                    @csrf
                                 
                                    <div class="row">
                                       
                                        <!-- First Name -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🏢 First Name</label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                                name="first_name" id="editFirstName" value="{{ $employee->first_name }}"
                                                placeholder="Enter first name" required>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
    
                                        <!-- Last Name -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🔩 Last Name</label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                name="last_name" id="editLastName" value="{{ $employee->last_name }}"
                                                placeholder="Enter last name" required>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
    
                                        <!-- Official Email -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📧 Email ID</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" id="editEmail" value="{{ $employee->email }}" placeholder="Enter email"
                                                required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
    
                                        <!-- Emergency Contact Number -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📱 Contact Number</label>
                                            <input type="number"
                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                name="phone_number" id="editPhoneNumber" value="{{ $employee->phone_number }}"
                                                placeholder="Enter contact number" required minlength="10" maxlength="10">
                                            @error('phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
    
                                        <!-- Contact Number -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📞 Emergency Contact Number</label>
                                            <input type="number"
                                                class="form-control @error('emergency_contact_number') is-invalid @enderror"
                                                name="emergency_contact_number" id="editEmergencyContact"
                                                value="{{ $employee->emergency_contact_number }}"
                                                placeholder="Enter emergency contact number" required minlength="10"
                                                maxlength="10">
                                            @error('emergency_contact_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
    
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">💼 Designation (Job Title)</label>
                                            <input type="text" class="form-control @error('designation') is-invalid @enderror"
                                                name="designation" id="editDesignation" value="{{ $employee->designation }}"
                                                placeholder="Enter job title" required>
                                            @error('editDesignation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
    
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🏢 Department</label>
                                            <select class="form-select @error('department') is-invalid @enderror"
                                                name="department" id="editDepartment" required>
                                                <option value="HR" {{ (old('department', $employee->department) == 'HR') ? 'selected' : '' }}>HR</option>
                                                <option value="Manager" {{ (old('department', $employee->department) == 'Manager') ? 'selected' : '' }}>Manager</option>
                                                <option value="Accounts" {{ (old('department', $employee->department) == 'Accounts') ? 'selected' : '' }}>Accounts</option>
                                                <option value="IT" {{ (old('department', $employee->department) == 'IT') ? 'selected' : '' }}>IT</option>
                                                <option value="Operations" {{ (old('department', $employee->department) == 'Operations') ? 'selected' : '' }}>Operations</option>
                                                
                                            </select>
                                            @error('department')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📅 Date of Joining</label>
                                            <input type="date"
                                                class="form-control @error('date_of_joining') is-invalid @enderror"
                                                name="date_of_joining" id="editDOJ" value="{{ $employee->date_of_joining }}"
                                                required>
                                            @error('date_of_joining')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Residential Address -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🏠 Residential Address</label>
                                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                                name="address" id="editAddress" value="{{ $employee->address }}"
                                                placeholder="Enter address" required>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
    
                                        <!-- State -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🗺️ State</label>
                                            <select class="form-control @error('state') is-invalid @enderror" name="state" id="editState" required>
                                                <option value="">Select State</option>
                                                <option value="Delhi" {{ old('state', $employee->state) == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                                                <option value="Maharashtra" {{ old('state', $employee->state) == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                                <option value="Uttar Pradesh" {{ old('state', $employee->state) == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                                <option value="Karnataka" {{ old('state', $employee->state) == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                                <option value="Tamil Nadu" {{ old('state', $employee->state) == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                                <option value="Rajasthan" {{ old('state', $employee->state) == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                                <option value="Gujarat" {{ old('state', $employee->state) == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                                <!-- aur bhi states add kar sakte ho -->
                                            </select>
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
    
                                        <!-- Postal Code -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">📮 Postal Code</label>
                                            <input type="number" class="form-control @error('pin_code') is-invalid @enderror"
                                                name="pin_code" id="editPinCode" value="{{ $employee->pin_code }}"
                                                placeholder="Enter postal code" required>
                                            @error('pin_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
    
                                        <!-- Aadhaar Number -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🆔 Aadhaar Number</label>
                                            <input type="text"
                                                class="form-control @error('aadhaar_number') is-invalid @enderror"
                                                name="aadhaar_number" id="editAadhaar" value="{{ $employee->aadhaar_number }}"
                                                placeholder="Enter Aadhaar number" required>
                                            @error('aadhaar_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
    
                                        <!-- PAN Number -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">💳 PAN Card Number</label>
                                            <input type="text" class="form-control @error('pan_number') is-invalid @enderror"
                                                name="pan_number" id="editPAN" value="{{ $employee->pan_number }}"
                                                placeholder="Enter PAN number" required
                                                oninput="this.value = this.value.toUpperCase()">
                                            @error('pan_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
    
                                        <!-- Bank Account Number -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🏦 Bank Account Number</label>
                                            <input type="text"
                                                class="form-control @error('bank_account_number') is-invalid @enderror"
                                                name="bank_account_number" id="editAccountNumber"
                                                value="{{ $employee->bank_account_number }}" placeholder="Enter bank account number"
                                                required>
                                            @error('bank_account_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
    
                                        <!-- IFSC Code -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">🏛️ Bank IFSC Code</label>
                                            <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror"
                                                name="ifsc_code" id="editIFSC" value="{{ $employee->ifsc_code }}"
                                                placeholder="Enter IFSC code" oninput="this.value = this.value.toUpperCase()"
                                                required>
                                            @error('ifsc_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- salary --}}
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">💰  Salary</label>
                                            <input type="number" class="form-control @error('salary') is-invalid @enderror"
                                                name="salary" id="salary" value="{{ $employee->salary }}"
                                                placeholder="Enter Your Selary" 
                                                required>
                                            @error('salary')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Status -->
                                       
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">📌 Status</label>
                                            <div class="btn-group" role="group" aria-label="Status toggle">
                                                <input type="radio" class="btn-check" name="status" id="status_active"
                                                    value="active" autocomplete="off" 
                                                    {{ old('status', $employee->status) == 'active' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-success" for="status_active">Active</label>
                                        
                                                <input type="radio" class="btn-check" name="status" id="status_inactive"
                                                    value="inactive" autocomplete="off" 
                                                    {{ old('status', $employee->status) == 'inactive' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger" for="status_inactive">Inactive</label>
                                            </div>
                                            @error('status')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
    
    
                                    </div>
    
                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-primary">Update </button>
                                    </div>
                                </form>
    
                               


                            </div>
                    </div>
            </div>  
        </div>
    </div>

<!-- JavaScript for Add/Remove -->


</script>
@endsection