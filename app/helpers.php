<?php

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Support\Collection;

if (!function_exists('getAdminPermissions')) {
    function getAdminPermissions(): Collection
    {
        $admin = auth()->guard('admin')->user();
        $role = $admin ? \App\Models\Role::find($admin->role) : null;
        return $role ? $role->permission->pluck('name') : collect([]);
    }
}

if (!function_exists('hasAdminPermission')) {
    function hasAdminPermission(string $permission): bool
    {
        return getAdminPermissions()->contains($permission);
    }
}
