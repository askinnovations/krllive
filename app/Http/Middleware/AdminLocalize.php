<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AdminLocalize
{
    public function handle(Request $request, Closure $next)
    {
        // ✅ Check if language exists in session, then set locale
        if (session()->has('admin_locale')) {
            App::setLocale(session('admin_locale'));
        }

        return $next($request);
    }
}
