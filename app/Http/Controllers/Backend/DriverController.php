<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function index(){
        $drivers= Driver::all();
       

      
        return view('admin.drivers.index',compact('drivers'));
    }
     public function create(){
        $vehicles = Vehicle::select('vehicle_no')->get();
        return view('admin.drivers.create',compact('vehicles'));
     }
     
     
     public function store(Request $request)
     {

         $validatedData = $request->validate([
             'first_name' => 'required|string|max:255',
             'last_name' => 'required',
             'phone_number' => 'nullable',
             'emergency_contact_number' => 'nullable',
             'address' => 'required|string',
             'state' => 'required|string',
             'pin_code' => 'nullable|string|max:10',
            //  'aadhaar_number' => 'nullable|numeric',
             'vehicle_number' => 'nullable|string|max:20',
             'status' => 'required|in:active,inactive',
     
             // File validations
             'driver_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
             'aadhaar_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
             'license_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
         ]);
     
        
         $driverPhotoPath = $request->hasFile('driver_photo')
             ? $request->file('driver_photo')->store('drivers/drivers_photos', 'public')
             : null;
     
         $aadhaarDocPath = $request->hasFile('aadhaar_doc')
             ? $request->file('aadhaar_doc')->store('drivers/aadhaar', 'public')
             : null;
     
         $licenseDocPath = $request->hasFile('license_doc')
             ? $request->file('license_doc')->store('drivers/license', 'public')
             : null;
     
        
         $driver = Driver::create([
             'first_name' => $validatedData['first_name'],
             'last_name' => $validatedData['last_name'],
             'phone_number' => $validatedData['phone_number'],
             'emergency_contact_number' => $validatedData['emergency_contact_number'] ?? null,
             'address' => $validatedData['address'],
             'state' => $validatedData['state'],
             'pin_code' => $validatedData['pin_code'] ?? null,
             
             'vehicle_number' => $validatedData['vehicle_number'] ?? null,
             'status' => $validatedData['status'],
     
             // File paths
             'driver_photo' => $driverPhotoPath,
             'aadhaar_doc' => $aadhaarDocPath,
             'license_doc' => $licenseDocPath,
         ]);
     
        
         return redirect()->route('admin.drivers.index')->with('success', 'Driver added successfully!');
     }
     
     public function edit($id){
        $driver=Driver::find($id);
        $vehicles = Vehicle::select('vehicle_no')->get();

        return view('admin.drivers.edit',compact('driver','vehicles'));

     }

     public function show($id){
        $driver=Driver::find($id);
        

        return view('admin.drivers.show',compact('driver'));

     }

     
     public function update(Request $request, $id)
     {
         $driver = Driver::findOrFail($id);
     
       
         $request->validate([
             'first_name' => 'required|string|max:255',
             'last_name' => 'required|string|max:255',
             'phone_number' => 'required',
             'emergency_contact_number' => 'nullable',
             'address' => 'required|string',
             'state' => 'required|string',
             'pin_code' => 'nullable|numeric',
             'vehicle_number' => 'nullable|string|max:20',
             'status' => 'required|in:active,inactive',
     
             // Files
             'driver_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
             'aadhaar_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
             'license_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
         ]);
     
        
         $driver->first_name = $request->first_name;
         $driver->last_name = $request->last_name;
         $driver->phone_number = $request->phone_number;
         $driver->emergency_contact_number = $request->emergency_contact_number;
         $driver->address = $request->address;
         $driver->state = $request->state;
         $driver->pin_code = $request->pin_code;
         $driver->vehicle_number = $request->vehicle_number;
         $driver->status = $request->status;
     
        
         if ($request->hasFile('driver_photo')) {
             if ($driver->driver_photo && Storage::disk('public')->exists($driver->driver_photo)) {
                 Storage::disk('public')->delete($driver->driver_photo);
             }
             $driver->driver_photo = $request->file('driver_photo')->store('drivers/drivers_photos', 'public');
         }
     
         if ($request->hasFile('aadhaar_doc')) {
             if ($driver->aadhaar_doc && Storage::disk('public')->exists($driver->aadhaar_doc)) {
                 Storage::disk('public')->delete($driver->aadhaar_doc);
             }
             $driver->aadhaar_doc = $request->file('aadhaar_doc')->store('drivers/aadhaar', 'public');
         }
     
         if ($request->hasFile('license_doc')) {
             if ($driver->license_doc && Storage::disk('public')->exists($driver->license_doc)) {
                 Storage::disk('public')->delete($driver->license_doc);
             }
             $driver->license_doc = $request->file('license_doc')->store('drivers/license', 'public');
         }
     
        
         if ($driver->save()) {
             return redirect()->route('admin.drivers.index')->with('success', 'Driver updated successfully!');
         }
     
         return redirect()->route('admin.drivers.index')->with('error', 'Driver not updated!');
     }
     
 

     public function destroy($id){
        $driver=Driver::findOrFail($id);
        
        if($driver->delete()){
       
         return redirect()->back()->with('success', 'Driver deleted successfully!');

    }
        return redirect()->back()->with('error', 'Driver not deleted !');

     }
}
