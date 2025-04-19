<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Destination;
use App\Models\Contract;

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
    $vehicles = \App\Models\Vehicle::pluck('vehicle_type', 'id')->toArray(); // [id => type]
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
        $vehicles = Vehicle::all();
        $destinations = Destination::all();
        // Contracts के साथ vehicle और destination डेटा भी लाओ
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
        $vehicleTypes = $request->input('vehicle_type'); // array of arrays
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
                        'vehicle_id' => $vehicleType,
                        'rate' => $rate
                    ]);
    
                    // Store the contract
                    \App\Models\Contract::create([
                        'from_destination_id' => $fromDestination,
                        'to_destination_id' => $toDestination,
                        'vehicle_id' => $vehicleType,
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
