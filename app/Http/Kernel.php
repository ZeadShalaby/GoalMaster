<?php

namespace App\Http;

use App\Http\Middleware\AssignGuard;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class
            
        ],

        'api' => [
            
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        // 'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'verified' =>  \App\Http\Middleware\EnsurePhoneIsVerified::class,
        'phone.not.verified' => \App\Http\Middleware\EnsurePhoneNotVerified::class,
        'guest.phone.number.verification' => \App\Http\Middleware\GuestPhoneNumberVerfication::class,
        'permission'=>\App\Http\Middleware\PermissionHandle::class,
        'verifyUserType'=> \App\Http\Middleware\VerifyUserTypeMiddleware::class,
        'verifyWebsiteRoute'=> \App\Http\Middleware\VerifyWebsiteRouteMiddleware::class,        
        "xssProtection"=> \App\Http\Middleware\XSSProtection::class,
        "apiPermission"=> \App\Http\Middleware\ApiPermissionHandle::class,
        'jwt.auth.guard' => AssignGuard::class,
        'setLocale' => \App\Http\Middleware\SetLocale::class,
        'manager' => \App\Http\Middleware\Manager::class,
    ];
}
