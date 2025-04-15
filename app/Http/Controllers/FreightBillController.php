<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Vehicle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class FreightBillController extends Controller
{
    public function index(){
        $orders = Order::latest()->get();
        return view('admin.freight-bill.index',compact('orders'));
    }
    public function create()
   {
    // Vehicles table से सभी records fetch करें
    $vehicles = Vehicle::all();
    $users = User::all(); 
    return view('admin.freight-bill.create', compact('vehicles','users'));
    }

    public function edit($order_id)
    {
        // dd($order_id);
        $order = Order::with(['consignor', 'consignee'])->where('order_id', $order_id)->firstOrFail();
        $vehicles = Vehicle::all();
        $users = User::all();
        // All associated LRs with same order_id (excluding the main one if needed)
        $lrEntries = Order::where('order_id', $order->order_id)
                        ->where('order_date', '!=', $order->order_date) // Optional: Exclude main by any field
                        ->get();

        return view('admin.freight-bill.edit', compact('order', 'lrEntries','vehicles','users'));
    }
    
    public function show(Request $request)
    {
        $inputLrNumbers = $request->input('lr'); // array of LR numbers
        
    
        $matchedEntries = [];
    
        $orders = DB::table('orders')->get();
    
        foreach ($orders as $order) {
            $lrJson = $order->lr;
    
            $lrData = json_decode($lrJson, true);
    
            // If still not array, decode again (nested)
            if (!is_array($lrData)) {
                $lrData = json_decode(json_decode($lrJson), true);
            }
    
            // Ab har entry check karo
            foreach ($lrData as $entry) {
                if (
                    isset($entry['lr_number']) &&
                    in_array(trim($entry['lr_number']), array_map('trim', $inputLrNumbers))
                ) {
                    // Extra data chahiye to order se attach kar lo
                    $entry['order_id'] = $order->id ?? null;
                    $matchedEntries[] = $entry;
                }
            }
        }
    
        if (empty($matchedEntries)) {
            return redirect()->back()->with('error', 'No matching LR Numbers found.');
        }
    
        $vehicles = \App\Models\Vehicle::all();
        $users = \App\Models\User::all();
    
        return view('admin.freight-bill.view', compact('matchedEntries', 'vehicles', 'users'));
    }
    
    
    

    public function update(Request $request, $id)
    {
        // Validate the input
        $validated = $request->validate([
            'consignor_name' => 'required|string|max:255',
            'consignor_loading' => 'nullable|string|max:255',
            'consignor_gst' => 'nullable|string|max:20',

            'consignee_name' => 'required|string|max:255',
            'consignee_unloading' => 'nullable|string|max:255',
            'consignee_gst' => 'nullable|string|max:20',

            'vehicle_date'         => 'required|date',
            'vehicle_type'         => 'required|string|max:100',
            'vehicle_ownership'    => 'required|in:Own,Other',

            'delivery_mode'        => 'required|string|in:Road,Rail,Air',
            'from_location'        => 'required|string|max:100',
            'to_location'          => 'required|string|max:100',
        ]);

        // Find the order by ID and update
        $order = Order::findOrFail($id);
        $order->update($validated);

        // Redirect back to the list page with success
        return redirect()->route('admin.freight-bill.index')->with('success', 'Consignment updated successfully!');
    }

   

    public function store(Request $request)
   {
    // ✅ Step 1: Validation
    $validated = $request->validate([
        'consignor_name' => 'required|string|max:255',
        'consignor_loading' => 'nullable|string|max:255',
        'consignor_gst' => 'nullable|string|max:20',

        'consignee_name' => 'required|string|max:255',
        'consignee_unloading' => 'nullable|string|max:255',
        'consignee_gst' => 'nullable|string|max:20',

        'vehicle_date'         => 'required|date',
        'vehicle_type'         => 'required|string|max:100',
        'vehicle_ownership'    => 'required|in:Own,Other',

        'delivery_mode'        => 'required|string|in:Road,Rail,Air',
        'from_location'        => 'required|string|max:100',
        'to_location'          => 'required|string|max:100',
    ]);

    // ✅ Step 2: Generate Unique Order ID
    $order_id = strtoupper(uniqid('LR_'));

    // ✅ Step 3: Get vehicle_id using vehicle_type
    $vehicle = Vehicle::where('vehicle_type', $request->input('vehicle_type'))->first();

    // ✅ Step 4: Prepare data
    $data = array_merge($validated, [
        'order_id' => $order_id,
        'vehicle_id' => $vehicle ? $vehicle->id : null,
    ]);
    // ✅ Step 4: Insert into DB
    try {
        $order = Order::create($data);

        return redirect()->route('admin.freight-bill.index')
            ->with('success', 'Consignment created successfully with Order ID: ' . $order_id);
    } catch (\Exception $e) {
        return back()->withErrors(['msg' => 'Error creating order: ' . $e->getMessage()]);
    }
   }



   public function destroy($order_id)
    {
        // Get all orders with the same order_id
        $orders = Order::where('order_id', $order_id)->get();
    
        if ($orders->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No entries found for this order_id.'], 404);
        }
    
        try {
            // Delete all related LRs
            foreach ($orders as $order) {
                $order->delete();
            }
    
            return response()->json(['status' => 'success', 'message' => 'All entries under this Order ID deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error while deleting entries.'], 500);
        }
    }

}