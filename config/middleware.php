<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Web Middleware Groups
    |--------------------------------------------------------------------------
    |
    | Define middleware groups for web routes.
    |
    */
    'web' => [
        \App\Http\Middleware\ForceHttpsUrls::class,
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | API Middleware Groups
    |--------------------------------------------------------------------------
    |
    | Define middleware groups for API routes.
    |
    */
    'api' => [
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Individual Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware may be assigned to groups or used individually.
    |
    */
    'aliases' => [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Register Spatie's permission middleware
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    ],
];
