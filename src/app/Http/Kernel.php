<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ],

        'user' => [
            \App\Http\Middleware\EncryptCookies::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\HandleInertiaRequests::class,
            \App\Http\Middleware\User\CheckGuestUser::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ],

        'admin' => [
            \App\Http\Middleware\EncryptCookies::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ],

        'admin-staff' => [
            \App\Http\Middleware\EncryptCookies::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ],

        'staff' => [
            \App\Http\Middleware\EncryptCookies::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ],

        'business-operator' => [
            \App\Http\Middleware\EncryptCookies::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ],

        'corporation' => [
            \App\Http\Middleware\EncryptCookies::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            \Auth0\Laravel\Middleware\AuthenticatorMiddleware::class,
        ],

        'api' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Auth0\Laravel\Middleware\AuthorizerMiddleware::class,
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used instead of class names to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'admin' => \App\Http\Middleware\Admin\Authenticate::class,
        'user' => \App\Http\Middleware\User\Authenticate::class,
        'staff' => \App\Http\Middleware\Staff\Authenticate::class,
        'admin-staff' => \App\Http\Middleware\AdminStaff\Authenticate::class,
        'business-operator' => \App\Http\Middleware\BusinessOperator\Authenticate::class,
        'corporation' => \App\Http\Middleware\Corporation\Authenticate::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'admin.guest' => \App\Http\Middleware\Admin\RedirectIfAuthenticated::class,
        'user.guest' => \App\Http\Middleware\User\RedirectIfAuthenticated::class,
        'staff.guest' => \App\Http\Middleware\Staff\RedirectIfAuthenticated::class,
        'admin-staff.guest' => \App\Http\Middleware\AdminStaff\RedirectIfAuthenticated::class,
        'business-operator.guest' => \App\Http\Middleware\BusinessOperator\RedirectIfAuthenticated::class,
        'corporation.guest' => \App\Http\Middleware\Corporation\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,

        'user.tipId' => \App\Http\Middleware\User\TipIdMiddleware::class,

        'staff.notificationId' => \App\Http\Middleware\Staff\NotificationIdMiddleware::class,
        'staff.tipId' => \App\Http\Middleware\Staff\TipIdMiddleware::class,
        'staff.tipId.replyId' => \App\Http\Middleware\Staff\TipIdReplyIdMiddleware::class,

        'admin-staff.staff.tipId' => \App\Http\Middleware\AdminStaff\TipIdMiddleware::class,
        'admin-staff.staff.tipId.replyId' => \App\Http\Middleware\AdminStaff\TipIdReplyIdMiddleware::class,

        'business-operator.staffId' => \App\Http\Middleware\BusinessOperator\StaffIdMiddleware::class,
        'business-operator.adminStaffId' => \App\Http\Middleware\BusinessOperator\AdminStaffIdMiddleware::class,
        'business-operator.staff.tipId' => \App\Http\Middleware\BusinessOperator\TipIdMiddleware::class,
        'business-operator.staff.tipId.replyId' => \App\Http\Middleware\BusinessOperator\TipIdReplyIdMiddleware::class,
        'api.business-operator.staff.staffId' => \App\Http\Middleware\BusinessOperator\ApiStaffIdMiddleware::class,
        'api.business-operator.admin-staff.adminStaffId' => \App\Http\Middleware\BusinessOperator\ApiAdminStaffIdMiddleware::class,
    ];
}
