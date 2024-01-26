<?php

return [

    'defaults' => [
        'guard' => 'user',
        'passwords' => 'users',
    ],

    'guards' => [
        // 'web' => [
        //     'driver' => 'session',
        //     'provider' => 'users',
        // ],
        'user' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'auth0-session' => [
            'driver' => 'auth0.authenticator',
            'provider' => 'auth0-provider',
            'configuration' => 'web',
        ],
        'auth0-api' => [
            'driver' => 'auth0.authorizer',
            'provider' => 'auth0-provider',
            'configuration' => 'api',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'admin-staff' => [
            'driver' => 'session',
            'provider' => 'admin-staff',
        ],
        'staff' => [
            'driver' => 'session',
            'provider' => 'staff',
        ],
        'corporation' => [
            'driver' => 'session',
            'provider' => 'corporations',
        ],
        'business-operator' => [
            'driver' => 'session',
            'provider' => 'business-operators',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'auth0-provider' => [
            'driver' => 'auth0.provider',
            'repository' => 'auth0.repository',
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'admin-staff' => [
            'driver' => 'eloquent',
            'model' => App\Models\AdminStaff::class,
        ],

        'staff' => [
            'driver' => 'eloquent',
            'model' => App\Models\Staff::class,
        ],

        'corporations' => [
            'driver' => 'eloquent',
            'model' => App\Models\Corporation::class,
        ],

        'business-operators' => [
            'driver' => 'eloquent',
            'model' => App\Models\BusinessOperator::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'admin-staff' => [
            'provider' => 'admin-staff',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            // 'throttle' => 60,
        ],
        'staff' => [
            'provider' => 'staff',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'corporations' => [
            'provider' => 'corporations',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'business-operators' => [
            'provider' => 'business-operators',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
