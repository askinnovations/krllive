<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\FreightBill;
use App\Models\Vehicle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class FreightBillController extends Controller
{
    public function index()
   {
    $orders = Order::latest()->get();
    $tyres = FreightBill::all(); 
    // dd($orders);
    return view('admin.freight-bill.index', compact('tyres','orders'));
   }


    public function store(Request $request)
    {  
        $validatedData = $request->validate([
            'notes' => 'required|string|max:255',
            
        ]);

        $tyres = new FreightBill();
        $tyres->notes = $request->input('notes');
        

        $tyres->save();
        if ($tyres->save()) {
            return redirect()->route('admin.freight-bill.index')->with('success', 'freight-bill. add Successfully.');

        }
        return redirect()->route('admin.freight-bill.index')->with('error', 'Failed to add  Destination.');
    }

    public function update(Request $request ,$id)
   {
        $tyres = FreightBill::find($id);
        $validatedData = $request->validate([
            'notes' => 'required|string|max:255',
            
        ]);
        $tyres->notes = $request->input('notes');
        $tyres->save();
        
        if ($tyres->save()) {
            return redirect()->route('admin.freight-bill.index')->with('success', 'Notes updated Successfully.');
        }
        return redirect()->route('admin.freight-bill.index')->with('error', 'Failed update  tyre.');
    }

    public function destroy($id)
   {
    try {
        $tyre = FreightBill::findOrFail($id);

        if ($tyre->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Freight-bill deleted successfully!'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to delete the freight-bill.'
        ], 400);

    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong: ' . $e->getMessage()
        ], 500);
    }
    }


}