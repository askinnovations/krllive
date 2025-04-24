<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Destination;
use App\Models\Order;

class DashboardController extends Controller
{
    // Show dashboard to logged-in user
    public function dashboard()
    {
        // dd(Auth::user()); // Debug: Check current logged in user
        $user = Auth::user(); // Get logged in user
        $orders = Order::with(['fromDestination','toDestination'])
                   ->where('user_id', auth()->id())
                   ->latest()
                   ->get();

        return view('frontend.dashboard', compact('user','orders'));
    }
    public function profile()
    {
       
        $user = Auth()->user();
        return view('frontend.profile', compact('user'));
    }

    public function updateProfile(Request $request)
   {   
        // return ($request->all());

        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'pan_number' => $request->pan_number,
            'tan_number' => $request->tan_number,
            'address' => json_encode($request->address),
        ]);

        return back()->with('success', 'Profile updated successfully');
   }
   
   public function OrderDetails($order_id)
  {
    $order = Order::with('user')->where('order_id', $order_id)->first();
    
    if (!$order) {
        return back()->with('error', 'Order not found.');
    }

    return view('frontend.order-details', compact('order'));
  }

}

