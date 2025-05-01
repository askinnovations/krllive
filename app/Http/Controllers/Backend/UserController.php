<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
    
    // dd($request->all());

    // Directly create new user
    User::create([
        'name' => $request->name,
        'pan_number' => $request->pan_number,
        'tan_number' => $request->tan_number,
        'address' => json_encode($request->address), 
        // 'gst_number' => json_encode($request->gst_numbers),
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User added successfully without validation.');
   }


   
   public function show($id)
  {
    $user = User::findOrFail($id);
    return view('admin.users.view', compact('user'));
  }

  public function update(Request $request, $id)
  {
      $user = User::findOrFail($id);
  
      // Update user base fields
      $user->name = $request->name;
      $user->pan_number = $request->pan_number;
      $user->tan_number = $request->tan_number;
  
      // Process address input
      if ($request->filled('address')) {
          $addressString = $request->address;
  
          // Break lines & clean empty ones
          $addressArray = array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $addressString)));
  
          $addresses = [];
  
          foreach ($addressArray as $addressLine) {
              $addressParts = array_map('trim', explode(',', $addressLine));
  
              if (count($addressParts) >= 6) {
                  $addresses[] = [
                      'address_id' => 'address_' . Str::random(10), // Generate unique ID
                      'city' => $addressParts[0],
                      'gstin' => $addressParts[1],
                      'billing_address' => $addressParts[2],
                      'consignment_address' => $addressParts[3],
                      'mobile_number' => $addressParts[4],
                      'email' => $addressParts[5],
                      'poc' => $addressParts[6] ?? '',
                  ];
              }
          }
  
          // Merge with old address data if any
          $existingAddresses = json_decode($user->address, true) ?? [];
          $mergedAddresses = array_merge($existingAddresses, $addresses);
  
          $user->address = json_encode($mergedAddresses, JSON_UNESCAPED_UNICODE);
      }
  
      $user->save();
  
      return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
  }


  


  
  


public function destroy($id)
   {
    $user = User::findOrFail($id);
    $user->delete();

       return response()->json(['success' => true, 'message' => 'User deleted successfully!']);
   }

}
