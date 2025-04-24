<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'rate',
        'to_destination_id', // Add the to_destination_id field
        'from_destination_id', // Add the from_destination_id field
        'user_id' 
    ];

    // User relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    

    public function vehicle()
    {
        return $this->belongsTo(VehicleType::class, 'type_id');
    }

    // To Destination relationship (for to_destination_id)
    public function toDestination()
    {
        return $this->belongsTo(Destination::class, 'to_destination_id');
    }

    // From Destination relationship (for from_destination_id)
    public function fromDestination()
    {
        return $this->belongsTo(Destination::class, 'from_destination_id');
    }
}


