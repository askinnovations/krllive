@extends('admin.layouts.app')
@section('content')

<div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Customer</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Customer</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- Customer Listing Page -->
                    <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">🧑‍💼 Customer List</h4>
                                        <p class="card-title-desc">View, edit, or delete customer details below.</p>
                                    </div>
                                    <button class="btn" id="addCustomerBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        <i class="fas fa-plus"></i> Add Customer
                                    </button>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                            <th>#</th>
                                                <th>Customer Name</th>
                                                <th>PAN Number</th>
                                                <th>TAN Number</th>
                                                <!-- <th>GST Numbers</th> -->
                                                <th class="w-25">Location</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr class="customer-row" data-id="1">
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->pan_number }}</td>
                                                <td>{{ $user->tan_number }}</td>
                                                <!-- <td class="w-25">
                                                    <div class="text-wrap">
                                                        @php
                                                            $gstNumbers = json_decode($user->gst_number, true);
                                                        @endphp

                                                        @if (!empty($gstNumbers) && is_array($gstNumbers))
                                                            @foreach ($gstNumbers as $gst)
                                                                <div class="">
                                                                    <strong>GST:</strong> {{ $gst }}
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <p class="text-muted">No GST Available</p>
                                                        @endif
                                                    </div>
                                                </td> -->
                                                <td class="w-25">
                                                    @php
                                                            $addresses = json_decode($user->address, true);
                                                        @endphp

                                                        @if (!empty($addresses) && is_array($addresses))
                                                            @foreach ($addresses as $address)
                                                            <div class="text-wrap">
                                                                <p>
                                                                    <strong>{{ $address['city'] ?? '' }},</strong> 
                                                                    </br>
                                                                    <span>{{ $address['gstin'] ?? '' }},
                                                                    {{ $address['billing_address'] ?? '' }},
                                                                    {{ $address['consignment_address'] ?? '' }}
                                                                    {{ $address['mobile_number'] ?? '' }}
                                                                    {{ $address['email'] ?? '' }}
                                                                    {{ $address['poc'] ?? '' }}</span>
                                                                </p>
                                                            </div>
                                                            @endforeach
                                                        @else
                                                            <p>No Address Available</p>
                                                        @endif
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex  align-items-center gap-2">
                                                        <button class="btn btn-sm btn-light view-btn"><i class="fas fa-eye text-primary"></i></button>
                                                        <button class="btn btn-sm btn-light edit-btn"><i class="fas fa-pen text-warning"></i></button>
                                                        <!-- Delete Button -->
                                                        
                                                        <button class="btn btn-sm btn-light delete-btn" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                                                                <i class="fas fa-trash text-danger"></i>
                                                            </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Details Add Form -->
                    <div class="row add-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4>🧑‍💼 Add Customer Details</h4>
                                        <p>Enter the required details for the customer.</p>
                                    </div>
                                    <button class="btn" id="backToListBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        ⬅ Back to Listing
                                    </button>
                                </div>
                                <form action="{{ route('admin.users.store') }}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Customer Details -->
                                            <div class="col-md-6">
                                                <h5>👤 Customer Information</h5>
                                                <div class="mb-3">
                                                    <label class="form-label">Customer Name</label>
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="Enter customer name">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Pan Number</label>
                                                    <input type="text" name="pan_number" class="form-control"
                                                        placeholder="Enter pan number">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tan Number</label>
                                                    <input type="text" name="tan_number"class="form-control" placeholder="Enter Tan Number">
                                                </div>
                                            </div>

                                            <!-- Address & GST -->
                                            <div class="col-md-6">
                                                <h5>🏠 Location</h5>

                                                <!-- Address Section -->
                                                
                                                <div id="addressContainer">
                                                    <div class="mb-3 address-group">
                                                    
                                                        <input type="text" name="address[0][city]" class="form-control mb-2" placeholder="Location" required>
                                                        <input type="text" name="address[0][gstin]" class="form-control mb-2" placeholder="GSTIN" required>
                                                        <input type="text" name="address[0][billing_address]" class="form-control mb-2" placeholder="Billing Address" required>
                                                        <input type="text" name="address[0][consignment_address]" class="form-control mb-2" placeholder="Consignment Address" required>
                                                        <input type="text" name="address[0][mobile_number]" class="form-control mb-2" placeholder="Mobile Number" required>
                                                        <input type="text" name="address[0][email]" class="form-control mb-2" placeholder="Email" required>
                                                        <input type="text" name="address[0][poc]" class="form-control mb-2" placeholder="Point Of Contact" required>
                                                        <button type="button" class="btn btn-success" onclick="addAddress()">➕ Add More</button>
                                                    </div>
                                                </div>

                                                <!-- GST Section -->
                                                <!-- <label class="form-label">GST</label>
                                                <div id="gstContainer">
                                                    <div class="mb-3 d-flex gst-group">
                                                        
                                                        <input type="text" name="gst_numbers[0]" class="form-control me-2" placeholder="Enter GST number">
                                                    </div>
                                                </div> -->
                                                <!-- Add More GST Button -->
                                                <!-- <button type="button" class="btn btn-success mb-3" onclick="addGST()">➕ Add More GST</button> -->

                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Submit Button -->
                                            <div class="col-12 text-end">
                                                <button type="submit"  class="btn btn-primary">Save Customer Details</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                
                            </div>
                        </div>
                    </div>

                    <!-- View Customer Details Section -->
                    <div class="row view-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4>👤 View Customer Details</h4>
                                        <p>Review the details of the selected customer.</p>
                                    </div>
                                    <button class="btn" id="backToListFromCustomerView"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        ⬅ Back to Listing
                                    </button>
                                </div>
                                <div class="card-body">

                                    <p><strong>Customer Name:</strong> <span id="viewCustomerName"></span></p>
                                    <p><strong>Pan Number :</strong> <span id="viewCustomerPhone"></span></p>
                                    <p><strong>Tan Number :</strong> <span id="viewCustomerEmail"></span></p>
                                   
                                    <p><strong>Address:</strong> <span id="viewCustomerGST"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>




                </div> <!-- container-fluid -->
</div>

            
            <!-- edit -->

            <!-- edit modal -->
             <!-- Edit Customer Modal -->
            <div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCustomerModalLabel">✏ Edit Customer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form id="editCustomerForm" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" id="editCustomerId" name="id">

                                <div class="mb-3">
                                    <label class="form-label">Customer Name</label>
                                    <input type="text" name="name" id="editCustomerName" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">PAN Number</label>
                                    <input type="text" name="pan_number" id="editCustomerPhone" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">TAN Number</label>
                                    <input type="text" name="tan_number" id="editCustomerEmail" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" id="editCustomerAddress" class="form-control"></textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

             <!-- edit modal -->
           
 <!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserLabel">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(function (btn) {
        btn.addEventListener("click", function () {
            let row = this.closest("tr");

            let customerId = row.children[0].innerText.trim();
            let customerName = row.children[1].innerText.trim();
            let panNumber = row.children[2].innerText.trim();
            let tanNumber = row.children[3].innerText.trim();
            let addressData = row.children[4].innerText.trim(); // Now 4th index after removing GST

            document.getElementById("editCustomerId").value = customerId;
            document.getElementById("editCustomerName").value = customerName;
            document.getElementById("editCustomerPhone").value = panNumber;
            document.getElementById("editCustomerEmail").value = tanNumber;

            // Just clean up the "Address: " prefix if present
            let cleanAddress = addressData.replace(/Address:\s*/g, "").trim();
            document.getElementById("editCustomerAddress").value = cleanAddress;

            let updateUrl = "{{ route('admin.users.update', ':id') }}".replace(":id", customerId);
            document.getElementById("editCustomerForm").setAttribute("action", updateUrl);

            let editModal = new bootstrap.Modal(document.getElementById("editCustomerModal"));
            editModal.show();
        });
    });
});
</script>






  <!-- edit -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    // सभी "View" बटनों को सेलेक्ट करें
    document.querySelectorAll(".view-btn").forEach(function (btn) {
        btn.addEventListener("click", function () {
            // जिस Row का View बटन क्लिक हुआ, उसे पकड़ें
            let row = this.closest("tr");

            // डेटा को सही तरीके से उठाएँ
            let customerId = row.children[0].innerText;
            let customerName = row.children[1].innerText;
            let customerPhone = row.children[2].innerText;
            let customerEmail = row.children[3].innerText;
            let customerGST = row.children[4].innerText;
            let customerAddresses = row.children[5].innerHTML; // Address को भी लोड करें

            // View Page में डाटा भरें
            
            document.getElementById("viewCustomerName").innerText = customerName;
            document.getElementById("viewCustomerPhone").innerText = customerPhone;
            document.getElementById("viewCustomerEmail").innerText = customerEmail;
            document.getElementById("viewCustomerGST").innerText = customerGST;
           

            // View Section को दिखाएं और Listing Page को छुपाएँ
            document.querySelector(".listing-form").style.display = "none";
            document.querySelector(".view-form").style.display = "block";
        });
    });

    // "Back to Listing" बटन के लिए Event Listener
    document.getElementById("backToListFromCustomerView").addEventListener("click", function () {
        document.querySelector(".view-form").style.display = "none";
        document.querySelector(".listing-form").style.display = "block";
    });
});
</script>





<script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get references to sections
            const listingForm = document.querySelector(".listing-form");
            const addForm = document.querySelector(".add-form");
            const viewForm = document.querySelector(".view-form");
    
            // Get references to buttons
            const addCustomerBtn = document.getElementById("addCustomerBtn");
            const backToListBtn = document.getElementById("backToListBtn");
            const backToListFromCustomerView = document.getElementById("backToListFromCustomerView");
    
            // Get all view buttons
            const viewButtons = document.querySelectorAll(".view-btn");
    
            // Default: Show only the listing page
            addForm.style.display = "none";
            viewForm.style.display = "none";
    
            // Open Add Customer Form
            addCustomerBtn.addEventListener("click", function () {
                listingForm.style.display = "none";
                addForm.style.display = "block";
            });
    
            // Go Back to Customer Listing from Add Form
            backToListBtn.addEventListener("click", function () {
                addForm.style.display = "none";
                listingForm.style.display = "block";
            });
    
            // Open View Customer Details Page
            viewButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const row = this.closest(".customer-row"); // Get the row
                   
                    document.getElementById("viewCustomerName").textContent = row.children[1].textContent;
                    document.getElementById("viewCustomerPhone").textContent = row.children[2].textContent;
                    document.getElementById("viewCustomerEmail").textContent = row.children[3].textContent;
                    document.getElementById("viewCustomerGST").textContent = row.children[4].textContent;
                   
    
                    listingForm.style.display = "none";
                    viewForm.style.display = "block";
                });
            });
    
            // Go Back to Customer Listing from View Page
            backToListFromCustomerView.addEventListener("click", function () {
                viewForm.style.display = "none";
                listingForm.style.display = "block";
            });
        });
</script>

<script>
    let addressIndex = 1;

    function addAddress() {
        let container = document.getElementById("addressContainer");
        let div = document.createElement("div");
        div.classList.add("mb-3", "address-group");
        div.innerHTML = `
            <input type="text" name="address[${addressIndex}][city]" class="form-control mb-2" placeholder="Location" required>
            <input type="text" name="address[${addressIndex}][gstin]" class="form-control mb-2" placeholder="GSTIN" required>
            <input type="text" name="address[${addressIndex}][billing_address]" class="form-control mb-2" placeholder="Billing Address" required>
            <input type="text" name="address[${addressIndex}][consignment_address]" class="form-control mb-2" placeholder="Consignment Address"required>
            <input type="text" name="address[${addressIndex}][mobile_number]" class="form-control mb-2" placeholder="Mobile Number" required>
            <input type="text" name="address[${addressIndex}][email]" class="form-control mb-2"  placeholder="Email" required>
            <input type="text" name="address[${addressIndex}][poc]" class="form-control mb-2" placeholder="Point Of Contact" required>
            <button type="button" class="btn btn-danger" onclick="removeElement(this)">❌ Remove</button>
        `;
        container.appendChild(div);
        addressIndex++;
    }

    function removeElement(btn) {
        btn.parentElement.remove();
    }

    // ✅ New GST logic
    // let gstIndex = 1; // First GST field is already 0

    // function addGST() {
    //     let container = document.getElementById("gstContainer");
    //     let div = document.createElement("div");
    //     div.classList.add("mb-3", "d-flex", "gst-group");
    //     div.innerHTML = `
    //         <input type="text" name="gst_numbers[${gstIndex}]" class="form-control me-2" placeholder="Enter GST number">
    //         <button type="button" class="btn btn-danger" onclick="removeElement(this)">❌ Remove</button>
    //     `;
    //     container.appendChild(div);
    //     gstIndex++;
    // }

    // function removeElement(btn) {
    //     btn.parentElement.remove();
    // }
</script>




<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function () {
    let deleteId = null;

    // Open Delete Modal & Get ID
    $('.delete-btn').on('click', function () {
        deleteId = $(this).data('id');
    });

    // Confirm Delete
    

    $('#confirmDelete').on('click', function () {
        $.ajax({
            url: `/admin/users/delete/${deleteId}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                alert('Users deleted successfully!');
                location.reload();
            },
            error: function (error) {
                alert('Error deleting user.');
            }
        });
    });
});
</script>


 <!-- delete -->

@endsection
