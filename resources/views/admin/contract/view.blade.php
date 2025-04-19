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
                                <select class="form-control" name="vehicle_type[0][]" required>
                                    <option value="">Select</option>
                                    @foreach($vehicles as $v)
                                        <option value="{{ $v->id }}">{{ $v->vehicle_type }}</option>
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
        </tr>
    </thead>
    <tbody>
        @foreach($contracts as $key => $contract)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $contract->vehicle->vehicle_type ?? 'N/A' }}</td>
                <td>{{ $contract->fromDestination->destination ?? 'N/A' }}</td>
                <td>{{ $contract->toDestination->destination ?? 'N/A' }}</td>
                <td>{{ $contract->rate }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

   </div>
</div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let blockIndex = 1;

    const vehicleOptions = `
        <option value="">Select</option>
        @foreach($vehicles as $v)
            <option value="{{ $v->id }}">{{ $v->vehicle_type }}</option>
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
                    <select class="form-control" name="vehicle_type[${blockId}][]">
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
