@extends('admin.layouts.app')
@section('title', 'Task Management | KRL')
<style>
    .custom-modal-width {
        max-width: 400px;
    }
    .calendar-icon-input {
        position: relative;
    }

    .calendar-icon-input input[type="date"] {
        padding-left: 2.5rem;
    }

    .calendar-icon-input::before {
        content: "📅";
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        font-size: 1.2rem;
        color: #555;
    }

    #filterTasks {
        font-size: 1.2rem;
        padding: 0.4rem 1rem;
    }



</style>
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Task Management</h4>
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
                                <li class="breadcrumb-item active">Task Management</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <button class="btn" id="addTaskBtn"
            style="background-color: #ca2639; color: white; border: none;"
            data-bs-toggle="modal" data-bs-target="#addTaskModal">
            <i class="fas fa-plus"></i> Add Task
        </button>
            <!-- end page title -->
           <!-- Tabs for Table Selection -->
<ul class="nav nav-tabs mb-3" id="taskTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="table1-tab" data-bs-toggle="tab" data-bs-target="#table1" type="button" role="tab">Table 1</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="table2-tab" data-bs-toggle="tab" data-bs-target="#table2" type="button" role="tab">Table 2</button>
    </li>
</ul>

<div class="tab-content" id="taskTabsContent">
    <!-- Table 1 -->
    <div class="tab-pane fade show active" id="table1" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">🛞 Table 1 - Task Management</h4>
            </div>
            <div class="card-body">
                <table id="datatable1" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Task ID</th>
                            <th>Assign Task</th>
                            <th>Description</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Task Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($today_tasks as $index => $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>Tsk##{{ $task->id }}</td>
                                @php
                            $employee = App\Models\Employee::find($task->assigned_to);
                                @endphp
                                <td>{{$employee->first_name . ' ' . $employee->last_name }}</td>

                                <td>{{ $task->description }}</td>
                                <td>
                                    @if($task->high_priority)
                                        <span class="badge bg-danger">High</span>
                                    @else
                                        <span class="badge bg-secondary">Normal</span>
                                    @endif
                                </td>
                                <td> <a href="{{ route('admin.task_management.task_status', $task->id) }}">
                                    <button class="btn btn-sm {{ $task->status === 'close' ? 'btn-danger' : 'btn-secondary' }}">
                                        {{ $task->status === 'close' ? 'Open' : 'Close' }}
                                    </button>
                                </a></td>
                                <td>{{ \Carbon\Carbon::parse($task->date)->format('Y-m-d') }}</td>
                                <td>
                                 <button class="btn btn-sm btn-light view-btn"><i class="fas fa-eye text-primary"></i></button>
                                <button class="btn btn-light  edit-btn" data-bs-toggle="modal" data-bs-target="#editTaskModal"
                                data-id="{{ $task->id }}"
                                data-assigned_to="{{ $task->assigned_to }}"
                                data-description="{{ $task->description }}"
                                data-high_priority="{{ $task->high_priority }}"
                                data-date="{{ $task->date }}">
                                <i class="fas fa-pen text-warning"></i>
                                </button>
                        <a href="{{ route('admin.task_management.delete',$task->id) }}"  >  <button class="btn btn-sm btn-light delete-btn"><i class="fas fa-trash text-danger"></i></button></a>

                                    {{-- <button class="btn btn-sm btn-light delete-btn"><i class="fas fa-trash text-danger"></i></button> --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No task found for today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>

    <!-- Table 2 -->
    <div class="tab-pane fade" id="table2" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">🛞 Table 2  Tasks</h4>
                
                <div class="row mb-3">
                    <div class="col calendar-icon-input ">
                        <input type="date" id="selected_date" class="form-control" name="date" >
                    </div>
                    <div class="col-auto d-flex align-items-center">
                        <button type="button" name="submit" class="btn btn-primary" id="filterTasks" title="Search">
                            🔍
                        </button>
                    </div>
                </div>

<!-- Task Results -->

            </div>
            <div class="card-body">
                <table id="datatable2" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Task ID</th>
                            <th>Assign Task</th>
                            <th>Description</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Task Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="taskBody">
                        @forelse ($other_days_tasks as $index => $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>Tsk##{{ $task->id }}</td>
                            @php
                            $employee = App\Models\Employee::find($task->assigned_to);
                                @endphp
                                <td>{{$employee->first_name . ' ' . $employee->last_name }}</td>
                            <td>{{ $task->description }}</td>
                            <td>
                                @if($task->high_priority)
                                    <span class="badge bg-danger">High</span>
                                @else
                                    <span class="badge bg-secondary">Normal</span>
                                @endif
                            </td>
                            <td> <a href="{{ route('admin.task_management.task_status', $task->id) }}">
                                <button class="btn btn-sm {{ $task->status === 'close' ? 'btn-danger' : 'btn-secondary' }}">
                                    {{ $task->status === 'close' ? 'Open' : 'Close' }}
                                </button>
                            </a></td>

                            <td>{{ \Carbon\Carbon::parse($task->date)->format('Y-m-d') }}</td>
                            <td>
                                <button class="btn  btn-light view-btn"><i class="fas fa-eye text-primary"></i></button>
                                <button class="btn btn-light edit-btn" data-bs-toggle="modal" data-bs-target="#editTaskModal"
                                    data-id="{{ $task->id }}"
                                    data-assigned_to="{{ $task->assigned_to }}"
                                    data-description="{{ $task->description }}"
                                    data-high_priority="{{ $task->high_priority }}"
                                    data-date="{{ $task->date }}">
                                    <i class="fas fa-pen text-warning"></i>
                                </button>
                                <a href="{{ route('admin.task_management.delete', $task->id) }}">
                                    <button class="btn btn-sm btn-light delete-btn"><i class="fas fa-trash text-danger"></i></button>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No tasks found for this date.</td>
                        </tr>
                        @endforelse
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
   <!-- View Modal -->
   <div id="addTaskModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">📋Add Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.task_management.store') }}" method="POST" id="addTaskForm">
                    @csrf
                    <div class="row">

                        <!-- Assign To -->
                        <div class="mb-3">
                            <label class="form-label">👨‍🔧 Assign To</label>
                            <select class="form-control @error('assigned_to') is-invalid @enderror" name="assigned_to" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('assigned_to') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Task Description -->
                        <div class="mb-3">
                            <label class="form-label">📝 Task Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- High Priority Toggle -->
                        <div class="mb-3">
                            <label class="form-label d-block">⚠️ High Priority</label>
                            <div class="form-check form-switch">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    role="switch" 
                                    id="highPriority" 
                                    name="high_priority" 
                                    style="width: 3rem; height: 1.5rem;" 
                                    {{ old('high_priority') ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="highPriority" style="font-size: 1.1rem;"></label>
                            </div>
                        </div>

                        <!-- Due Date -->
                        <input type="date" 
                        class="form-control @error('date') is-invalid @enderror"
                        name="date" 
                        value="{{ old('date', date('Y-m-d')) }}" 
                        required>

                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary mt-2">Save Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- edit model --}}
<div id="editTaskModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">✏️ Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editTaskForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="task_id" id="edit_task_id">

                    <!-- Assign To -->
                    <div class="mb-3">
                        <label class="form-label">👨‍🔧 Assign To</label>
                        <select class="form-control" name="assigned_to" id="edit_assigned_to" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">  {{ $employee->first_name }} {{ $employee->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">📝 Task Description</label>
                        <textarea class="form-control" name="description" id="edit_description" rows="3" required></textarea>
                    </div>

                    <!-- High Priority Toggle -->
                    <div class="mb-3">
                        <label class="form-label d-block">⚠️ High Priority</label>
                        <div class="form-check form-switch">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                role="switch" 
                                id="edit_high_priority" 
                                name="high_priority" 
                                style="width: 3rem; height: 1.5rem;">
                            <label class="form-check-label ms-2" for="edit_high_priority" style="font-size: 1.1rem;"></label>
                        </div>
                    </div>

                    <!-- Due Date -->
                    <div class="mb-3">
                        <label class="form-label">📅 Due Date</label>
                        <input type="date" class="form-control" name="date" id="edit_date" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Update Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    </div>
    
    </div>
    </div> <!-- end slimscroll-menu-->
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#filterTasks').click(function () {
                var selectedDate = $('#selected_date').val();
    
                if (!selectedDate) {
                    alert('Please select a date');
                    return;
                }
    
                $.ajax({
                    url: '{{ route('admin.task_management.searchByDate') }}',
                    method: 'GET',
                    data: { date: selectedDate },
                    success: function (response) {
                        if (response.success) {
                            let rowsHtml = '';
    
                            $.each(response.tasks, function (index, task) {
                                const employee = task.assigned_employee;
                                const employeeName = employee 
                                    ? `${employee.first_name ?? 'N/A'} ${employee.last_name ?? ''}` 
                                    : 'N/A';
    
                                const priorityBadge = task.high_priority 
                                    ? '<span class="badge bg-danger">High</span>' 
                                    : '<span class="badge bg-secondary">Normal</span>';
    
                                const statusButton = `
                                    <a href="/admin/task_management/task_status/${task.id}">
                                        <button class="btn btn-sm ${task.status === 'close' ? 'btn-danger' : 'btn-secondary'}">
                                            ${task.status === 'close' ? 'Open' : 'Close'}
                                        </button>
                                    </a>
                                `;
    
                                rowsHtml += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>Tsk##${task.id}</td>
                                        <td>${employeeName}</td>
                                        <td>${task.description ?? 'N/A'}</td>
                                        <td>${priorityBadge}</td>
                                        <td>${statusButton}</td>
                                        <td>${task.date}</td>
                                        <td>
                                            <button class="btn btn-sm btn-light view-btn">
                                                <i class="fas fa-eye text-primary"></i>
                                            </button>
                                            <button class="btn btn-light edit-btn" data-bs-toggle="modal" data-bs-target="#editTaskModal"
                                                data-id="${task.id}"
                                                data-assigned_to="${task.assigned_to}"
                                                data-description="${task.description}"
                                                data-high_priority="${task.high_priority}"
                                                data-status="${task.status}"
                                                data-date="${task.date}">
                                                <i class="fas fa-pen text-warning"></i>
                                            </button>
                                            <a href="/admin/task_management/delete/${task.id}">
                                                <button class="btn btn-sm btn-light delete-btn">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                `;
                            });
    
                            $('#taskBody').html(rowsHtml);
                        } else {
                            $('#taskBody').html(`
                                <tr>
                                    <td colspan="8" class="text-center text-danger">No tasks found for this date.</td>
                                </tr>
                            `);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error: ", error);
                        alert('Something went wrong while fetching tasks.');
                    }
                });
            });
        });
    </script>
    
    
    <script>
        $(document).ready(function () {
            $('#datatable1').DataTable();
            $('#datatable2').DataTable();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#addTaskAutopartBtn').click(function () {
                const partRow = `
                    <div class="row mb-2 autopart-item">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Part Name">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Part ID">
                        </div>
                        <div class="col-md-4">
                            <input type="number" class="form-control" placeholder="Quantity">
                        </div>
                    </div>`;
                $('#taskAutopartsContainer').append(partRow);
            });
        });
    </script>
   
    <script>
        $(document).on('click', '.edit-btn', function () {
    const task = $(this).data();

    $('#edit_task_id').val(task.id);
    $('#edit_assigned_to').val(task.assigned_to);
    $('#edit_description').val(task.description);
    $('#edit_date').val(task.date);
    $('#edit_high_priority').prop('checked', task.high_priority == 1);

    
    $('#editTaskForm').attr('action', `/admin/task-managment/update/${task.id}`);

    $('#editTaskModal').modal('show');
});

    </script>
@endsection
