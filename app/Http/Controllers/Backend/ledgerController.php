<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ledgerController extends Controller
{
    public function index()
    {
       
        return view('admin.ledger.index');
    }
  
    
    // Show Create Form
    public function create()
    {
        return view('admin.ledger_master.create'); // 🚀 Ensure You Have This View
    }
    
    
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'vehicle_type' => 'required|string',
            'vehicle_no' => 'required|string|unique:vehicles,vehicle_no',
           'registered_mobile_number' => 'required|numeric',
            'gvw' => 'nullable|string',
            'payload' => 'nullable|string',
            'chassis_number' => 'nullable|string',
            'engine_number' => 'nullable|string',
            'number_of_tyres' => 'nullable|integer',
            'rc_document_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rc_valid_from' => 'nullable|date|date_format:Y-m-d',
            'rc_valid_till' => 'nullable|date|date_format:Y-m-d',
            'fitness_certificate' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'fitness_valid_till' => 'nullable|date|date_format:Y-m-d',
            'insurance_document' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'insurance_valid_from' => 'nullable|date|date_format:Y-m-d',
            'insurance_valid_till' => 'nullable|date|date_format:Y-m-d',
            'authorization_permit' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'auth_permit_valid_from' => 'nullable|date|date_format:Y-m-d',
            'auth_permit_valid_till' => 'nullable|date|date_format:Y-m-d',
            'national_permit' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'national_permit_valid_from' => 'nullable|date|date_format:Y-m-d',
            'national_permit_valid_till' => 'nullable|date|date_format:Y-m-d',
            'tax_document' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tax_valid_from' => 'nullable|date|date_format:Y-m-d',
            'tax_valid_till' => 'nullable|date|date_format:Y-m-d',
        ]);
    
        
        
    
    $rcDocumentPath = null;
    $fitnessCertificatePath = null;
    $insuranceDocumentPath = null;
    $authorizationPermitPath = null;
    $nationalPermitPath = null;
    $taxDocumentPath = null;

    
    
    if ($request->hasFile('rc_document_file')) {
        $rcDocumentPath = $request->file('rc_document_file')->store('vehicals/rc', 'public');
    }
    if ($request->hasFile('fitness_certificate')) {
        $fitnessCertificatePath = $request->file('fitness_certificate')->store('vehicals/fitness', 'public');
    }
    if ($request->hasFile('insurance_document')) {
        $insuranceDocumentPath = $request->file('insurance_document')->store('vehicals/insurance', 'public');
    }
    if ($request->hasFile('authorization_permit')) {
        $authorizationPermitPath = $request->file('authorization_permit')->store('vehicals/auth_permit', 'public');
    }
    if ($request->hasFile('national_permit')) {
        $nationalPermitPath = $request->file('national_permit')->store('vehicals/national_permit', 'public');
    }
    if ($request->hasFile('tax_document')) {
        $taxDocumentPath = $request->file('tax_document')->store('vehicals/tax', 'public');
    }

    
        
        $vehicle = Vehicle::create([
          'vehicle_type' => $validatedData['vehicle_type'],
          'vehicle_no' => $validatedData['vehicle_no'],
          'registered_mobile_number' => $validatedData['registered_mobile_number'],
          'gvw' => $validatedData['gvw'] ?? null,
          'payload' => $validatedData['payload'] ?? null,
          'chassis_number' => $validatedData['chassis_number'] ?? null,
          'engine_number' => $validatedData['engine_number'] ?? null,
          'number_of_tyres' => $validatedData['number_of_tyres'] ?? null,
          'rc_document_file' => $rcDocumentPath,
          'rc_valid_from' => Carbon::parse($validatedData['rc_valid_from']),
          'rc_valid_till' => Carbon::parse($validatedData['rc_valid_till']),
          'fitness_certificate' => $fitnessCertificatePath,
          'insurance_document' => $insuranceDocumentPath,
          'fitness_valid_till' => isset($validatedData['fitness_valid_till']) ? Carbon::parse($validatedData['fitness_valid_till']) : null,
          'insurance_valid_from' => isset($validatedData['insurance_valid_from']) ? Carbon::parse($validatedData['insurance_valid_from']) : null,
          'insurance_valid_till' => isset($validatedData['insurance_valid_till']) ? Carbon::parse($validatedData['insurance_valid_till']) : null,
          'authorization_permit' => $authorizationPermitPath,
          'auth_permit_valid_from' => isset($validatedData['auth_permit_valid_from']) ? Carbon::parse($validatedData['auth_permit_valid_from']) : null,
          'auth_permit_valid_till' => isset($validatedData['auth_permit_valid_till']) ? Carbon::parse($validatedData['auth_permit_valid_till']) : null,
          'national_permit' => $nationalPermitPath,
          'national_permit_valid_from' => isset($validatedData['national_permit_valid_from']) ? Carbon::parse($validatedData['national_permit_valid_from']) : null,
          'national_permit_valid_till' => isset($validatedData['national_permit_valid_till']) ? Carbon::parse($validatedData['national_permit_valid_till']) : null,
          'tax_document' => $taxDocumentPath,
          'tax_valid_from' => isset($validatedData['tax_valid_from']) ? Carbon::parse($validatedData['tax_valid_from']) : null,
          'tax_valid_till' => isset($validatedData['tax_valid_till']) ? Carbon::parse($validatedData['tax_valid_till']) : null,
      ]);
      return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle created successfully!');
    }
    
    
   public function show($id)
   {
    $vehicle = Vehicle::findOrFail($id);
    return view('admin.vehicles.show', compact('vehicle'));
   }
    
   public function destroy($id)
   {
    $vehicle = Vehicle::findOrFail($id);
    $vehicle->delete();

    
    return response()->json(['message' => 'Vehicle deleted successfully.']);

   
}
 public function edit($id)
  {
    
    $vehicle = Vehicle::findOrFail($id);

    
    return view('admin.vehicles.edit', compact('vehicle'));
  }



  public function update(Request $request, $id)
{
    $vehicle = Vehicle::findOrFail($id);

    $validatedData = $request->validate([
        'vehicle_type' => 'required|string',
        'vehicle_no' => 'required|string|unique:vehicles,vehicle_no,' . $vehicle->id,
        'registered_mobile_number' => 'required|string',
        'gvw' => 'nullable|string',
        'payload' => 'nullable|string',
        'chassis_number' => 'nullable|string',
        'engine_number' => 'nullable|string',
        'number_of_tyres' => 'nullable|integer',
        'rc_document_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'rc_valid_from' => 'nullable|date|date_format:Y-m-d',
        'rc_valid_till' => 'nullable|date|date_format:Y-m-d',
        'fitness_certificate' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'fitness_valid_till' => 'nullable|date|date_format:Y-m-d',
        'insurance_document' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'insurance_valid_from' => 'nullable|date|date_format:Y-m-d',
        'insurance_valid_till' => 'nullable|date|date_format:Y-m-d',
        'authorization_permit' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'auth_permit_valid_from' => 'nullable|date|date_format:Y-m-d',
        'auth_permit_valid_till' => 'nullable|date|date_format:Y-m-d',
        'national_permit' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'national_permit_valid_from' => 'nullable|date|date_format:Y-m-d',
        'national_permit_valid_till' => 'nullable|date|date_format:Y-m-d',
        'tax_document' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'tax_valid_from' => 'nullable|date|date_format:Y-m-d',
        'tax_valid_till' => 'nullable|date|date_format:Y-m-d',
    ]);

    
    function updateFile($request, $field, $folder, $existingPath)
    {
        if ($request->hasFile($field)) {
            if ($existingPath && Storage::disk('public')->exists($existingPath)) {
                Storage::disk('public')->delete($existingPath);
            }
            return $request->file($field)->store("vehicals/{$folder}", 'public');
        }
        return $existingPath;
    }

    
    $vehicle->rc_document_file = updateFile($request, 'rc_document_file', 'rc', $vehicle->rc_document_file);
    $vehicle->fitness_certificate = updateFile($request, 'fitness_certificate', 'fitness', $vehicle->fitness_certificate);
    $vehicle->insurance_document = updateFile($request, 'insurance_document', 'insurance', $vehicle->insurance_document);
    $vehicle->authorization_permit = updateFile($request, 'authorization_permit', 'auth_permit', $vehicle->authorization_permit);
    $vehicle->national_permit = updateFile($request, 'national_permit', 'national_permit', $vehicle->national_permit);
    $vehicle->tax_document = updateFile($request, 'tax_document', 'tax', $vehicle->tax_document);

    
    $vehicle->update([
        'vehicle_type' => $validatedData['vehicle_type'],
        'vehicle_no' => $validatedData['vehicle_no'],
        'registered_mobile_number' => $validatedData['registered_mobile_number'],
        'gvw' => $validatedData['gvw'] ?? null,
        'payload' => $validatedData['payload'] ?? null,
        'chassis_number' => $validatedData['chassis_number'] ?? null,
        'engine_number' => $validatedData['engine_number'] ?? null,
        'number_of_tyres' => $validatedData['number_of_tyres'] ?? null,
        'rc_valid_from' => Carbon::parse($validatedData['rc_valid_from']),
        'rc_valid_till' => Carbon::parse($validatedData['rc_valid_till']),
        'fitness_valid_till' => isset($validatedData['fitness_valid_till']) ? Carbon::parse($validatedData['fitness_valid_till']) : null,
        'insurance_valid_from' => isset($validatedData['insurance_valid_from']) ? Carbon::parse($validatedData['insurance_valid_from']) : null,
        'insurance_valid_till' => isset($validatedData['insurance_valid_till']) ? Carbon::parse($validatedData['insurance_valid_till']) : null,
        'auth_permit_valid_from' => isset($validatedData['auth_permit_valid_from']) ? Carbon::parse($validatedData['auth_permit_valid_from']) : null,
        'auth_permit_valid_till' => isset($validatedData['auth_permit_valid_till']) ? Carbon::parse($validatedData['auth_permit_valid_till']) : null,
        'national_permit_valid_from' => isset($validatedData['national_permit_valid_from']) ? Carbon::parse($validatedData['national_permit_valid_from']) : null,
        'national_permit_valid_till' => isset($validatedData['national_permit_valid_till']) ? Carbon::parse($validatedData['national_permit_valid_till']) : null,
        'tax_valid_from' => isset($validatedData['tax_valid_from']) ? Carbon::parse($validatedData['tax_valid_from']) : null,
        'tax_valid_till' => isset($validatedData['tax_valid_till']) ? Carbon::parse($validatedData['tax_valid_till']) : null,
    ]);

    
    return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle updated successfully!');
}
      
  }
  

 
