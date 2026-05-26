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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // Disable CSRF for admin, auth, and API routes
        $middleware->validateCsrfTokens(except: [
            'admin/*',
            'password/otp/*',
            'api/*',
            'login',
            'register',
            'forgot-password',
            'reset-password',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
