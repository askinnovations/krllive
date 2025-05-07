<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Module;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;






class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:view permissions', only: ['index']),
            new Middleware('admin.permission:create permissions', only: ['create']),
            new Middleware('admin.permission:edit permissions', only: ['edit']),
            new Middleware('admin.permission:delete permissions', only: ['destroy']),
        ];
    }
    public function index()
    {

        // $permissions = Module::all();
        $permissions = Permission::orderBy('id', 'asc')->paginate(10);
        return view('admin.permission.index' ,compact('permissions'));
        // abort(404);
    }

    public function create()
    {

        $roles = Role::get();

        return view('admin.permission.create',compact('roles'));


    }


     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'module_name' => 'required',
            'actions' => 'required|array|min:1',
            'actions.*' => 'in:create,edit,delete,view,manage',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Save in the modules table
            $module = Module::create([
                'module_name' => $request->module_name,
                'actions' => json_encode($request->actions),
            ]);

            // Save each action as a separate row in the permissions table
            foreach ($request->actions as $action) {
                $permissionName = $action . ' ' . $request->module_name;
                Permission::create([
                    'name' => $permissionName,
                     'guard_name' => 'web'
                   
                ]);
            }

            return redirect()->back()->with('success', 'Permission created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create permission: ' . $e->getMessage())
                ->withInput();
        }
    }

    


 public function edit($id)
{
        // $roles = Role::where('created_by', '=', \Auth::user()->creatorId())->get();

    $permission = Permission::with('roles')->findOrFail($id); // eager load roles
    $roles = Role::all();

    return view('admin.permission.edit', compact('permission', 'roles'));
}






public function destroy($id)
{
    try {
        // Find the permission by ID
        $permission = Permission::findOrFail($id);
        $permissionName = $permission->name; // e.g., "edit order"

        // Parse the permission name to get action
        $parts = explode(' ', $permissionName, 2);
        if (count($parts) !== 2) {
            return redirect()->back()->with('error', 'Invalid permission name format.');
        }
        $actionToDelete = $parts[0]; // e.g., "edit"

        // Find the module using module_id from the permission
        $module = Module::find($permission->module_id);
        if (!$module) {
            return redirect()->back()->with('error', 'Module not found for the given permission.');
        }

        // Delete the permission
        $permission->delete();

        // Decode the actions JSON from the module
        $actions = json_decode($module->actions, true) ?? [];
        
        // Remove the specific action from the actions array
        $updatedActions = array_filter($actions, function ($action) use ($actionToDelete) {
            return $action !== $actionToDelete;
        });

        // Reindex the array to avoid gaps
        $updatedActions = array_values($updatedActions);

        // Update the module with the new actions array
        $module->update([
            'actions' => json_encode($updatedActions),
        ]);

        return redirect()->back()->with('success', 'Permission deleted and module actions updated successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete permission: ' . $e->getMessage());
    }
}
}

