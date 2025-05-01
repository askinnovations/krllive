<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\Destination;
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
    $vehiclesType = VehicleType::all();
    $destination = Destination::all();
    $users = User::all();
    return view('admin.consignments.create', compact('vehicles','users','vehiclesType','destination'));
    }

    
    public function store(Request $request)
    {
        // return $request->all();
        // Step 1: Create a new order
        $order = new Order();
    
        // Generate unique order ID


        $order->order_id = 'ORD-' . time();
        $order->order_method = 'order';
        $order->byorder = $request->byOrder;
    
        $cargoArray = [];
    
        // Step 2: Handle Cargo Data
        if (isset($request->cargo) && is_array($request->cargo)) {
            foreach ($request->cargo as $cargo) {
                $documentFilePath = null;
    
                // Handle file upload if document is present
                if (isset($cargo['document_file']) && $cargo['document_file']->isValid()) {
                    $documentFile = $cargo['document_file'];
                    $documentFilePath = $documentFile->store('orders/cargo_documents/', 'public');
                }
    
                // Add cargo data to cargo array
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
                    'document_file'       => $documentFilePath,
                ];
            }
        }
    
        // Step 3: Handle freightType logic
        $freight_amount = $lr_charges = $hamali = $other_charges = $gst_amount = $total_freight = $less_advance = $balance_freight = null;
    
        if ($request->freightType !== 'to_be_billed') {
            $freight_amount = $request->freight_amount;
            $lr_charges = $request->lr_charges;
            $hamali = $request->hamali;
            $other_charges = $request->other_charges;
            $gst_amount = $request->gst_amount;
            $total_freight = $request->total_freight;
            $less_advance = $request->less_advance;
            $balance_freight = $request->balance_freight;
        }
    
        // Step 4: Prepare LR Data
        $lrData = [
            'lr_number'           => $request->lr_number ?? 'LR-' . strtoupper(uniqid()),
            'lr_date'             => $request->lr_date,
            'vehicle_no'          => $request->vehicle_no,
            'vehicle_type'        => $request->vehicle_type,
            'vehicle_ownership'   => $request->vehicle_ownership,
            'delivery_mode'       => $request->delivery_mode,
            'from_location'       => $request->from_location,
            'to_location'         => $request->to_location,
            'insurance_description' => $request->insurance_description,
            'insurance_status'    => $request->insurance_status,
            'total_declared_value' => $request->total_declared_value,
            'order_rate'         => $request->order_rate,
    
            // Consignor data
            'consignor_id'        => $request->consignor_id,
            'consignor_gst'       => $request->consignor_gst,
            'consignor_loading'   => $request->consignor_loading,
    
            // Consignee data
            'consignee_id'        => $request->consignee_id,
            'consignee_gst'       => $request->consignee_gst,
            'consignee_unloading' => $request->consignee_unloading,
    
            // Charges
            'freightType'         => $request->freightType,
            'freight_amount'      => $freight_amount,
            'lr_charges'          => $lr_charges,
            'hamali'              => $hamali,
            'other_charges'       => $other_charges,
            'gst_amount'          => $gst_amount,
            'total_freight'       => $total_freight,
            'less_advance'        => $less_advance,
            'balance_freight'     => $balance_freight,
    
            // Cargo list
            'cargo'               => $cargoArray,
        ];
    
        // Step 5: Store LR data as array (wrapped in array so future multi-LR possible)
        $order->lr = json_encode([$lrData]);
    
        // Save the order
        $order->save();
    
        // Redirect to consignments index with success message
        return redirect()->route('admin.consignments.index')
            ->with('success', 'Single LR with multiple cargo stored successfully.');
    }
    



    public function update(Request $request, $order_id)
    {
        $order = Order::where('order_id', $order_id)->firstOrFail();
        $order->order_method = 'order';
        $order->byorder = $request->byOrder;
        $cargoArray = [];
    
        // Loop through cargo entries if available
        if (isset($request->cargo) && is_array($request->cargo)) {
            foreach ($request->cargo as $cargo) {
                $documentFilePath = null;
    
                // Upload new file if available and valid
                if (isset($cargo['document_file']) && $cargo['document_file'] instanceof \Illuminate\Http\UploadedFile && $cargo['document_file']->isValid()) {
                    $documentFilePath = $cargo['document_file']->store('orders/cargo_documents/', 'public');
                }
                // Otherwise use the old file path
                elseif (isset($cargo['old_document_file'])) {
                    $documentFilePath = $cargo['old_document_file'];
                }
    
                $cargoArray[] = [
                    'packages_no'         => $cargo['packages_no'] ?? null,
                    'package_type'        => $cargo['package_type'] ?? null,
                    'package_description' => $cargo['package_description'] ?? null,
                    'declared_value'      => $cargo['declared_value'] ?? null,
                    'actual_weight'       => $cargo['actual_weight'] ?? null,
                    'charged_weight'      => $cargo['charged_weight'] ?? null,
                    'unit'                => $cargo['unit'] ?? null,
                    'document_no'         => $cargo['document_no'] ?? null,
                    'document_name'       => $cargo['document_name'] ?? null,
                    'document_date'       => $cargo['document_date'] ?? null,
                    'eway_bill'           => $cargo['eway_bill'] ?? null,
                    'valid_upto'          => $cargo['valid_upto'] ?? null,
                    'document_file'       => $documentFilePath,
                ];
            }
        }
    
        // Default freight-related fields
        $freight_amount = $lr_charges = $hamali = $other_charges = $gst_amount = $total_freight = $less_advance = $balance_freight = null;
    
        // Only assign freight values if not "to_be_billed"
        if ($request->freightType !== 'to_be_billed') {
            $freight_amount = $request->freight_amount;
            $lr_charges = $request->lr_charges;
            $hamali = $request->hamali;
            $other_charges = $request->other_charges;
            $gst_amount = $request->gst_amount;
            $total_freight = $request->total_freight;
            $less_advance = $request->less_advance;
            $balance_freight = $request->balance_freight;
        }
    
        $lrData = [
            'lr_number'              => $request->lr_number ?? 'LR-' . strtoupper(uniqid()),
            'lr_date'                => $request->lr_date,
            'vehicle_no'             => $request->vehicle_no,
            'vehicle_type'           => $request->vehicle_type,
            'vehicle_ownership'      => $request->vehicle_ownership,
            'delivery_mode'          => $request->delivery_mode,
            'from_location'          => $request->from_location,
            'to_location'            => $request->to_location,
            'insurance_status'       => $request->insurance_status,
            'insurance_description'  => $request->insurance_description,
    
            // Consignor
            'consignor_id'           => $request->consignor_id,
            'consignor_gst'          => $request->consignor_gst,
            'consignor_loading'      => $request->consignor_loading,
    
            // Consignee
            'consignee_id'           => $request->consignee_id,
            'consignee_gst'          => $request->consignee_gst,
            'consignee_unloading'    => $request->consignee_unloading,
    
            // Charges
            'freightType'            => $request->freightType,
            'freight_amount'         => $freight_amount,
            'lr_charges'             => $lr_charges,
            'hamali'                 => $hamali,
            'other_charges'          => $other_charges,
            'gst_amount'             => $gst_amount,
            'total_freight'          => $total_freight,
            'less_advance'           => $less_advance,
            'balance_freight'        => $balance_freight,
            'total_declared_value'   => $request->total_declared_value,
            'order_rate'             => $request->order_rate,
    
            // Cargo list
            'cargo'                  => $cargoArray,
        ];
    
        $order->lr = json_encode([$lrData]);
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


public function docView($id)
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
                    return view('admin.consignments.documents', compact( 'lrEntries'));
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
        $vehiclesType = VehicleType::all();
        $destination = Destination::all();
        
        $lrEntries = Order::where('order_id', $order->order_id)
                        ->where('order_date', '!=', $order->order_date) 
                        ->get();

        return view('admin.consignments.edit', compact('order', 'lrEntries','vehicles','users','vehiclesType','destination'));
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

