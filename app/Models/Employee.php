<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public function attendances()
{
    return $this->hasMany(Attendance::class);
}
public function tasks()
{
    return $this->hasMany(TaskManagement::class, 'assigned_to', 'id');
}
}
