<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\User; 

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminDashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:view dashboard', only: ['index']),
            // new Middleware('admin.permission:create dashboard', only: ['create']),
            // new Middleware('admin.permission:edit dashboard', only: ['edit']),
            // new Middleware('admin.permission:delete dashboard', only: ['destroy']),
        ];
    }

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
