<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders'; 
    protected $primaryKey = 'order_id'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $fillable = [
        'order_id', 'description', 'order_date', 'status', 'order_type', 'cargo_description_type',
        'customer_id', 'customer_gst', 'customer_address',
        'consignor_id', 'consignor_gst', 'consignor_loading',
        'consignee_id', 'consignee_gst', 'consignee_unloading',
        'lr_number', 'lr_date', 'vehicle_date', 'vehicle_id', 'vehicle_ownership',
        'delivery_mode', 'from_location', 'to_location',
        'freight_amount', 'lr_charges', 'hamali', 'other_charges', 'gst_amount',
        'total_freight', 'less_advance', 'balance_freight', 'declared_value',
        'packages_no', 'package_type', 'package_description', 'weight',
        'actual_weight', 'charged_weight', 'document_no', 'document_name',
        'document_date', 'eway_bill', 'valid_upto'
    ];
    
    protected $casts = [
        'lr' => 'array',
    ];
    
    // Relationships
    
    public function consignor()
   {
    return $this->belongsTo(User::class, 'consignor_id');
   }

    public function consignee()
    {
        return $this->belongsTo(User::class, 'consignee_id');
    }
    
    public function customer()
    {
    return $this->belongsTo(User::class, 'customer_id');
    }
    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }


}
