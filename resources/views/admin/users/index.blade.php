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
                                                <th>Phone Number</th>
                                                <th>Email</th>
                                                <th>GST Numbers</th>
                                                <th>Addresses</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr class="customer-row" data-id="1">
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->mobile_number }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->gst_number }}</td>
                                                <td>
                                                    @php
                                                            $addresses = json_decode($user->address, true);
                                                        @endphp

                                                        @if (!empty($addresses) && is_array($addresses))
                                                            @foreach ($addresses as $address)
                                                                <p>
                                                                    <strong>Address:</strong> 
                                                                    {{ $address['full_address'] ?? '' }},
                                                                    {{ $address['city'] ?? '' }},
                                                                    {{ $address['pincode'] ?? '' }}
                                                                </p>
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
                                                    <label class="form-label">Phone Number</label>
                                                    <input type="text" name="mobile_number" class="form-control"
                                                        placeholder="Enter phone number">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email"class="form-control" placeholder="Enter email">
                                                </div>
                                            </div>

                                            <!-- Address & GST -->
                                            <div class="col-md-6">
                                                <h5>🏠 Address & GST</h5>

                                                <!-- Address Section -->
                                                <label class="form-label">Address</label>
                                                <div id="addressContainer">
                                                    <div class="mb-3 address-group">
                                                        <input type="text" name="address[0][full_address]" class="form-control mb-2" placeholder="Full Address" required>
                                                        <input type="text" name="address[0][city]" class="form-control mb-2" placeholder="City" required>
                                                        <input type="text" name="address[0][pincode]" class="form-control mb-2" placeholder="Pincode" required>
                                                        <button type="button" class="btn btn-success" onclick="addAddress()">➕ Add More</button>
                                                    </div>
                                                </div>

                                                <!-- GST Section -->
                                                <label class="form-label">GST</label>
                                                <div id="gstContainer">
                                                    <div class="mb-3 d-flex">
                                                    <input type="text" name="gst_number"class="form-control" placeholder="Enter GST number">
                                                    </div>
                                                </div>
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
                                    <p><strong>Customer ID:</strong> <span id="viewCustomerId"></span></p>
                                    <p><strong>Customer Name:</strong> <span id="viewCustomerName"></span></p>
                                    <p><strong>Phone Number:</strong> <span id="viewCustomerPhone"></span></p>
                                    <p><strong>Email:</strong> <span id="viewCustomerEmail"></span></p>
                                    <p><strong>Addresses:</strong> <span id="viewCustomerAddresses"></span></p>
                                    <p><strong>GST Numbers:</strong> <span id="viewCustomerGST"></span></p>
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
                            @method('PUT') <!-- Laravel PUT Method for Update -->

                            <div class="modal-body">
                                <input type="hidden" id="editCustomerId" name="id">

                                <div class="mb-3">
                                    <label class="form-label">Customer Name</label>
                                    <input type="text" name="name" id="editCustomerName" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="mobile_number" id="editCustomerPhone" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" id="editCustomerEmail" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">GST Number</label>
                                    <input type="text" name="gst_number" id="editCustomerGST" class="form-control">
                                </div>

                                <!-- 📌 Address Section (Now Editable) -->
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" id="editCustomerAddress" class="form-control">
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
              <!-- delete -->
 <!-- Delete Category Modal -->
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
            let customerPhone = row.children[2].innerText.trim();
            let customerEmail = row.children[3].innerText.trim();
            let customerGST = row.children[4].innerText.trim();
            let customerAddress = row.children[5].innerText.trim(); 

            document.getElementById("editCustomerId").value = customerId;
            document.getElementById("editCustomerName").value = customerName;
            document.getElementById("editCustomerPhone").value = customerPhone;
            document.getElementById("editCustomerEmail").value = customerEmail;
            document.getElementById("editCustomerGST").value = customerGST;

            // ✅ Address JSON को Parse करके Input Field में Show करें
            let addressInput = document.getElementById("editCustomerAddress");
            try {
                let parsedAddress = JSON.parse(customerAddress);
                addressInput.value = parsedAddress[0]?.full_address ?? customerAddress;
            } catch (error) {
                console.error("Address JSON Parse Error:", error);
                addressInput.value = customerAddress; 
            }

            // ✅ Form Action URL Update
            let updateUrl = "{{ route('admin.users.update', ':id') }}".replace(":id", customerId);
            document.getElementById("editCustomerForm").setAttribute("action", updateUrl);

            // ✅ Bootstrap Modal Show
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
            document.getElementById("viewCustomerId").innerText = customerId;
            document.getElementById("viewCustomerName").innerText = customerName;
            document.getElementById("viewCustomerPhone").innerText = customerPhone;
            document.getElementById("viewCustomerEmail").innerText = customerEmail;
            document.getElementById("viewCustomerGST").innerText = customerGST;
            document.getElementById("viewCustomerAddresses").innerHTML = customerAddresses;

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
                    document.getElementById("viewCustomerId").textContent = row.dataset.id;
                    document.getElementById("viewCustomerName").textContent = row.children[1].textContent;
                    document.getElementById("viewCustomerPhone").textContent = row.children[2].textContent;
                    document.getElementById("viewCustomerEmail").textContent = row.children[3].textContent;
                    document.getElementById("viewCustomerGST").textContent = row.children[4].textContent;
                    document.getElementById("viewCustomerAddresses").textContent = row.children[5].textContent;
    
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
            <input type="text" name="address[${addressIndex}][full_address]" class="form-control mb-2" placeholder="Full Address" required>
            <input type="text" name="address[${addressIndex}][city]" class="form-control mb-2" placeholder="City" required>
            <input type="text" name="address[${addressIndex}][pincode]" class="form-control mb-2" placeholder="Pincode" required>
            <button type="button" class="btn btn-danger" onclick="removeElement(this)">❌ Remove</button>
        `;
        container.appendChild(div);
        addressIndex++;
    }

    function removeElement(btn) {
        btn.parentElement.remove();
    }
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
