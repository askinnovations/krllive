<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'rate',
        'to_destination_id', // Add the to_destination_id field
        'from_destination_id', // Add the from_destination_id field
    ];

    // User relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Vehicle relationship
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
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


