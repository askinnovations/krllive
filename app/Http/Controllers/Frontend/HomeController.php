<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Destination;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Helpers\CommonHelper;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('frontend.index');
    }
    public function about(Request $request)
    { 
        // dd($request->all());
        return view('frontend.about');
    }
    public function contact(Request $request)
    {
        return view('frontend.contact');
    }
    public function terms(Request $request)
    {
        return view('frontend.terms');
    }
    public function privacy(Request $request)
    {
        return view('frontend.privacy');
    }

    public function saveOrder(Request $request)
   {
        $user = Auth()->user();

        $lastId = Order::max('id') + 1;
        $generatedOrderId = 'ORD-' . str_pad($lastId, 6, '0', STR_PAD_LEFT);

        Order::create([
            'user_id' => $user->id,
            'order_id' => $generatedOrderId,
            'description' => $request->description,
            'from_destination_id' => $request->from_destination_id,
            'to_destination_id' => $request->to_destination_id,
            'order_date' => $request->order_date,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Order created successfully!');
   }

    






}