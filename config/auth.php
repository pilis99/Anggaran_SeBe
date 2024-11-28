<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'userr', // Pastikan ini sesuai dengan provider yang Anda gunakan
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'userr', // Pastikan ini mengarah ke provider yang benar
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'userr', // Pastikan ini juga mengarah ke provider yang benar
        ],
    ],

    'providers' => [
        'userr' => [
            'driver' => 'eloquent',
            'model' => App\Userr::class, // Pastikan model ini ada
        ],
    ],


    'passwords' => [
        'users' => [
            'provider' => 'userr',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
