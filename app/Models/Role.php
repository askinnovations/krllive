<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission;


// class Role extends Model
// {
    class Role extends SpatieRole
    {
        // Now you inherit Spatie's relationships and methods
    
    protected $table = 'roles';

    protected $primaryKey = 'id';
    protected $guarded = [];
    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }
    
    
}

