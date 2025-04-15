<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {   
      $users = User::all();
      return view('admin.users.index', compact('users')); // ✅ View me bhejein
    }

    // Store category data
    public function store(Request $request)
   {
    $request->validate([
      'name' => 'required|string|max:255',
      'mobile_number' => 'required|string|max:15',
      'email' => 'required|email|max:255|unique:users,email',
      'address' => 'required|array',
      'address.*.full_address' => 'required|string|max:255',
      'address.*.city' => 'required|string|max:100',
      'address.*.pincode' => 'required|string|max:10',
      'gst_number' => 'nullable|string|max:50',
    ]);

    User::create([
        'name' => $request->name,
        'mobile_number' => $request->mobile_number,
        'email' => $request->email,
        'address' => json_encode($request->address), // Array को JSON में स्टोर किया
        'gst_number' => $request->gst_number,
    ]);
    
    return redirect()->route('admin.users.index')->with('success', 'User added successfully.');
   }
   
   public function show($id)
  {
    $user = User::findOrFail($id);
    return view('admin.users.view', compact('user'));
  }

  public function update(Request $request, $id)
  {   
    $request->validate([
        'name' => 'required|string|max:255',
        'mobile_number' => 'required|string|max:20',
        'email' => 'required|email',
        'gst_number' => 'nullable|string|max:20',
        'address' => 'nullable|string', // ✅ Address को String के रूप में Validate करें
    ]);

    $user = User::findOrFail($id);
    $user->name = $request->name;
    $user->mobile_number = $request->mobile_number;
    $user->email = $request->email;
    $user->gst_number = $request->gst_number;

    // ✅ पहले से Stored Address JSON Format में Get करें
    $existingAddress = json_decode($user->address, true) ?? [];

    // ✅ अगर नया Address आया है तो उसे JSON में Store करें
    if ($request->has('address')) {
        $formattedAddress = [
            "full_address" => $request->address, // ✅ Address Field Update करें
        ];

        // ✅ पुराने Address को Replace करके नया Address Store करें
        $existingAddress[0] = $formattedAddress;
        $user->address = json_encode($existingAddress, JSON_UNESCAPED_UNICODE);
    }

    $user->save();

    return redirect()->back()->with('success', 'Customer details updated successfully.');
}

public function destroy($id)
   {
    $user = User::findOrFail($id);
    $user->delete();

       return response()->json(['success' => true, 'message' => 'User deleted successfully!']);
   }

}
