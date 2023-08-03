<?php

/**
 * Authentication configuration options.
 *
 * Changes to these config files are not supported by BookStack and may break upon updates.
 * Configuration should be altered via the `.env` file or environment variables.
 * Do not edit this file unless you're happy to maintain any changes yourself.
 */

return [

    // Options: standard, ldap, saml2, oidc, oauth
    'method' => env('AUTH_METHOD', 'standard'),

    // Automatically initiate login via external auth system if it's the sole auth method.
    // Works with saml2 or oidc auth methods.
    'auto_initiate' => env('AUTH_AUTO_INITIATE', false),

    // Authentication Defaults
    // This option controls the default authentication "guard" and password
    // reset options for your application.
    'defaults' => [
        'guard'     => env('AUTH_METHOD', 'standard'),
        'passwords' => 'users',
    ],

    // Authentication Guards
    // All authentication drivers have a user provider. This defines how the
    // users are actually retrieved out of your database or other storage
    // mechanisms used by this application to persist your user's data.
    // Supported drivers: "session", "api-token", "ldap-session", "async-external-session"
    'guards' => [
        'standard' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],
        'ldap' => [
            'driver'   => 'ldap-session',
            'provider' => 'external',
        ],
        'saml2' => [
            'driver'   => 'async-external-session',
            'provider' => 'external',
        ],
        'oidc' => [
            'driver'   => 'async-external-session',
            'provider' => 'external',
        ],
        'api' => [
            'driver'   => 'api-token',
        ],
    ],

    // User Providers
    // All authentication drivers have a user provider. This defines how the
    // users are actually retrieved out of your database or other storage
    // mechanisms used by this application to persist your user's data.
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => \BookStack\Auth\User::class,
        ],

        'external' => [
            'driver' => 'external-users',
            'model'  => \BookStack\Auth\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    // Resetting Passwords
    // The expire time is the number of minutes that the reset token should be
    // considered valid. This security feature keeps tokens short-lived so
    // they have less time to be guessed. You may change this as needed.
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'email'    => 'emails.password',
            'table'    => 'password_resets',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    // Password Confirmation Timeout
    // Here you may define the amount of seconds before a password confirmation
    // times out and the user is prompted to re-enter their password via the
    // confirmation screen. By default, the timeout lasts for three hours.
    'password_timeout' => 10800,

];
