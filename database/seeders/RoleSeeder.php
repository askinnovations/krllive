<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Step 1: Permissions
        $permissions = [
            'create orders',
            'edit orders',
            'delete orders',
            'add orders',
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Step 2: Roles and their permissions
        $roles = [
            'Admin' => [
                'create orders',
                'edit orders',
                'delete orders',
                'view dashboard',
            ],
            'Manager' => [
                'add orders',
                'edit orders',
                'view dashboard',
            ],
            'Viewer' => [
                'view dashboard',
            ]
        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);

            $role->syncPermissions($perms); // Attach permissions
        }
    }
}
