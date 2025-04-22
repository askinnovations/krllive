<?php

namespace App\Http\Controllers;

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
    
    public function store(Request $request)
    {
        // return($request->all());

        // Log incoming request for debugging
        \Log::info('Request Data:', $request->all());
    
        $from = $request->input('from');
        $to = $request->input('to');
        $vehicleTypes = $request->input('vehicletype'); // array of arrays
        $rates = $request->input('rate'); // array of arrays
    
        // Loop through each block (from-to section)
        for ($i = 0; $i < count($from); $i++) {
            $fromDestination = $from[$i];
            $toDestination = $to[$i];
    
            // Validate block data if needed
            if (empty($fromDestination) || empty($toDestination)) {
                continue; // skip if any block is incomplete
            }
    
            // Loop through each vehicle + rate pair inside this block
            if (isset($vehicleTypes[$i]) && isset($rates[$i])) {
                for ($j = 0; $j < count($vehicleTypes[$i]); $j++) {
                    $vehicleType = $vehicleTypes[$i][$j];
                    $rate = $rates[$i][$j];
    
                    // Skip empty rows
                    if (empty($vehicleType) || !is_numeric($rate)) {
                        continue; // Only store valid numeric rates
                    }
    
                    // Log the rate before creating the contract
                    \Log::info('Storing Contract:', [
                        'from_destination_id' => $fromDestination,
                        'to_destination_id' => $toDestination,
                        'type_id' => $vehicleType,
                        'rate' => $rate
                    ]);
    
                    // Store the contract
                    \App\Models\Contract::create([
                        'from_destination_id' => $fromDestination,
                        'to_destination_id' => $toDestination,
                        'type_id' => $vehicleType,
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
