<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VehicleType;

class VehicleTypeController extends Controller
{
    public function index()
    {
        $tyres = VehicleType::all();
        return view('admin.vehicletype.index', compact('tyres'));
    }
    public function store(Request $request)
    {  
        $validatedData = $request->validate([
            'vehicletype' => 'required|string|max:255',
            
        ]);

        $tyres = new VehicleType();
        $tyres->vehicletype = $request->input('vehicletype');
        

        $tyres->save();
        if ($tyres->save()) {
            return redirect()->route('admin.vehicletype.index')->with('success', 'VehicleType add Successfully.');

        }
        return redirect()->route('admin.vehicletype.index')->with('error', 'Failed to add  VehicleType.');
    }

   public function update(Request $request ,$id)
   {
    
       $tyres = VehicleType::find($id);
        $validatedData = $request->validate([
            'vehicletype' => 'required|string|max:255',
            
        ]);
        $tyres->vehicletype = $request->input('vehicletype');
        
    
     
        $tyres->save();
        
        if ($tyres->save()) {
            return redirect()->route('admin.vehicletype.index')->with('success', 'VehicleType updated Successfully.');

        }
        return redirect()->route('admin.vehicletype.index')->with('error', 'Failed update  tyre.');
    

   }
    public function destroy($id)
    {
        try {

            $tyre = VehicleType::findOrFail($id);

            if ($tyre->delete()) {
                return redirect()->route('admin.vehicletype.index')->with('success', 'VehicleType deleted successfully!');
            }

            return redirect()->route('admin.vehicletype.index')->with('error', 'Failed to delete the tyre.');
        } catch (Exception $e) {
            return redirect()->route('admin.vehicletype.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

}
