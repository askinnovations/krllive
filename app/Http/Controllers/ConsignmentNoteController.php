<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class ConsignmentNoteController extends Controller
{
   public function index(){
    $orders = Order::latest()->get();

    return view('admin.consignments.index', compact('orders'));
   }

   public function create()
   {
   
    $vehicles = Vehicle::all();
    $users = User::all();
    return view('admin.consignments.create', compact('vehicles','users'));
    }

    
public function store(Request $request){
    
    $order = new Order();

    // Auto generate order_id
    $order->order_id = 'ORD-' . time();
    
    // Step 1: Prepare cargo array
    $cargoArray = [];
    
    if (isset($request->cargo) && is_array($request->cargo)) {
        foreach ($request->cargo as $cargo) {
            $cargoArray[] = [
                'packages_no'         => $cargo['packages_no'] ?? null,
                'package_type'        => $cargo['package_type'] ?? null,
                'package_description' => $cargo['package_description'] ?? null,
                'weight'              => $cargo['weight'] ?? null,
                'actual_weight'       => $cargo['actual_weight'] ?? null,
                'charged_weight'      => $cargo['charged_weight'] ?? null,
                'document_no'         => $cargo['document_no'] ?? null,
                'document_name'       => $cargo['document_name'] ?? null,
                'document_date'       => $cargo['document_date'] ?? null,
                'eway_bill'           => $cargo['eway_bill'] ?? null,
                'valid_upto'          => $cargo['valid_upto'] ?? null,
            ];
        }
    }
      // ✅ Auto-generate LR number if not provided
    $lrNumber = $request->lr_number ?? 'LR-' . strtoupper(uniqid());

    // Step 2: Prepare single LR data
    $lrData = [
        'lr_number'           => $lrNumber,
        'lr_date'             => $request->lr_date,
        'vehicle_date'        => $request->vehicle_date,
        'vehicle_id'          => $request->vehicle_type,
        'vehicle_ownership'   => $request->vehicle_ownership,
        'delivery_mode'       => $request->delivery_mode,
        'from_location'       => $request->from_location,
        'to_location'         => $request->to_location,
    
        // Consignor
        'consignor_id'        => $request->consignor_id,
        'consignor_gst'       => $request->consignor_gst,
        'consignor_loading'   => $request->consignor_loading,
    
        // Consignee
        'consignee_id'        => $request->consignee_id,
        'consignee_gst'       => $request->consignee_gst,
        'consignee_unloading' => $request->consignee_unloading,
    
        // Charges
        'freight_amount'      => $request->freight_amount,
        'lr_charges'          => $request->lr_charges,
        'hamali'              => $request->hamali,
        'other_charges'       => $request->other_charges,
        'gst_amount'          => $request->gst_amount,
        'total_freight'       => $request->total_freight,
        'less_advance'        => $request->less_advance,
        'balance_freight'     => $request->balance_freight,
        'declared_value'      => $request->declared_value,
    
        // Cargo list
        'cargo'               => $cargoArray,
    ];
    
    // Step 3: Store LR data as array (wrapped in array so future multi-LR possible)
    $order->lr = json_encode([$lrData]);
    
    $order->save();
    
   

     return redirect()->route('admin.consignments.index')
    ->with('success', 'Single LR with multiple cargo stored successfully.');
}



  public function update(Request $request, $order_id)
{
    // 1. Find existing order by order_id
    $order = Order::where('order_id', $order_id)->firstOrFail();

    // ✅ Do not regenerate order_id — keep it same
    // ✅ Optional: You can update other main order-level fields here if needed

    // 2. Prepare cargo array
    $cargoArray = [];

    if (isset($request->cargo) && is_array($request->cargo)) {
        foreach ($request->cargo as $cargo) {
            $cargoArray[] = [
                'packages_no'         => $cargo['packages_no'] ?? null,
                'package_type'        => $cargo['package_type'] ?? null,
                'package_description' => $cargo['package_description'] ?? null,
                'weight'              => $cargo['weight'] ?? null,
                'actual_weight'       => $cargo['actual_weight'] ?? null,
                'charged_weight'      => $cargo['charged_weight'] ?? null,
                'document_no'         => $cargo['document_no'] ?? null,
                'document_name'       => $cargo['document_name'] ?? null,
                'document_date'       => $cargo['document_date'] ?? null,
                'eway_bill'           => $cargo['eway_bill'] ?? null,
                'valid_upto'          => $cargo['valid_upto'] ?? null,
            ];
        }
    }

    // 3. Prepare LR data
    $lrData = [
        'lr_number'           => $request->lr_number ?? 'LR-' . strtoupper(uniqid()),
        'lr_date'             => $request->lr_date,
        'vehicle_date'        => $request->vehicle_date,
        'vehicle_id'          => $request->vehicle_type,
        'vehicle_ownership'   => $request->vehicle_ownership,
        'delivery_mode'       => $request->delivery_mode,
        'from_location'       => $request->from_location,
        'to_location'         => $request->to_location,

        // Consignor
        'consignor_id'        => $request->consignor_id,
        'consignor_gst'       => $request->consignor_gst,
        'consignor_loading'   => $request->consignor_loading,

        // Consignee
        'consignee_id'        => $request->consignee_id,
        'consignee_gst'       => $request->consignee_gst,
        'consignee_unloading' => $request->consignee_unloading,

        // Charges
        'freight_amount'      => $request->freight_amount,
        'lr_charges'          => $request->lr_charges,
        'hamali'              => $request->hamali,
        'other_charges'       => $request->other_charges,
        'gst_amount'          => $request->gst_amount,
        'total_freight'       => $request->total_freight,
        'less_advance'        => $request->less_advance,
        'balance_freight'     => $request->balance_freight,
        'declared_value'      => $request->declared_value,

        // Cargo list
        'cargo'               => $cargoArray,
    ];

    // 4. Update the LR data
    $order->lr = json_encode([$lrData]);

    // 5. Save the updated order
    $order->save();

    return redirect()->route('admin.consignments.index')
        ->with('success', 'Order updated successfully with LR and Cargo.');
}


public function show($id)
{
    $orders = DB::table('orders')->get();

    foreach ($orders as $order) {
        $lrData = json_decode($order->lr, true);

       
        if (!is_array($lrData)) {
            $lrData = json_decode(json_decode($order->lr), true);
        }

        // dd($lrData); 

        if (is_array($lrData)) {
            foreach ($lrData as $entry) {
                if (isset($entry['lr_number']) && $entry['lr_number'] == $id) {
                    $lrEntries = $entry;

                    $vehicles = \App\Models\Vehicle::all();
                    $users = \App\Models\User::all();

                    return view('admin.consignments.view', compact('orders', 'order', 'lrEntries', 'vehicles', 'users'));
                }
            }
        }
    }

    return redirect()->back()->with('error', 'LR Number not found.');
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

        return view('admin.consignments.edit', compact('order', 'lrEntries','vehicles','users'));
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

