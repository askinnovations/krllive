<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Spatie\Permission\Models\Permission;
class Permission extends Model
{
    
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $guarded = [];

   

public function roles()
{
    return $this->belongsToMany(\Spatie\Permission\Models\Role::class, 'role_has_permissions');
}
  
}
