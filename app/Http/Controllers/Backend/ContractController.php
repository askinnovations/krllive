<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Destination;
use App\Models\Contract;
use App\Models\VehicleType;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $contracts = Contract::all();
        // Fetch related data for mapping
        $vehicles = \App\Models\VehicleType::pluck('vehicletype', 'id')->toArray(); // [id => type]
        $locations = \App\Models\Destination::pluck('destination', 'id')->toArray(); // [id => name]
        $contracts = Contract::with('vehicle', 'fromDestination', 'toDestination')->get();

        return view('admin.contract.index', compact('users','contracts','vehicles','locations'));
    }
    
   
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id); 
        $vehicles = VehicleType::all();
        $destinations = Destination::all();
        $contracts = Contract::with('vehicle', 'fromDestination', 'toDestination')->get();
    
        return view('admin.contract.view', compact('user', 'vehicles', 'destinations','contracts'));
    }

    public function getRate(Request $request)
    {
        try {
            // Get values from the request
            $customer_id = $request->customer_id; // Customer ID
            $vehicle_type = $request->vehicle_type;
            $from_location = $request->from_location;
            $to_location = $request->to_location;
    
            // Fetch rate from the Contract model based on vehicle type, from location, and to location
            $rate = Contract::where('type_id', $vehicle_type)
                            ->where('from_destination_id', $from_location)
                            ->where('to_destination_id', $to_location)
                            ->where('user_id', $customer_id)
                            ->value('rate');
                           
            // Return rate if found
            if ($rate) {
                return response()->json(['rate' => $rate, 'customer_id' => $customer_id]);
            } else {
                return response()->json(['rate' => null, 'message' => 'No rate found for this selection.'], 404);
            }
        } catch (\Exception $e) {
            // Return error message if any exception occurs
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    public function store(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $vehicleTypes = $request->input('vehicletype'); // array of arrays
        $rates = $request->input('rate'); // array of arrays
        $user_id = $request->input('user_id');
    
        // Loop through each from-to pair
        for ($i = 0; $i < count($from); $i++) {
            $fromDestination = $from[$i];
            $toDestination = $to[$i];
    
            // Check if both from and to exist
            if (empty($fromDestination) || empty($toDestination)) {
                continue;
            }
    
            // Check if vehicle and rate blocks exist for this from-to pair
            if (isset($vehicleTypes[$i]) && isset($rates[$i])) {
                for ($j = 0; $j < count($vehicleTypes[$i]); $j++) {
                    $vehicleType = $vehicleTypes[$i][$j];
                    $rate = $rates[$i][$j];
    
                    if (empty($vehicleType) || !is_numeric($rate)) {
                        continue;
                    }
    
                    // Store in DB
                    \App\Models\Contract::create([
                        'type_id' => $vehicleType,
                        'from_destination_id' => $fromDestination,
                        'to_destination_id' => $toDestination,
                        'user_id' => $user_id,
                        'rate' => $rate,
                    ]);
                }
            }
        }
    
        return redirect()->route('admin.contract.index')->with('success', 'Contract created successfully');
    }
    
    
    
   

    /**
     * Show the form for editing the specified resource.
     */

     public function update(Request $request, $id)
     {
         $request->validate([
             'vehicletype' => 'required|integer|exists:vehicle_types,id',
             'from'        => 'required|integer|exists:destinations,id',
             'to'          => 'required|integer|exists:destinations,id',
             'rate'        => 'required|numeric',
         ]);
 
         $contract = Contract::findOrFail($id);
         $contract->type_id               = $request->vehicletype;
         $contract->from_destination_id   = $request->from;
         $contract->to_destination_id     = $request->to;
         $contract->rate                  = $request->rate;
         $contract->save();
 
         return redirect()->back()->with('success','Contract updated successfully.');
     }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $tyre = Contract::findOrFail($id);

            if ($tyre->delete()) {
                return redirect()->route('admin.contract.index')->with('success', 'Destination deleted successfully!');
            }

            return redirect()->route('admin.contract.index')->with('error', 'Failed to delete the tyre.');
        } catch (Exception $e) {
            return redirect()->route('admin.contract.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
