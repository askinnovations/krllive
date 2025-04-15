<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskManagement extends Model
{
    protected $table = 'task_managements';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public function assignedEmployee()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }
}
