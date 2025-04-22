<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Show dashboard to logged-in user
    public function dashboard()
    {
        $user = Auth::user(); // Logged-in user info
        return view('frontend.dashboard', compact('user'));
    }
}

