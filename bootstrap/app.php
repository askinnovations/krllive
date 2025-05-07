<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
     
        $middleware->alias([
            'auth.admin' => \App\Http\Middleware\AuthenticateAdmin::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'admin.permission' => \App\Http\Middleware\AdminHasPermission::class,
            'admin.guest' => \App\Http\Middleware\RedirectIfAuthenticatedAdmin::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
    })
    ->create();
