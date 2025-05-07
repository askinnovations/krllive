<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class DestinationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin.permission:view destination', only: ['index']),
            new Middleware('admin.permission:create destination', only: ['create']),
            new Middleware('admin.permission:edit destination', only: ['edit']),
            new Middleware('admin.permission:delete destination', only: ['destroy']),
        ];
    }
    public function index()
    {
        $tyres = Destination::all();
        return view('admin.destination.index', compact('tyres'));
    }
    public function store(Request $request)
    {  
        $validatedData = $request->validate([
            'destination' => 'required|string|max:255',
            
        ]);

        $tyres = new Destination();
        $tyres->destination = $request->input('destination');
        

        $tyres->save();
        if ($tyres->save()) {
            return redirect()->route('admin.destination.index')->with('success', 'Destination add Successfully.');

        }
        return redirect()->route('admin.destination.index')->with('error', 'Failed to add  Destination.');
    }

   public function update(Request $request ,$id)
   {
    
       $tyres = Destination::find($id);
        $validatedData = $request->validate([
            'destination' => 'required|string|max:255',
            
        ]);
        $tyres->destination = $request->input('destination');
        
    
     
        $tyres->save();
        
        if ($tyres->save()) {
            return redirect()->route('admin.destination.index')->with('success', 'Destination updated Successfully.');

        }
        return redirect()->route('admin.destination.index')->with('error', 'Failed update  tyre.');
    

   }
    public function destroy($id)
    {
        try {

            $tyre = Destination::findOrFail($id);

            if ($tyre->delete()) {
                return redirect()->route('admin.destination.index')->with('success', 'Destination deleted successfully!');
            }

            return redirect()->route('admin.destination.index')->with('error', 'Failed to delete the tyre.');
        } catch (Exception $e) {
            return redirect()->route('admin.destination.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
