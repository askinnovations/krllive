<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\FreightBill;
use App\Models\Destination;
use Illuminate\Support\Str;
use App\Models\Vehicle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class FreightBillController extends Controller
{
  

public function index()
{
    // Eager load Order → Consignor/Consignee
    // we only need the `order` relation—remove consignor/consignee here
    $bills = FreightBill::with('order')->get()
               ->groupBy('freight_bill_number');
            //    return($bills);


    // Pass the grouped collection to view
    return view('admin.freight-bill.index', compact('bills'));
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
    

    

    public function store(Request $request)
    {
        $selectedLrs = json_decode($request->input('selected_lrs'), true);
    
        if (!$selectedLrs || !is_array($selectedLrs)) {
            return back()->with('error', 'No LR selected.');
        }
    
        $freightBillNumber = 'FB' . now()->format('Ymd') . '-' . str_pad(FreightBill::count() + 1, 3, '0', STR_PAD_LEFT);
        $freightBillId = null;
    
        foreach ($selectedLrs as $item) {
            $order = Order::where('order_id', $item['order_id'])->first();
            $lrArray = is_array($order->lr) ? $order->lr : json_decode($order->lr, true);
            $matchedLr = collect($lrArray)->firstWhere('lr_number', $item['lr_number']);
    
            if ($matchedLr) {
                $freightBill = FreightBill::create([
                    'order_id' => $item['order_id'],
                    'freight_bill_number' => $freightBillNumber,
                    'lr_number' => $matchedLr['lr_number'],
                    'notes' => null,
                ]);
    
                if ($freightBillId === null) {
                    $freightBillId = $freightBill->id;
                }
            }
        }
    
        return redirect()->route('admin.freight-bill.view', $freightBillId)
            ->with('success', 'Freight bill generated successfully.');
    }
    


    public function show($id)
    {
        // 1) fetch the “anchor” FreightBill
        $anchor = FreightBill::with('order')->findOrFail($id);
    
        // 2) grab its bill-number, then all entries with that same bill-number
        $allEntries = FreightBill::where('freight_bill_number', $anchor->freight_bill_number)
                                 ->get();
    
        $matchedEntries = [];
    
        foreach ($allEntries as $entry) {
            // 3) for each FreightBill row, load the original Order
            $order = Order::where('order_id', $entry->order_id)->first();

            if (! $order) continue;
    
            // 4) decode that order’s JSON “lr” field
            $lrs = is_array($order->lr)
                   ? $order->lr
                   : json_decode($order->lr, true);
    
            // 5) find the one sub-array whose lr_number matches this entry
            foreach ($lrs as $lrDetail) {
                if (($lrDetail['lr_number'] ?? null) === $entry->lr_number) {
                    
                $lrDetail['destination'] = Destination::find($lrDetail['from_location'])->destination ?? '-';
                $lrDetail['destination'] = Destination::find($lrDetail['to_location'])->destination ?? '-';
                
             
                $lrDetail['freight_type'] = $order->order_method ?? '-';

                    $matchedEntries[] = $lrDetail;
                    break;
                }
            }
        }
    
        // 6) get the order once from anchor
        $order = $anchor->order;
    
        // 7) pass everything to view
        return view('admin.freight-bill.view', [
            'freightBill'    => $anchor,
            'matchedEntries' => $matchedEntries,
            'order'          => $order, 
        ]);
    }
    
    public function editByNumber($freight_bill_number)
    {
        $freightBills = FreightBill::where('freight_bill_number', $freight_bill_number)->get();
    
        if ($freightBills->isEmpty()) {
            abort(404, 'Freight Bill not found.');
        }
    
        $matchedEntries = [];
    
        foreach ($freightBills as $freightBill) {
            $order = Order::where('order_id', $freightBill->order_id)->first();
    
            if ($order) {
                $matchedEntries[] = [
                    'lr_number' => $freightBill->lr_number,
                    'lr_date' => $order->order_date,
                    'destination' => $order->from . ' - ' . $order->to,
                    'freight_type' => $order->order_method,
                    'rate' => $freightBill->rate ?? '-',
                    'amount' => $freightBill->amount ?? '-',
                    'cargo' => [
                        [
                            'package_description' => $order->description ?? '-',
                            'weight' => $freightBill->weight ?? '-',
                        ]
                    ]
                ];
            }
        }
    
        // Optionally send first order if needed
        $firstOrder = Order::where('order_id', $freightBills->first()->order_id)->first();
    
        return view('admin.freight-bill.edit', [
            'freightBillNumber' => $freight_bill_number,
            'order' => $firstOrder, // optional
            'matchedEntries' => $matchedEntries
        ]);
    }
    
    // नया update method
    public function update(Request $request, $freight_bill_number)
    {
        $data = $request->validate([
            'notes' => 'nullable|string|max:2000',
        ]);

        // सभी रिकॉर्ड्स में same notes अपडेट कर देते हैं
        FreightBill::where('freight_bill_number', $freight_bill_number)
                   ->update(['notes' => $data['notes']]);

        return redirect()
            ->route('admin.freight-bill.edit', $freight_bill_number)
            ->with('success', 'Notes updated successfully.');
    }


}