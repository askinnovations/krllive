@extends('admin.layouts.app')
@section('title', 'Attendance | KRL')

@section('content')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="page-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-2">
            <div class="col-md-6">
                <h4 class="mb-sm-0 font-size-18">Attendance</h4>
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
            </div>
            
              
            <div class="col-md-6 text-end">
                <!-- Bulk Status Update Form -->
                <form id="bulkAttendanceForm" method="POST" action="{{ route('admin.attendance.update') }}">
                    @csrf
                    <div class="input-group">
                        <select name="status" class="form-select form-select-sm me-2" id="bulkStatusSelect" required style="width: 200px;">
                            <option value="">Select Status </option>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="halfday">Halfday</option>
                        </select>
                
                        <input type="text" name="remark" id="bulkRemark" class="form-control form-control-sm me-2 d-none" placeholder="Enter remark">
                
                        <input type="hidden" name="date" value="{{ now()->toDateString() }}">
                
                        <button type="submit" class="btn btn-sm btn-danger">Apply to Selected</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-body">
                <div style="position: relative; display: inline-block;">
                    <form style="position: relative; max-width: 300px;" action="{{ route('admin.attendance.index') }}">
                        <input type="text" id="calendarInput" class="form-control" >
                        <span id="calendarIcon" style="position: absolute; right: 40px; top: 8px; cursor: pointer;">
                            📅
                        </span>
                        <button type="submit" id="searchBtn" style="position: absolute; right: 5px; top: 5px; border: none; background: none;">
                            🔍
                        </button>
                    </form>
                   
                    
                  </div>
                <table  id=""  class="table table-bordered dt-responsive nowrap w-100">
                    {{-- <input type="text" id="customSearch" placeholder="Search by name..." class="form-control mb-3" style="width: 300px; text-align: left; "> --}}

                    <thead>
                        <tr>
                           
                            <th><input type="checkbox" id="selectAll"> S.No</th>
                            <th>Employee Id</th>
                            <th>Full Name</th>
                            <th>Status</th>
                            <th>Remark</th>
                            <th>date</th>
                            <th >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                        <tr>
                            @php
                                $todayAttendance = $employee->attendances->where('date', now()->toDateString())->first();
                            @endphp
                            
                            <td>   <input type="checkbox" name="employee_ids[]" class="employee-checkbox" form="bulkAttendanceForm" value="{{ $employee->id }}">
                                {{ $loop->iteration }} </td>
                                <td>EMP##{{ $employee->id }}</td>
                            <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                            @php
                                $status = $todayAttendance->status ?? null;
                            @endphp
                            <td>   @if ($status === 'present')
                                <span class="badge bg-success">Present</span>
                            @elseif ($status === 'absent')
                                <span class="badge bg-danger">Absent</span>
                            @elseif ($status === 'halfday')
                                <span class="badge bg-primary">Halfday</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif</td>
                            <td>  {{ $todayAttendance->remark ?? '-' }}-</td>
                            <td>  {{ $todayAttendance->date ?? '-' }}-</td>
                            <td>
                                <a href="#"><button class="btn btn-sm btn-light"><i class="fas fa-eye text-primary"></i></button></a>
                                <a href="#"><button class="btn btn-sm btn-light"><i class="fas fa-pen text-warning"></i></button></a>
                                <a href="#"><button class="btn btn-sm btn-light"><i class="fas fa-trash text-danger"></i></button></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
$(function() {
    $("#calendarInput").datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Initialize flatpickr with today's date as default
    const calendar = flatpickr("#calendarInput", {
      defaultDate: new Date(), // Set today as default
      dateFormat: "Y-m-d", // Optional format
      clickOpens: false // Disable default open on input click
    });
  
    // Trigger calendar when icon is clicked
    document.getElementById("calendarIcon").addEventListener("click", function () {
      calendar.open();
    });
  </script>
  
<script>
    // When the #selectAll checkbox is clicked
    document.getElementById('selectAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.employee-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
<script>
    $(document).ready(function () {
        $('#bulkStatusSelect').on('change', function () {
            const selected = $(this).val();
            const remarkInput = $('#bulkRemark');

            if (selected) {
                remarkInput.removeClass('d-none'); // show on any status
            } else {
                remarkInput.addClass('d-none').val(''); // hide if no status selected
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        var table = $('.table').DataTable(); // Initialize the table

        // Custom search input trigger
        $('#customSearch').on('keyup', function() {
            table.search(this.value).draw(); // Trigger DataTable's search
        });

        // Select All Checkbox Logic
        $('#selectAll').on('change', function () {
            $('.employee-checkbox').prop('checked', $(this).is(':checked'));
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection


