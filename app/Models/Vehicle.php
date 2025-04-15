<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles'; // Table Name

    protected $fillable = [
        'vehicle_type',
        'vehicle_no',
        'registered_mobile_number',
        'gvw',
        'payload',
        'chassis_number',
        'engine_number',
        'number_of_tyres',
        'rc_document_file',
        'insurance_document',
       
        'national_permit',
        'tax_document',
        'rc_valid_from',
        'rc_valid_till',
        'fitness_certificate', 
        'authorization_permit', 
         
        'fitness_valid_till',
        'insurance_valid_from',
        'insurance_valid_till',
        'auth_permit_valid_from',
        'auth_permit_valid_till',
        'national_permit_valid_from',
        'national_permit_valid_till',
        'tax_valid_from',
        'tax_valid_till',
    ];

    // protected $casts = [
    //     'fitness_certificates' => 'array', // JSON Data Casting
    //     'insurances' => 'array',
    //     'authorization_permits' => 'array',
    //     'national_permits' => 'array',
    //     'taxes' => 'array',
    //     'rc_valid_from' => 'date',
    //     'rc_valid_till' => 'date',
    //     'fitness_valid_till' => 'date',
    //     'insurance_valid_from' => 'date',
    //     'insurance_valid_till' => 'date',
    //     'auth_permit_valid_from' => 'date',
    //     'auth_permit_valid_till' => 'date',
    //     'national_permit_valid_from' => 'date',
    //     'national_permit_valid_till' => 'date',
    //     'tax_valid_from' => 'date',
    //     'tax_valid_till' => 'date',
    // ];

    public function orders()
{
    return $this->hasMany(Order::class, 'vehicle_id');
}

}