<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\User; 

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{

            public function index()
        {   
            
            if (!auth()->guard('admin')->check()) {
                return redirect()->route('admin.login');
            }
            else{
                return view('admin.dashboard');

            }
    }

}
