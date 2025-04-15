<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = 'maintenances';
    protected $primaryKey = 'id';
    protected $fillable = ['vehicle', 'category', 'vendor','odometer_reading', 'autoparts'];

    protected $casts = [
        'autoparts' => 'array', // Laravel will decode it automatically
    ];
}
