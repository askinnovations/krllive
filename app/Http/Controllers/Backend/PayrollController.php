<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class PayrollController extends Controller
{
    public function index()
    {
        $month = 4;
        $year = 2025;

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        $workingDays = $startDate->diffInDaysFiltered(function (Carbon $date) {
            return $date->dayOfWeek !== Carbon::SUNDAY; // Exclude only Sundays
        }, $endDate) + 1;

        $employees = Employee::with([
            'attendances' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }
        ])->get();

        $payrollData = $employees->map(function ($employee) use ($workingDays) {
            $presentDays = $employee->attendances->reduce(function ($carry, $attendance) {
                $status = strtolower($attendance->status);
                if ($status === 'present' || $status === 'halfday') {
                    return $carry + 1; // Halfday also counts as 1 full present day
                }
                return $carry;
            }, 0);
            $payableSalary = ($workingDays > 0)
                ? ($presentDays / $workingDays) * $employee->salary
                : 0;

            return [
                'employee' => $employee,
                'total_salary' => $employee->salary,
                'present_days' => $presentDays,
                'working_days' => $workingDays,
                'payable_salary' => round($payableSalary, 2),
            ];
        });

        return view('admin.payroll.index', compact('payrollData', 'workingDays'));
    }

    public function show($employeeId, Request $request)
    {
        $employee = Employee::findOrFail($employeeId);
    
        $month = $request->input('month', Carbon::now()->format('m'));
        $year = $request->input('year', Carbon::now()->format('Y'));
        $monthYear = Carbon::createFromDate($year, $month)->format('F Y');
    
        // Get total days in selected month
        $totalDaysInMonth = Carbon::create($year, $month)->daysInMonth;
    
        // Fetch attendance for this employee for the selected month
        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'asc')
            ->get();
    
        // Calculate working days (excluding Sundays)
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $workingDays = 0;
    
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if (!$date->isSunday()) {
                $workingDays++;
            }
        }
    
        // Count Present and Halfday for final attendance
        $presentDays = $attendances->where('status', 'present')->count();
        $halfDays = $attendances->where('status', 'halfday')->count();
        $presentday = $presentDays + $halfDays;
    
        // Calculate per day salary
        $dailySalary = $workingDays > 0 ? ($employee->salary / $workingDays) : 0;
    
        // Total payable salary calculation
        $totalPayable = round(($presentDays * $dailySalary) + (0.5 * $dailySalary * $halfDays), 2);
    
        $days = [];
        $runningTotal = 0;
    
        for ($day = 1; $day <= $totalDaysInMonth; $day++) {
            $date = Carbon::createFromDate($year, $month, $day);
            $dayName = $date->format('l');
            $formattedDate = $date->format('Y-m-d');
    
            // Get attendance record for exact date
            $attendance = $attendances->first(function ($item) use ($formattedDate) {
                return $item->date === $formattedDate;
            });
    
            $status = $attendance->status ?? 'absent';
          
    
        
            if ($status === 'present') {
                $daySalary = $dailySalary;
            } elseif ($status === 'halfday') {
                $daySalary = $dailySalary / 2;
            } else {
                $daySalary = 0;
            }
    
            $runningTotal += $daySalary;
    
            $days[] = [
                'date' => $formattedDate,
                'day' => $dayName,
                'status' => $status,
                'salary' => round($daySalary, 2),
                'is_sunday' => $dayName === 'Sunday',
            ];
        }
    
        // echo"<pre>";
        //   print_r($days);die;

        return view('admin.payroll.show', compact(
            'employee',
            'monthYear',
            'presentDays',
            'halfDays',
            'presentday',
            'totalDaysInMonth',
            'workingDays',
            'days',
            'totalPayable'
        ));
    }
    
    }



