<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; 
class Admin extends Authenticatable
{
    use Notifiable, HasRoles; 
    use Notifiable;

    protected $guard = 'admin'; 
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function role() {
        return $this->belongsTo(Role::class);
    }
}
