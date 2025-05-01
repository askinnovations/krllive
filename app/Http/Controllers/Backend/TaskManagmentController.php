<?php

namespace App\Http\Controllers\Backend;
use App\Models\TaskManagement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Employee;


class TaskManagmentController extends Controller
{
    public function index(){
        $employees = Employee::where('status', 'active')->get();

        $today_tasks = TaskManagement::whereDate('date', Carbon::today())->get();
        $other_days_tasks = TaskManagement::whereDate('date', '!=', Carbon::today())->get();

        return view('admin.task_management.index',compact('today_tasks','other_days_tasks','employees'));
    }

    public function store(Request $request)
{
   
    $task = new TaskManagement();
    $task->assigned_to = $request->assigned_to;
    $task->description = $request->description;
    $task->high_priority = $request->has('high_priority') ? 1 : 0;
    $task->date = $request->date; 
   

    if( $task->save()){
        return redirect()->back()->with('success', 'Task created successfully!');

    }
}
public function update(Request $request,$id)
{
   
    $task =  TaskManagement::find($id);
    $task->assigned_to = $request->assigned_to;
    $task->description = $request->description;
    $task->high_priority = $request->has('high_priority') ? 1 : 0;
    $task->date = $request->date; 
   

    if( $task->save()){
        return redirect()->back()->with('success', 'Task updated successfully!');

    }
}
public function destroy($id)
{
    $task = TaskManagement::findOrFail($id); 
    $task->delete();

     return redirect()->back()->with('success', 'Task deleted successfully!');

}
public function closeTask($id)
{
    $task = TaskManagement::findOrFail($id);

   
    $task->status = $task->status === 'open' ? 'close' : 'open';
    $task->save();

    return redirect()->back()->with('success', 'Task status updated successfully.');
}
public function searchByDate(Request $request)
{
    try {
        $date = $request->input('date');

        $tasks = TaskManagement::whereDate('date', $date)
            ->with('assignedEmployee')
            ->get();

        if ($tasks->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No tasks found for this date.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $tasks->count() . ' task(s) found.',
            'tasks' => $tasks
        ]);
    } catch (\Exception $e) {
        \Log::error('Task fetch error: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

}
