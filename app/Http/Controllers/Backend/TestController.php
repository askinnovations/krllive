<?php



namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


use App\Models\User;
class TestController extends Controller implements HasMiddleware

{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:view users', only: ['index']),
            new Middleware('admin.permission:create users', only: ['create']),
            new Middleware('admin.permission:edit users', only: ['edit']),
            new Middleware('admin.permission:delete users', only: ['destroy']),
        ];
    }
   public function  index(){
 $users=Admin::all();
 return view('admin.user.index',compact('users'));
 
   }
   public function create() {
    $roles=Role::all();
    return view('admin.user.create',compact('roles'));
}
public function edit($id)
    {
        $roles=Role::all();
        $user=Admin::find($id);
        return view('admin.user.edit', compact('user','roles'));
    }


public function store(Request $request)
{
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|string',
        'password' => '',
    ]);

 
    Admin::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role, 
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('admin.user.index')->with('success', 'User created successfully.');
}

public function update(Request $request, $id)
{
    $admin = Admin::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email' ,
        'role' => 'required|string',
       
    ]);

    $admin->name = $request->name;
    $admin->email = $request->email;
    $admin->role = $request->role;

    if ($request->filled('password')) {
        $admin->password = Hash::make($request->password);
    }

    $admin->save();

    return redirect()->route('admin.user.index')->with('success', 'User updated successfully.');
}

public function destroy($id)
{
    $user = Admin::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully.');
}

}
