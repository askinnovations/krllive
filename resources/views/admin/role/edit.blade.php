

@extends('admin.layouts.app')
@section('title', 'Employees | KRL')

@section('content')
<style>
    .form-label .required {
        color: red;
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18"> Edit Role</h4>
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
                                <li class="breadcrumb-item active">Edit  Role</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <!-- Tyre Listing Page -->
            <div class="row listing-form">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>

                                <h4 class="card-title">🛞Edit  Role </h4>
                                <p class="card-title-desc">
                                    View, edit, or delete role details below. This table supports search,
                                    sorting, and pagination via DataTables.
                                </p>
                            </div>
                           
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.role.update',$role->id) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                             
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Name <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ $role->name}}" placeholder="Enter Role Name" required>
                                                @error('name')
                                                <div class="invalid-feedback d-block">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="my-3">Assign Project related Permission to Roles</h6>
                                                    <table class="table table-striped mb-0" id="dataTable-1">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <input type="checkbox" class="form-check-input" id="project_checkall">
                                                                </th>
                                                                <th>Module</th>
                                                                <th>Permissions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($modules as $module)
                                                                @php
                                                                    $actions = json_decode($module->actions);
                                                                @endphp
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox" class="form-check-input module-check" data-module="{{ $module->module_name }}">
                                                                    </td>
                                                                    <td>
                                                                        <label>{{ Str::of($module->module_name)->replace('_', ' ')->title() }}</label>

                                                                    </td>
                                                                    <td>
                                                                        <div class="row">
                                                                            @foreach ($actions as $action)
                                                                                <div class="col-md-3 form-check">
                                                                                    @php
                                                                                        $permValue = $action . ' ' . $module->module_name;
                                                                                        $permId = 'perm_' . $module->module_name . '_' . $action;
                                                                                        // Check if the permission is already assigned to the role
                                                                                        $isChecked = in_array($permValue, $role->permissions->pluck('name')->toArray());
                                                                                    @endphp
                                                                                    <input type="checkbox"
                                                                                           class="form-check-input permission-check {{ $module->module_name }}"
                                                                                           name="permissions[]"
                                                                                           value="{{ $permValue }}"
                                                                                           id="{{ $permId }}"
                                                                                           {{ $isChecked ? 'checked' : '' }}>
                                                                                    <label class="form-check-label" for="{{ $permId }}">
                                                                                        {{ ucfirst($action) }}
                                                                                    </label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            @error('permissions')
                                                                <div class="invalid-feedback d-block">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                        </tbody>
                                                        <div class="text-danger mt-2" style="display: none;">
                                                            At least one permission must be selected.
                                                        </div>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> --}}
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- View Modal -->
    </div>
    
    </div>
    </div> <!-- end slimscroll-menu-->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
            <script>
               
                document.getElementById('project_checkall').addEventListener('change', function () {
                    const isChecked = this.checked;
                    document.querySelectorAll('.module-check').forEach(checkbox => {
                        checkbox.checked = isChecked;
                        const module = checkbox.getAttribute('data-module');
                        document.querySelectorAll(`.permission-check.${module}`).forEach(permCheckbox => {
                            permCheckbox.checked = isChecked;
                        });
                    });
                });
        
                // Module-level Select All
                document.querySelectorAll('.module-check').forEach(checkbox => {
                    checkbox.addEventListener('change', function () {
                        const module = this.getAttribute('data-module');
                        const isChecked = this.checked;
                        document.querySelectorAll(`.permission-check.${module}`).forEach(permCheckbox => {
                            permCheckbox.checked = isChecked;
                        });
        
                        // Update header checkbox state
                        const allModulesChecked = Array.from(document.querySelectorAll('.module-check')).every(ch => ch.checked);
                        document.getElementById('project_checkall').checked = allModulesChecked;
                    });
                });
        
                // Individual permission checkboxes
                document.querySelectorAll('.permission-check').forEach(checkbox => {
                    checkbox.addEventListener('change', function () {
                        const module = this.classList[2]; // Third class is the module name (e.g., project, milestone)
                        const moduleCheckbox = document.querySelector(`.module-check[data-module="${module}"]`);
                        const allPermissions = document.querySelectorAll(`.permission-check.${module}`);
                        const allChecked = Array.from(allPermissions).every(ch => ch.checked);
                        moduleCheckbox.checked = allChecked;
        
                        // Update header checkbox state
                        const allModulesChecked = Array.from(document.querySelectorAll('.module-check')).every(ch => ch.checked);
                        document.getElementById('project_checkall').checked = allModulesChecked;
                    });
                });
            </script>
       
@endsection