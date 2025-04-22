<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
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


}