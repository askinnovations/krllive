<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Tyre extends Model
{  

    use HasFactory;
    protected $table = 'tyres';
    protected $primaryKey = 'id';
    protected $guarded = [];
  
}