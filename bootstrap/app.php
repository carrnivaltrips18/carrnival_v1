<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register global middleware, e.g., for sessions, CSRF protection
        // $middleware->global([
        //     \App\Http\Middleware\EncryptCookies::class,
        //     \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        //     \Illuminate\Session\Middleware\StartSession::class,
        //     \Illuminate\Session\Middleware\AuthenticateSession::class,
        //     \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        //     \App\Http\Middleware\VerifyCsrfToken::class,
        //     \Illuminate\Routing\Middleware\SubstituteBindings::class,
        // ]);

         // Register route-specific middleware
        // $middleware->route('auth', \App\Http\Middleware\Authenticate::class);
         //$middleware->route('admin', \App\Http\Middleware\AdminMiddleware::class);  // Custom admin guard middleware
         $middleware ->alias([
            //'admin.guest' => \App\Http\Middleware\AdminRedirect::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
        ]);



        // $middleware ->redirectTo(
        //     guests: '/login',
        //     users: '/dashboard'
        // );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
    })->create();
