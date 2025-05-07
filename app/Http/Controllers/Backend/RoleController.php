<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use App\Models\Module;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;




class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:view role', only: ['index']),
            new Middleware('admin.permission:create role', only: ['create']),
            new Middleware('admin.permission:edit role', only: ['edit']),
            new Middleware('admin.permission:delete role', only: ['destroy']),
        ];
    }
    public function index()
{
    $permissions = Permission::all();
    $roles = Role::with('permissions')->get();

    return view('admin.role.index', compact('roles', 'permissions'));
}
        public function create()
        {
            
            $permissions=Permission::all();
            $modules=Module::all();
           
    
            return view('admin.role.create', compact('permissions','modules'));
        }
    
        
public function store(Request $request)
{
    
    $request->validate([
        'name' => 'required|string|unique:roles,name',
        'permissions' => 'required|array',
    ]);

    $role = Role::create(['name' => $request->name]);

    
    foreach ($request->permissions as $permissionName) {
        Permission::firstOrCreate(['name' => $permissionName]);
    }

    
    $role->syncPermissions($request->permissions);

    
    return redirect()->route('admin.role.index')->with('success' , 'Role and permissions created successfully');
}
        
public function destroy($id)
{
    $role = Role::findOrFail($id);
    $role->delete();

    return redirect()->back()->with('success', 'Role deleted successfully.');
}    

public function edit($id)
{
    
    $modules=Module::all();
    $role = Role::findOrFail($id);
   
    return view('admin.role.edit', compact('role','modules'));
}  

public function update(Request $request, $id)
    {
        
      
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array|min:1', 
        ]);

      
        $role = Role::findOrFail($id);

       
        $role->update([
            'name' => $request->name, 
        ]);

        
        $permissions = $request->permissions;
       
        $permissionIds = [];
        foreach ($permissions as $perm) {
            $permission = Permission::where('name', $perm)->first();
            if ($permission) {
                $permissionIds[] = $permission->id;
            }
        }

      
        $role->permissions()->sync($permissionIds);

        return redirect()->route('admin.role.index')->with('success', 'Role updated successfully.');
    }

    // public function store(Request $request)
    // {
    //     if(\Auth::user()->can('create role'))
    //     {
    //         $validator = \Validator::make(
    //             $request->all(), [
    //                                'name' => 'required|max:100|unique:roles,name,NULL,id,created_by,' . \Auth::user()->creatorId(),
    //                                'permissions' => 'required',
    //                            ]
    //         );

    //         if($validator->fails())
    //         {
    //             $messages = $validator->getMessageBag();

    //             return redirect()->back()->with('error', $messages->first());
    //         }

    //         $name             = $request['name'];
    //         $role             = new Role();
    //         $role->name       = $name;
    //         $role->created_by = \Auth::user()->creatorId();
    //         $permissions      = $request['permissions'];
    //         $role->save();

    //         foreach($permissions as $permission)
    //         {
    //             $p = Permission::where('id', '=', $permission)->firstOrFail();
    //             $role->givePermissionTo($p);
    //         }

    //         return redirect()->route('roles.index')->with('success' , 'Role successfully created.', 'Role ' . $role->name . ' added!');
    //     }
    //     else
    //     {
    //         return redirect()->back()->with('error', 'Permission denied.');
    //     }
    // }

    // public function edit(Role $role)
    // {
    //     if(\Auth::user()->can('edit role'))
    //     {

    //         $user = \Auth::user();
    //         if($user->type == 'super admin')
    //         {
    //             $permissions = Permission::all()->pluck('name', 'id')->toArray();
    //         }
    //         else
    //         {
    //             $permissions = new Collection();
    //             foreach($user->roles as $role1)
    //             {
    //                 $permissions = $permissions->merge($role1->permissions);
    //             }
    //             $permissions = $permissions->pluck('name', 'id')->toArray();
    //         }

    //         return view('role.edit', compact('role', 'permissions'));
    //     }
    //     else
    //     {
    //         return redirect()->back()->with('error', 'Permission denied.');
    //     }


    // }

    // public function update(Request $request, Role $role)
    // {

    //     if(\Auth::user()->can('edit role'))
    //     {
    //         $validator = \Validator::make(
    //             $request->all(), [
    //                                'name' => 'required|max:100|unique:roles,name,' . $role['id'] . ',id,created_by,' . \Auth::user()->creatorId(),
    //                                'permissions' => 'required',
    //                            ]
    //         );
    //         if($validator->fails())
    //         {
    //             $messages = $validator->getMessageBag();

    //             return redirect()->back()->with('error', $messages->first());
    //         }

    //         $input       = $request->except(['permissions']);
    //         $permissions = $request['permissions'];
    //         $role->fill($input)->save();

    //         $p_all = Permission::all();

    //         foreach($p_all as $p)
    //         {
    //             $role->revokePermissionTo($p);
    //         }

    //         foreach($permissions as $permission)
    //         {

    //             $p = Permission::where('id', '=', $permission)->firstOrFail();
    //             $role->givePermissionTo($p);
    //         }

    //         return redirect()->route('roles.index')->with('success' , 'Role successfully updated.', 'Role ' . $role->name . ' updated!');
    //     }
    //     else
    //     {
    //         return redirect()->back()->with('error', 'Permission denied.');
    //     }

    // }


    // public function destroy(Role $role)
    // {
    //     if(\Auth::user()->can('delete role'))
    //     {
    //         $role->delete();

    //         return redirect()->route('roles.index')->with('success', __('Role successfully deleted.'));
    //     }
    //     else
    //     {
    //         return redirect()->back()->with('error', 'Permission denied.');
    //     }
    // }

}
