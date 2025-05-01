<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tyre;


class TyreController extends Controller
{
    public function index()
    {
        $tyres = Tyre::all();
        return view('admin.tyres.index', compact('tyres'));
    }
    public function store(Request $request)
    {
      
        $validatedData = $request->validate([
            'company' => 'required|string|max:255',
            'make_model' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'format' => 'required|string|max:255',
            'tyre_number' => 'required|string|max:255|unique:tyres,tyre_number',
            'tyre_health' => 'required|string|in:new,good,worn_out,needs_replacement',
        ]);

        $tyres = new Tyre();
        $tyres->company = $request->input('company');
        $tyres->make_model = $request->input('make_model');
        $tyres->description = $request->input('description');
        $tyres->format = $request->input('format');
        $tyres->tyre_number = $request->input('tyre_number');
        $tyres->tyre_health = $request->input('tyre_health');

        $tyres->save();
        if ($tyres->save()) {
            return redirect()->route('admin.tyres.index')->with('success', 'Tyre add Successfully.');

        }
        return redirect()->route('admin.tyres.index')->with('error', 'Failed to add  tyre.');
    }

   public function update(Request $request ,$id)
   {
    
       $tyres = Tyre::find($id);
        $validatedData = $request->validate([
            'company' => 'required|string|max:255',
            'make_model' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'format' => 'required|string|max:255',
            'tyre_number' => 'required|string',
            'tyre_health' => 'required|string|in:new,good,worn_out,needs_replacement',
        ]);
        $tyres->company = $request->input('company');
        $tyres->make_model = $request->input('make_model');
        $tyres->description = $request->input('description');
        $tyres->format = $request->input('format');
        $tyres->tyre_number = $request->input('tyre_number');
        $tyres->tyre_health = $request->input('tyre_health');
    
     
        $tyres->save();
        
        if ($tyres->save()) {
            return redirect()->route('admin.tyres.index')->with('success', 'Tyre updated Successfully.');

        }
        return redirect()->route('admin.tyres.index')->with('error', 'Failed update  tyre.');
    

   }
    public function destroy($id)
    {
        try {

            $tyre = Tyre::findOrFail($id);

            if ($tyre->delete()) {
                return redirect()->route('admin.tyres.index')->with('success', 'Tyre deleted successfully!');
            }

            return redirect()->route('admin.tyres.index')->with('error', 'Failed to delete the tyre.');
        } catch (Exception $e) {
            return redirect()->route('admin.tyres.index')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
  


}


