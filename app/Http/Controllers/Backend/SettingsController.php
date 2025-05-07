<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class SettingsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:manage settings', only: ['index']),
            new Middleware('admin.permission:create settings', only: ['create']),
            new Middleware('admin.permission:edit settings', only: ['edit']),
            new Middleware('admin.permission:delete settings', only: ['destroy']),
        ];
    }
    public function index()
    {   
      $settings = Settings::first();
      return view('admin.settings.index', compact('settings')); 
    }

    public function store(Request $request)
    {
      

        $settings = Settings::first();

        if (!$settings) {
            $settings = new Settings();
        }

        // Image upload logic
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $settings->logo = $filename;
        }

        $settings->head_office       = $request->head_office;
        $settings->mobile            = $request->mobile;
        $settings->offices           = $request->offices;
        $settings->email             = $request->email;
        $settings->website           = $request->website;
        $settings->transporter       = $request->transporter;
        $settings->type              = $request->type;
        $settings->rcm_description   = $request->type == 'rcm' ? $request->rcm_description : null;
        $settings->fcm_code          = $request->type == 'fcm' ? $request->fcm_code : null;

        $settings->save();
        // dd($settings->save());

        return redirect()->route('admin.settings.index')->withwith('success', 'Settings updated successfully!');
    }


}
