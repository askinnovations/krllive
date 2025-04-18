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
   
       
       if (is_string($order->lr)) {
           $order->lr = json_decode($order->lr, true);
       }
   
 
   
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
    public function docView($order_id){
    
      
        $order = Order::where('order_id', $order_id)->first();
   
        // Only decode if it's a string
        if (is_string($order->lr)) {
            $order->lr = json_decode($order->lr, true);
        }

        return view('admin.orders.documents', compact('order'));
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
        
        $order->deleiver_addresss = $request->deleiver_addresss;
        $order->pickup_addresss = $request->pickup_addresss;
        $order->order_method = $request->order_method;
        $order->byorder = $request->byOrder;
        $order->bycontract = $request->byContract;
        
    
        // Prepare LR Data
        $lrArray = [];
    
        foreach ($request->lr as $key => $lr) {
            $cargoArray = [];
    
            // Loop through each cargo inside LR
            if (isset($lr['cargo']) && is_array($lr['cargo'])) {
                foreach ($lr['cargo'] as $cargo) {
                    $documentFilePath = null;
    
                    // Handle image file upload
                    if (isset($cargo['document_file']) && $cargo['document_file']->isValid()) {
                        $documentFile = $cargo['document_file'];
                       
                        $documentFilePath = $documentFile->store('orders/cargo_documents/', 'public');
                    }
    
                    $cargoArray[] = [
                        'packages_no'         => $cargo['packages_no'] ?? null,
                        'package_type'        => $cargo['package_type'] ?? null,
                        'package_description' => $cargo['package_description'] ?? null,
                        'actual_weight'       => $cargo['actual_weight'] ?? null,
                        'charged_weight'      => $cargo['charged_weight'] ?? null,
                        'document_no'         => $cargo['document_no'] ?? null,
                        'document_name'       => $cargo['document_name'] ?? null,
                        'document_date'       => $cargo['document_date'] ?? null,
                        'document_file'       => $documentFilePath,  // Save the file path
                        'declared_value'      => $cargo['declared_value'] ?? null,
                        'eway_bill'           => $cargo['eway_bill'] ?? null,
                        'valid_upto'          => $cargo['valid_upto'] ?? null,
                        'unit'                => $cargo['unit'] ?? null,
                    ];
                }
            }
    
            // Add the LR with cargo array
            $lrArray[$key] = [
                'lr_number'          => $lr['lr_number'] ?? ('LR-' . time() . '-' . $key),
                'lr_date'            => $lr['lr_date'] ?? null,
                'vehicle_no'         => $lr['vehicle_no'] ?? null,
                'vehicle_type'       => $lr['vehicle_type'] ?? null,
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
                'freightType'        => $lr['freightType'] ?? null,
                'freight_amount'     => $lr['freight_amount'] ?? null,
                'lr_charges'         => $lr['lr_charges'] ?? null,
                'hamali'             => $lr['hamali'] ?? null,
                'other_charges'      => $lr['other_charges'] ?? null,
                'gst_amount'         => $lr['gst_amount'] ?? null,
                'total_freight'      => $lr['total_freight'] ?? null,
                'less_advance'       => $lr['less_advance'] ?? null,
                'balance_freight'    => $lr['balance_freight'] ?? null,
                'total_declared_value'=> $lr['total_declared_value'] ?? null,
    
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
    //   return $request->all();
   
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

    $order->deleiver_addresss = $request->deleiver_addresss;
    $order->pickup_addresss = $request->pickup_addresss;
    $order->order_method = $request->order_method;
    $order->byorder = $request->byOrder;
    $order->bycontract = $request->byContract;

    // Existing LRs from DB
    $existingLrs = $order->lr ?? [];
    $existingLrMap = collect($existingLrs)->keyBy('lr_number')->toArray();

    $updatedLrs = [];

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

        // Prepare cargos
        $cargoArray = [];
        if (!empty($lr['cargo']) && is_array($lr['cargo'])) {
            foreach ($lr['cargo'] as $cargo) {
                if (
                    empty($cargo['packages_no']) &&
                    empty($cargo['package_type']) &&
                    empty($cargo['package_description']) &&
                    empty($cargo['weight']) &&
                    empty($cargo['document_no'])
                ) {
                    continue;
                }
                $documentFilePath = null;

                if (
                    isset($cargo['document_file']) &&
                    $cargo['document_file'] instanceof \Illuminate\Http\UploadedFile &&
                    $cargo['document_file']->isValid()
                ) {
                    // New file uploaded — store it
                    $documentFilePath = $cargo['document_file']->store('orders/cargo_documents', 'public');
                } elseif (
                    isset($cargo['document_file']) &&
                    is_string($cargo['document_file'])
                ) {
                    // Already stored file path — just reuse it
                    $documentFilePath = $cargo['document_file'];
                }
                $cargoArray[] = [
                    'packages_no'         => $cargo['packages_no'] ?? null,
                    'package_type'        => $cargo['package_type'] ?? null,
                    'package_description' => $cargo['package_description'] ?? null,
                   
                    'actual_weight'       => $cargo['actual_weight'] ?? null,
                    'charged_weight'      => $cargo['charged_weight'] ?? null,
                    'document_no'         => $cargo['document_no'] ?? null,
                    'document_name'       => $cargo['document_name'] ?? null,
                    'document_date'       => $cargo['document_date'] ?? null,
                    'eway_bill'           => $cargo['eway_bill'] ?? null,
                    'valid_upto'          => $cargo['valid_upto'] ?? null,
                    'declared_value'      => $cargo['declared_value'] ?? null,
                    'unit'      => $cargo['unit'] ?? null,
                    'document_file'       => $documentFilePath,
                ];
            }
        }

        // Get lr_number
        $lrNumber = $lr['lr_number'] ?? 'LR-' . now()->format('YmdHis') . '-' . $lrKey;

        // Prepare LR Data
        $lrData = [
            'lr_number'           => $lrNumber,
            'lr_date'             => $lr['lr_date'] ?? null,
            'vehicle_no'        => $lr['vehicle_no'] ?? null,
            'vehicle_type'          => $lr['vehicle_type'] ?? null,
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
            'total_declared_value'=> $lr['total_declared_value'] ?? null,
            'cargo'               => $cargoArray,
        ];

        // Update if exists or add as new
        $existingLrMap[$lrNumber] = $lrData;
    }

    // Save updated LR array
    $order->lr = array_values($existingLrMap); // Re-index the array
    $order->save();

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
