<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;



class WarehouseController extends Controller
{
    public function index()
    {

        $warehouses = Warehouse::all();

        return view('admin.warehouse.index', compact('warehouses'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'warehouse_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'incharge' => 'required|string|max:255',
        ]);


        $warehouse = new Warehouse();
        $warehouse->warehouse_name = $request->warehouse_name;
        $warehouse->address = $request->address;
        $warehouse->incharge = $request->incharge;
        $warehouse->save();
        if ($warehouse->save()) {
            return redirect()->back()->with('success', 'Warehouse created successfully!');
        }
        return redirect()->back()->with('error', 'Warehouse not created!');

    }


    public function update(Request $request,$id){
        $warehouse=Warehouse::find($id);
        $request->validate([
            'warehouse_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'incharge' => 'required|string|max:255',
        ]);
        $warehouse->warehouse_name = $request->warehouse_name;
        $warehouse->address = $request->address;
        $warehouse->incharge = $request->incharge;
        $warehouse->save();
        if ($warehouse->save()) {
            return redirect()->back()->with('success', 'Warehouse updated successfully!');
        }
        return redirect()->back()->with('error', 'Warehouse  not update !');

    }

    public function destroy($id)
    {
        try {

            $tyre = Warehouse::findOrFail($id);

            if ($tyre->delete()) {
                return redirect()->route('admin.warehouse.index')->with('success', 'Warehouse deleted successfully!');
            }

            return redirect()->route('admin.warehouse.index')->with('error', 'Failed to delete the warehouse.');
        } catch (Exception $e) {
            return redirect()->route('admin.warehouse.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

}