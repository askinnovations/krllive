<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreightBill extends Model
{
    use HasFactory;
    protected $table = 'freight_bill';
    
    protected $fillable = [
        'order_id',
        'freight_bill_number',
        'lr_number',
        'notes',
    ];

    // हर FreightBill entry का Order relation
    public function order()
    {
        // order_id फील्ड में Order::order_id से लिंक
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
    
}



