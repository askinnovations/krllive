<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\Vehicle;


class MaintenanceController extends Controller
{

    public function index()
    {
        $maintenances = Maintenance::all();
        $vehicleTypes = Vehicle::select('vehicle_type')->get();


        return view('admin.maintenance.index', compact('maintenances','vehicleTypes'));
    }

    public function store(Request $request)
    {


        $validated = $request->validate([
            'vehicle' => 'required|string',
            'category' => 'required|string',
            'vendor' => 'required|string',
            'odometer_reading' => 'required',
            'autoparts' => 'required|array',
            'autoparts.*.name' => 'required|string',
            'autoparts.*.id' => 'required|string',
            'autoparts.*.quantity' => 'required|numeric',
        ]);


        Maintenance::create([
            'vehicle' => $validated['vehicle'],
            'category' => $validated['category'],
            'vendor' => $validated['vendor'],
            'odometer_reading' => $validated['odometer_reading'],
            'autoparts' => $validated['autoparts'],
        ]);

        return redirect()->route('admin.maintenance.index')->with('success', ' Maintenance record saved successfully.');

    }
    public function destroy($id)
    {
        try {

            $Maintenance = Maintenance::findOrFail($id);

            if ($Maintenance->delete()) {
                return redirect()->route('admin.maintenance.index')->with('success', 'Maintenance deleted successfully!');
            }
            return redirect()->route('admin.maintenance.index')->with('error', 'Failed to delete  Maintenance');

        } catch (Exception $e) {
            return redirect()->route('admin.maintenance.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'vehicle' => 'required|string',
            'category' => 'required|string',
            'vendor' => 'required|string',
            'odometer_reading' => 'required',
            'autoparts' => 'required|array',
            'autoparts.*.name' => 'required|string',
            'autoparts.*.id' => 'required|string',
            'autoparts.*.quantity' => 'required|numeric',
        ]);
        $Maintenance = Maintenance::findOrFail($id);


        $Maintenance->update($request->all());
        return redirect()->route('admin.maintenance.index')->with('success', 'Maintenance deleted successfully!');

    }

}