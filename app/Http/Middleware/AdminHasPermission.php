<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class AdminHasPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        
        $admin = auth()->guard('admin')->user();

       
        if (!$admin) {
            abort(403, 'Unauthorized'); // Admin not authenticated
        }

      
        $roleId = $admin->role;

      
        $role = Role::find($roleId);

      
        if (!$role || !method_exists($role, 'permission')) {
            abort(403, 'Role or permissions not configured');
        }

       
        if (!$role->permission->pluck('name')->contains($permission)) {
            abort(404, 'Permission not found');
        }

        return $next($request);
    }
}