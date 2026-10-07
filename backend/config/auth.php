<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'guard'     => 'api',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [
        'api' => [
            'driver'   => 'jwt',
            'provider' => 'users',
        ],

        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Modules\Users\Models\User::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

    /*
    |--------------------------------------------------------------------------
    | JWT Settings (tymon/jwt-auth)
    |--------------------------------------------------------------------------
    */
    'jwt' => [
        'ttl'              => env('JWT_TTL', 60),            // minutes
        'refresh_ttl'      => env('JWT_REFRESH_TTL', 20160), // minutes (2 weeks)
        'algo'             => env('JWT_ALGO', 'HS256'),
        'secret'           => env('JWT_SECRET'),
        'required_claims'  => ['iss', 'iat', 'exp', 'nbf', 'sub', 'jti'],
        'blacklist_enabled'=> env('JWT_BLACKLIST_ENABLED', true),
        'blacklist_grace_period' => env('JWT_BLACKLIST_GRACE_PERIOD', 0),
    ],

];
