<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreightBill extends Model
{
    use HasFactory;
    protected $table = 'freight_bill';
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}



