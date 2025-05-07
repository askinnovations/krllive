<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\TaskManagement;
use Carbon\Carbon;
class TaskmanagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
       
        $employees = Employee::where('status', 'active')->get();
    
        $today_tasks = TaskManagement::whereDate('date', Carbon::today())->get();
        $other_days_tasks = TaskManagement::whereDate('date', '!=', Carbon::today())->get();
    
        return response()->json([
            'status' => true,
            'message' => 'Task data fetched successfully.',
            'data' => [
                'employees' => $employees,
                'other_days_tasks' => $other_days_tasks,
                'today_tasks' => $today_tasks
              
            ]
        ]);
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'assigned_to' => 'required|integer',
                'description' => 'required|string',
                'date' => 'required|date',
            ]);
    
            $task = new TaskManagement();
            $task->assigned_to = $request->assigned_to;
            $task->description = $request->description;
            $task->high_priority = $request->has('high_priority') ? 1 : 0;
            $task->date = $request->date;
    
            if ($task->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Task created successfully!',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to create task.',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
       
       $task=TaskManagement::find($id);
       if(!$task){
        return response()->json([
            'status'=>false,
            'message'=>'error',
        ],404
    );
    }
        return response()->json([
            'status'=> true,
            'message'=> 'Task data fetched successfully ',
            'data'=>[
              'task'=>$task,
            ]
            
            ]);
    }

   
    public function update(Request $request, string $id)
{
    try {
        $task = TaskManagement::find($id);

        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Task not found.',
            ], 404);
        }

        $request->validate([
            'assigned_to' => 'required|integer',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $task->assigned_to = $request->assigned_to;
        $task->description = $request->description;
        $task->high_priority = $request->has('high_priority') ? 1 : 0;
        $task->date = $request->date;

        if (!$task->save()) {
            return response()->json([
                'status' => false,
                'message' => 'Task not updated successfully!',
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Task updated successfully!',
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Error: ' . $e->getMessage(),
        ], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $task = TaskManagement::find($id);
        if(!$task){
            return response()->json([
                'status'=>false,
                    'message'=>'id not found',
 
             ] ,405);
        }
        if(!$task->delete()){
            return response()->json([
               'status'=>false,
                   'message'=>'not deleted task',

            ] ,405);
        }
        else{
            return response()->json([
                'status'=>true,
                    'message'=>' deleted task',
 
             ] );
        }


    }
}
