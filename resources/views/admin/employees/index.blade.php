@extends('admin.layouts.app')
@section('title', 'Employees | KRL')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Employees</h4>
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
                                <li class="breadcrumb-item active">Employees</li>
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

                                <h4 class="card-title">🛞 Employees Listing</h4>
                                <p class="card-title-desc">
                                    View, edit, or delete tyre details below. This table supports search,
                                    sorting, and pagination via DataTables.
                                </p>
                            </div>
                            <a class="btn" href="{{ route('admin.employees.create') }}" id="addVehicleBtn"
                                style="background-color: #ca2639; color: white; border: none;">
                                <i class="fas fa-plus"></i> Add Employee
                            </a>

                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Full Name</th>
                                        <th>Phone Number</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>join Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($employees as $employee)


                                        <tr>
                                            <td>{{ $loop->iteration  }}</td>
                                            <td>{{ $employee->first_name}} {{ $employee->last_name}}</td>
                                            <td>{{ $employee->phone_number}}</td>
                                            <td>{{ $employee->designation}}</td>
                                            <td>{{ $employee->department}}</td>
                                            <td>{{ $employee->date_of_joining}}</td>


                                            <td>
                                                <a href="{{ route('admin.employees.task', $employee->id) }}"> <button
                                                    class="btn btn-light btn-sm edit-btn">
                                                    <i class="fas fa-question-circle text-primary"></i>
                                                </button></a>
                                                <a href="{{ route('admin.employees.show', $employee->id) }}"> <button
                                                        class="btn btn-light btn-sm edit-btn">
                                                        <i class="fas fa-eye text-primary"></i>
                                                    </button></a>

                                                <a href="{{ route('admin.employees.edit', $employee->id) }}"> <button
                                                        class="btn btn-light btn-sm edit-btn">
                                                        <i class="fas fa-pen text-warning"></i>
                                                    </button></a>
                                                <button class="btn btn-sm btn-light delete-btn"><a
                                                        href="{{ route('admin.employees.delete', $employee->id) }}">
                                                        <i class="fas fa-trash text-danger"></i></a>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- View Modal -->
            <div id="viewModal" class="modal fade" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">🛞 Employee Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>👤 First Name:</strong> <span id="viewFirstName"></span></p>
                            <p><strong>👤 Last Name:</strong> <span id="viewLastName"></span></p>
                            <p><strong>📧 Email:</strong> <span id="viewEmail"></span></p>
                            <p><strong>📞 Contact Number:</strong> <span id="viewPhoneNumber"></span></p>
                            <p><strong>📱 Emergency Contact:</strong> <span id="viewEmergencyContact"></span></p>
                            <p><strong>🏠 Address:</strong> <span id="viewAddress"></span></p>
                            <p><strong>🌍 State:</strong> <span id="viewState"></span></p>
                            <p><strong>📮 Postal Code:</strong> <span id="viewPinCode"></span></p>
                            <p><strong>🆔 Aadhaar Number:</strong> <span id="viewAadhaar"></span></p>
                            <p><strong>💳 PAN Number:</strong> <span id="viewPAN"></span></p>
                            <p><strong>🏦 Account Number:</strong> <span id="viewAccountNumber"></span></p>
                            <p><strong>🏦 IFSC Code:</strong> <span id="viewIFSC"></span></p>
                            <p><strong>💼 Designation:</strong> <span id="viewDesignation"></span></p>
                            <p><strong>🏢 Department:</strong> <span id="viewDepartment"></span></p>
                            <p><strong>📅 Date of Joining:</strong> <span id="viewDOJ"></span></p>
                            <p><strong>📌 Status:</strong> <span id="viewStatus"></span></p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>




        </div>
        <!-- End Page-content -->



    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->






    </div> <!-- end slimscroll-menu-->
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->

    <script>
        function viewEmployeeData(row) {

            let button = row.querySelector(".viewEmployee");

            document.getElementById("viewFirstName").textContent = button.dataset.first_name;
            document.getElementById("viewLastName").textContent = button.dataset.last_name;
            document.getElementById("viewEmail").textContent = button.dataset.email;
            document.getElementById("viewPhoneNumber").textContent = button.dataset.phone_number;
            document.getElementById("viewEmergencyContact").textContent = button.dataset.emergency_contact_number;
            document.getElementById("viewAddress").textContent = button.dataset.address;
            document.getElementById("viewState").textContent = button.dataset.state;
            document.getElementById("viewPinCode").textContent = button.dataset.pin_code;
            document.getElementById("viewAadhaar").textContent = button.dataset.aadhaar_number;
            document.getElementById("viewPAN").textContent = button.dataset.pan_number;
            document.getElementById("viewAccountNumber").textContent = button.dataset.bank_account_number;
            document.getElementById("viewIFSC").textContent = button.dataset.ifsc_code;
            document.getElementById("viewDesignation").textContent = button.dataset.designation;
            document.getElementById("viewDepartment").textContent = button.dataset.department;
            document.getElementById("viewDOJ").textContent = button.dataset.date_of_joining;
            document.getElementById("viewStatus").textContent = button.dataset.status;

            // Show the modal
            let myModal = new bootstrap.Modal(document.getElementById('employeeViewModal'));
            myModal.show();
        }

    </script>
    <script>
        // Function to attach delete event



        // Attach existing buttons on page load
        document.querySelectorAll(".view-btn").forEach(attachViewEvent);
        document.querySelectorAll(".delete-btn").forEach(attachDeleteEvent);



        // Handle saving tyre
        document.getElementById("saveTyre").addEventListener("click", function () {
            let company = document.getElementById("inputCompany").value;
            let model = document.getElementById("inputModel").value;
            let tyreNumber = document.getElementById("inputTyreNumber").value;
            let description = document.getElementById("inputDescription").value;
            let format = document.getElementById("inputFormat").value;
            let health = document.getElementById("inputHealth").value;

            if (company && model && tyreNumber) {
                let table = document.getElementById("datatable").getElementsByTagName("tbody")[0];
                let newRow = table.insertRow();

                let badgeClass = getHealthBadgeClass(health);

                // Attach events to new buttons
                attachViewEvent(newRow.querySelector(".view-btn"));
                attachDeleteEvent(newRow.querySelector(".delete-btn"));

                // Clear input fields
                document.getElementById("inputCompany").value = "";
                document.getElementById("inputModel").value = "";
                document.getElementById("inputTyreNumber").value = "";
                document.getElementById("inputDescription").value = "";
                document.getElementById("inputFormat").value = "";
                document.getElementById("inputHealth").value = "Select health status";

                // Hide the modal
                let modal = bootstrap.Modal.getInstance(document.getElementById("addEmployeeModal"));
                modal.hide();
            } else {
                // alert("Please fill all required fields.");
            }
        });

    </script>
@endsection