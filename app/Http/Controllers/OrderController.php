<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

use App\Models\Order;
use App\Models\Vehicle;
use App\Models\User;


class OrderController extends Controller
{
    public function  index(){

    $orders = Order::latest()->get();

    return view('admin.orders.index', compact('orders'));
    }
    
    public function create()
   {
    $vehicles = Vehicle::all();
    $users = User::all();
    return view('admin.orders.create', compact('vehicles', 'users'));
   }

   public function edit($order_id)
   {
       $vehicles = Vehicle::all();
       $users = User::all();
       $order = Order::where('order_id', $order_id)->first();
   
       // Only decode if it's a string
       if (is_string($order->lr)) {
           $order->lr = json_decode($order->lr, true);
       }
   
    //    return $order->lr;
   
       return view('admin.orders.edit', compact('order', 'vehicles', 'users'));
   }
   

    public function show($order_id){
    
        $vehicles = Vehicle::all();
        $users = User::all();
        $order = Order::where('order_id', $order_id)->first();
   
        // Only decode if it's a string
        if (is_string($order->lr)) {
            $order->lr = json_decode($order->lr, true);
        }

        return view('admin.orders.view', compact('order','vehicles','users'));
    }


public function store(Request $request)
{
    $order = new Order();
    $order->order_id = 'ORD-' . time();
    $order->description = $request->description;
    $order->order_date = $request->order_date;
    $order->status = $request->status;
    $order->order_type = $request->order_type;
    $order->cargo_description_type = $request->cargo_description_type;

    $order->customer_id = $request->customer_id;
    $order->customer_gst = $request->gst_number;
    $order->customer_address = $request->customer_address;

    // Prepare LR Data
    $lrArray = [];

    foreach ($request->lr as $key => $lr) {
        $cargoArray = [];

        // Loop through each cargo inside LR
        if (isset($lr['cargo']) && is_array($lr['cargo'])) {
            foreach ($lr['cargo'] as $cargo) {
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

        // Add the LR with cargo array
        $lrArray[$key] = [
            'lr_number'          => $lr['lr_number'] ?? ('LR-' . time() . '-' . $key),
            'lr_date'            => $lr['lr_date'] ?? null,
            'vehicle_date'       => $lr['vehicle_date'] ?? null,
            'vehicle_id'         => $lr['vehicle_id'] ?? null,
            'vehicle_ownership'  => $lr['vehicle_ownership'] ?? null,
            'delivery_mode'      => $lr['delivery_mode'] ?? null,
            'from_location'      => $lr['from_location'] ?? null,
            'to_location'        => $lr['to_location'] ?? null,

            // Consignor
            'consignor_id'       => $lr['consignor_id'] ?? null,
            'consignor_gst'      => $lr['consignor_gst'] ?? null,
            'consignor_loading'  => $lr['consignor_loading'] ?? null,

            // Consignee
            'consignee_id'       => $lr['consignee_id'] ?? null,
            'consignee_gst'      => $lr['consignee_gst'] ?? null,
            'consignee_unloading'=> $lr['consignee_unloading'] ?? null,

            // Charges
            'freight_amount'     => $lr['freight_amount'] ?? null,
            'lr_charges'         => $lr['lr_charges'] ?? null,
            'hamali'             => $lr['hamali'] ?? null,
            'other_charges'      => $lr['other_charges'] ?? null,
            'gst_amount'         => $lr['gst_amount'] ?? null,
            'total_freight'      => $lr['total_freight'] ?? null,
            'less_advance'       => $lr['less_advance'] ?? null,
            'balance_freight'    => $lr['balance_freight'] ?? null,
            'declared_value'     => $lr['declared_value'] ?? null,

            // Nested cargo
            'cargo'              => $cargoArray,
        ];
    }

    // Save full LR array (associative) as JSON
    $order->lr = $lrArray;

    $order->save();

    return redirect()->route('admin.orders.index')
        ->with('success', 'Order stored with nested LR and cargo arrays successfully!');
}

public function update(Request $request, $order_id)
{
    // 1. Find the Order and update its fields
    $order = Order::findOrFail($order_id);
    
    // Update order fields
    $order->description = $request->description;
    $order->order_date = $request->order_date;
    $order->status = $request->status;
    $order->order_type = $request->order_type;
    $order->cargo_description_type = $request->cargo_description_type;
    $order->customer_id = $request->customer_id;
    $order->customer_gst = $request->gst_number;
    $order->customer_address = $request->customer_address;

    // Prepare LRs array for updating
    $lrArray = [];

    // Loop through each LR and update
    foreach ($request->lr as $lrKey => $lr) {
        // Skip empty LRs
        if (
            empty($lr['lr_date']) && 
            empty($lr['consignor_id']) && 
            empty($lr['consignor_gst']) &&
            empty($lr['consignor_loading'])
        ) {
            continue;
        }

        // Prepare cargos for the current LR
        $cargoArray = [];
        if (!empty($lr['cargo']) && is_array($lr['cargo'])) {
            foreach ($lr['cargo'] as $cargoKey => $cargo) {
                // Skip empty cargo rows
                if (
                    empty($cargo['packages_no']) &&
                    empty($cargo['package_type']) &&
                    empty($cargo['package_description']) &&
                    empty($cargo['weight']) &&
                    empty($cargo['document_no'])
                ) {
                    continue;
                }

                // Add cargo row to the cargoArray
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

        // LR Number (preserve if already exists or generate new)
        $lrNumber = $lr['lr_number'] ?? 'LR-' . now()->format('YmdHis') . '-' . $lrKey;

        // Add LR data to lrArray
        $lrArray[] = [
            'lr_number'           => $lrNumber,
            'lr_date'             => $lr['lr_date'] ?? null,
            'vehicle_date'        => $lr['vehicle_date'] ?? null,
            'vehicle_id'          => $lr['vehicle_id'] ?? null,
            'vehicle_ownership'   => $lr['vehicle_ownership'] ?? null,
            'delivery_mode'       => $lr['delivery_mode'] ?? null,
            'from_location'       => $lr['from_location'] ?? null,
            'to_location'         => $lr['to_location'] ?? null,

            'consignor_id'        => $lr['consignor_id'] ?? null,
            'consignor_gst'       => $lr['consignor_gst'] ?? null,
            'consignor_loading'   => $lr['consignor_loading'] ?? null,

            'consignee_id'        => $lr['consignee_id'] ?? null,
            'consignee_gst'       => $lr['consignee_gst'] ?? null,
            'consignee_unloading' => $lr['consignee_unloading'] ?? null,

            'freight_amount'      => $lr['freight_amount'] ?? null,
            'lr_charges'          => $lr['lr_charges'] ?? null,
            'hamali'              => $lr['hamali'] ?? null,
            'other_charges'       => $lr['other_charges'] ?? null,
            'gst_amount'          => $lr['gst_amount'] ?? null,
            'total_freight'       => $lr['total_freight'] ?? null,
            'less_advance'        => $lr['less_advance'] ?? null,
            'balance_freight'     => $lr['balance_freight'] ?? null,
            'declared_value'      => $lr['declared_value'] ?? null,

            'cargo'               => $cargoArray, // Attach cargos
        ];
    }

    // Save the updated LRs and Order
    $order->lr = $lrArray;
    $order->save();

    // Redirect with success message
    return redirect()->route('admin.orders.index')
        ->with('success', 'Order and LRs updated successfully!');
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
