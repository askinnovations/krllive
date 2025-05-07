<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PackageType;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class PackageTypeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:manage package_type', only: ['index']),
            new Middleware('admin.permission:create package_type', only: ['create']),
            new Middleware('admin.permission:edit package_type', only: ['edit']),
            new Middleware('admin.permission:delete package_type', only: ['destroy']),
        ];
    }
    public function index()
    {
        $tyres = PackageType::all();
        return view('admin.packagetype.index', compact('tyres'));
    }
    public function store(Request $request)
    {  
        
      
        $validatedData = $request->validate([
            'package_type' => 'required|string|max:255',
            
        ]);

        $tyres = new PackageType();
        $tyres->package_type = $request->input('package_type');
        

        $tyres->save();
        if ($tyres->save()) {
            return redirect()->route('admin.packagetype.index')->with('success', 'packagetype add Successfully.');

        }
        return redirect()->route('admin.packagetype.index')->with('error', 'Failed to add  packagetype.');
    }

   public function update(Request $request ,$id)
   {
    
       $tyres = PackageType::find($id);
        $validatedData = $request->validate([
            'package_type' => 'required|string|max:255',
            
        ]);
        $tyres->package_type = $request->input('package_type');
        
    
     
        $tyres->save();
        
        if ($tyres->save()) {
            return redirect()->route('admin.packagetype.index')->with('success', 'packagetype updated Successfully.');

        }
        return redirect()->route('admin.packagetype.index')->with('error', 'Failed update  tyre.');
    

   }
    public function destroy($id)
    {
        try {

            $tyre = PackageType::findOrFail($id);

            if ($tyre->delete()) {
                return redirect()->route('admin.packagetype.index')->with('success', 'packagetype deleted successfully!');
            }

            return redirect()->route('admin.packagetype.index')->with('error', 'Failed to delete the tyre.');
        } catch (Exception $e) {
            return redirect()->route('admin.packagetype.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
  


}
