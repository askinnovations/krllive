@extends('admin.layouts.app')
@section('title', 'Employees | KRL')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Payroll</h4>
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
                                <li class="breadcrumb-item active">Payroll</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row listing-form">
                <div class="col-12">
                    <div class="container my-5">
                        <div class="modal-body">

                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Employee:</strong> {{ $employee->first_name}} {{ $employee->last_name}}</div>
                                <div class="col-md-6">
                                    <strong>Days:</strong> {{ $presentday }}/{{ $workingDays }}
                                </div>
                                @if($monthYear)
                                <div class="col-md-6"><strong>Month:</strong> {{ $monthYear }}</div>
                                @else
                                <div class="col-md-6"><strong>Month:</strong> Not available</div>
                                @endif
                                <div class="col-md-6"><strong>pay Amount:</strong>  {{$totalPayable}} <strong>Salary Amount:</strong>{{ $employee->salary}}</div>
                            </div>

                            <h6>Daily Logs</h6>
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Day</th>
                                        <th>Status</th>
                                        <th>Today Salary</th>
                                        <th>Total Salary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $runningTotal = 0; @endphp
                                    @foreach($days as $day)
                                        @php 
                                            $runningTotal += $day['salary'] ?? 0; 
                                            $isSunday = $day['is_sunday'];
                                        @endphp
                                        <tr>
                                            {{-- Date --}}
                                            <td style="{{ $isSunday ? 'background-color: red; color: white; font-weight: bold;' : '' }}">
                                                {{ $day['date'] }}
                                            </td>
                                
                                            {{-- Day --}}
                                            <td style="{{ $isSunday ? 'background-color: red; color: white; font-weight: bold;' : '' }}">
                                                {{ $day['day'] }}
                                            </td>
                                
                                            {{-- Status --}}
                                            <td style="
                                                {{ $isSunday ? 'background-color: red; color: white; font-weight: bold;' : '' }}
                                                @switch($day['status'])
                                                    @case('absent')
                                                        {{ !$isSunday ? 'background-color: #f8d7da; color: #721c24;' : '' }}
                                                        @break
                                                    @case('present')
                                                        {{ !$isSunday ? 'background-color: #d4edda; color: #155724;' : '' }}
                                                        @break
                                                    @case('halfday')
                                                        {{ !$isSunday ? 'background-color: #d1ecf1; color: #0c5460;' : '' }}
                                                        @break
                                                @endswitch
                                                ">
                                                {{ ucfirst($day['status']) }}
                                            </td>
                                
                                            {{-- Salary --}}
                                            <td style="{{ $isSunday ? 'background-color: red; color: white; font-weight: bold;' : '' }}">
                                                {{ number_format($day['salary'] ?? 0, 2) }}
                                            </td>
                                
                                            {{-- Running Total --}}
                                            <td style="{{ $isSunday ? 'background-color: red; color: white; font-weight: bold;' : '' }}">
                                                {{ number_format($runningTotal, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
