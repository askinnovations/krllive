<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public function roles()
{
    return $this->belongsToMany(\Spatie\Permission\Models\Role::class, 'role_has_permissions');
}
}



