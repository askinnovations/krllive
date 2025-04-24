@extends('admin.layouts.app')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <!-- View Vehicle Details Page -->
      <div class="view-vehicle-form">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
               <div>
                  <h4> Contract Details View</h4>
                  <p class="mb-0">View details for the Contract.</p>
               </div>
               <a href="{{ route('admin.contract.index') }}" class="btn" id="backToListBtn"
                  style="background-color: #ca2639; color: white; border: none;">
               ⬅ Back to Listing
               </a>
            </div>
           
            <form method="POST" action="{{ route('admin.contract.store') }}">
               @csrf
               <input type="hidden" name="user_id" value="{{ $user->id }}">
               <div class="container mt-4">
                  <div id="contract-wrapper">
                     <div class="contract-section border p-3 mb-4">
                        <div class="row mb-3">
                           <div class="col-md-5">
                            
                              <label>From</label>
                              <select class="form-control" name="from[]" required>
                                 <option value="">Select</option>
                                 @foreach($destinations as $d)
                                 <option value="{{ $d->id }}">{{ $d->destination }}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="col-md-5">
                              <label>To</label>
                              <select class="form-control" name="to[]" required>
                                 <option value="">Select</option>
                                 @foreach($destinations as $d)
                                 <option value="{{ $d->id }}">{{ $d->destination }}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="vehicle-rate-wrapper">
                           <div class="row mb-2 vehicle-rate-row">
                              <div class="col-md-5">
                                 <label>Vehicle Type</label>
                                 <select class="form-control" name="vehicletype[0][]" required>
                                    <option value="">Select</option>
                                    @foreach($vehicles as $v)
                                    <option value="{{ $v->id }}">{{ $v->vehicletype }}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="col-md-5">
                                 <label>Rate</label>
                                 <input type="number" class="form-control" name="rate[0][]" placeholder="Enter Rate" required>
                              </div>
                              <div class="col-md-2 d-flex align-items-end">
                                 <button type="button" class="btn btn-success add-row me-2">+</button>
                                 <!-- <button type="button" class="btn btn-danger remove-row">−</button> -->
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <button type="button" class="btn add-section" style="background-color: #ca2639; color: white; border: none;">+ Add New From-To Block</button>
                  <button type="submit" class="btn" style="background-color: #ca2639; color: white; border: none;">Submit</button>
               </div>
            </form>
         </div>
      </div>
      <table class="table table-bordered dt-responsive nowrap w-100">
         <thead>
            <tr>
               <th>S.No</th>
               <th>Vehicle Type</th>
               <th>From</th>
               <th>To</th>
               <th>Rate</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            @foreach($contracts as $key => $contract)
            <tr>
               <td>{{ $key + 1 }}</td>
               <td>{{ $contract->vehicle->vehicletype ?? 'N/A' }}</td>
               <td>{{ $contract->fromDestination->destination ?? 'N/A' }}</td>
               <td>{{ $contract->toDestination->destination ?? 'N/A' }}</td>
               <td>{{ $contract->rate }}</td>
               <td>
               <button class="btn btn-sm btn-warning edit-btn"
                    data-id="{{ $contract->id }}"
                    data-vehicletype="{{ $contract->type_id }}"
                    data-from="{{ $contract->from_destination_id }}"
                    data-to="{{ $contract->to_destination_id }}"
                    data-rate="{{ $contract->rate }}">
                    <i class="fas fa-pen"></i>
                </button>
                <button class="btn btn-sm btn-light delete-btn"><a
                                                        href="{{ route('admin.contract.delete', $contract->id) }}"  onclick="return confirm('Are you sure you want to delete this tyre record?')"> <i
                                                            class="fas fa-trash text-danger"></i>
                                                    </a>
                                                </button>

                   

               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
</div>

<!-- Modal -->
<!-- Edit Modal -->
<div class="modal fade" id="updateContractModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="editForm">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Contract</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editid" name="id">

          <div class="mb-3">
            <label>Vehicle Type</label>
            <select id="editVehicleType" name="vehicletype" class="form-select" required>
              <option value="">Select</option>
              @foreach($vehicles as $v)
                <option value="{{ $v->id }}">{{ $v->vehicletype }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label>From Destination</label>
            <select id="editFrom" name="from" class="form-select" required>
              <option value="">Select</option>
              @foreach($destinations as $d)
                <option value="{{ $d->id }}">{{ $d->destination }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label>To Destination</label>
            <select id="editTo" name="to" class="form-select" required>
              <option value="">Select</option>
              @foreach($destinations as $d)
                <option value="{{ $d->id }}">{{ $d->destination }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label>Rate</label>
            <input type="number" id="editRate" name="rate" class="form-control" step="0.01" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        document.addEventListener("DOMContentLoaded", function () {
            function getHealthBadgeClass(health) {
                switch (health) {
                    case "New":
                        return "bg-success text-white"; // Green
                    case "Good":
                        return "bg-primary text-white"; // Blue
                    case "Worn Out":
                        return "bg-warning text-dark"; // Yellow
                    case "Needs Replacement":
                        return "bg-danger text-white"; // Red
                    default:
                        return "bg-secondary text-white"; // Gray (default)
                }
            }
            // Attach existing buttons on page load
            document.querySelectorAll(".view-btn").forEach(attachViewEvent);
            document.querySelectorAll(".delete-btn").forEach(attachDeleteEvent);
        });
           
       
    </script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  document.body.addEventListener('click', e => {
    const btn = e.target.closest('.edit-btn');
    if (!btn) return;

    const data = {
      id: btn.dataset.id,
      vehicletype: btn.dataset.vehicletype,
      from: btn.dataset.from,
      to: btn.dataset.to,
      rate: btn.dataset.rate
    };

    // Fill the form
    document.getElementById('editid').value              = data.id;
    document.getElementById('editVehicleType').value     = data.vehicletype;
    document.getElementById('editFrom').value            = data.from;
    document.getElementById('editTo').value              = data.to;
    document.getElementById('editRate').value            = data.rate;

    // Set the action URL
    document.getElementById('editForm').action = `/admin/contract/update/${data.id}`;

    // Show the modal
    new bootstrap.Modal(document.getElementById('updateContractModal')).show();
  });
});
</script>



<script>
   document.addEventListener("DOMContentLoaded", function () {
       let blockIndex = 1;
   
       const vehicleOptions = `
           <option value="">Select</option>
           @foreach($vehicles as $v)
               <option value="{{ $v->id }}">{{ $v->vehicletype }}</option>
           @endforeach
       `;
   
       const fromToOptions = `
           <option value="">Select</option>
           @foreach($destinations as $d)
               <option value="{{ $d->id }}">{{ $d->destination }}</option>
           @endforeach
       `;
   
       function getVehicleRateRowHtml(blockId, isFirstRow = false) {
           return `
               <div class="row mb-2 vehicle-rate-row">
                   <div class="col-md-5">
                       <select class="form-control" name="vehicletype[${blockId}][]">
                           ${vehicleOptions}
                       </select>
                   </div>
                   <div class="col-md-5">
                       <input type="number" class="form-control" name="rate[${blockId}][]" placeholder="Enter Rate">
                   </div>
                   <div class="col-md-2 d-flex align-items-end">
                       ${isFirstRow ? `
                           <button type="button" class="btn btn-success add-row me-2">+</button>
                       ` : ''}
                       <button type="button" class="btn btn-danger remove-row">−</button>
                   </div>
               </div>`;
       }
   
       function getContractSectionHtml(index) {
           return `
               <div class="contract-section border p-3 mb-4">
                   <div class="row mb-3">
                       <div class="col-md-5">
                           <label>From</label>
                           <select class="form-control" name="from[]">
                               ${fromToOptions}
                           </select>
                       </div>
                       <div class="col-md-5">
                           <label>To</label>
                           <select class="form-control" name="to[]">
                               ${fromToOptions}
                           </select>
                       </div>
                       <div class="col-md-2 d-flex align-items-end">
                           <button type="button" class="btn btn-danger remove-section">Remove Block</button>
                       </div>
                   </div>
                   <div class="vehicle-rate-wrapper">
                       ${getVehicleRateRowHtml(index, true)}
                   </div>
               </div>`;
       }
   
       document.body.addEventListener("click", function (e) {
           if (e.target.classList.contains("add-section")) {
               document.getElementById("contract-wrapper").insertAdjacentHTML("beforeend", getContractSectionHtml(blockIndex));
               blockIndex++;
           }
   
           if (e.target.classList.contains("remove-section")) {
               e.target.closest(".contract-section").remove();
           }
   
           if (e.target.classList.contains("add-row")) {
               const section = e.target.closest(".contract-section");
               const wrapper = section.querySelector(".vehicle-rate-wrapper");
               const blockId = Array.from(document.querySelectorAll('.contract-section')).indexOf(section);
               wrapper.insertAdjacentHTML("beforeend", getVehicleRateRowHtml(blockId, false));
           }
   
           if (e.target.classList.contains("remove-row")) {
               const allRows = e.target.closest(".vehicle-rate-wrapper").querySelectorAll(".vehicle-rate-row");
               if (allRows.length > 1) {
                   e.target.closest(".vehicle-rate-row").remove();
               }
           }
       });
   });
</script>