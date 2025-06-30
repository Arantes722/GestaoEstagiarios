<?php

return [

    'defaults' => [
        'guard' => 'admin',  // ou 'estagiario' — podes escolher o guard padrão que faz mais sentido
        'passwords' => 'administradores',
    ],

    'guards' => [
        'admin' => [
            'driver' => 'session',
            'provider' => 'administradores',
        ],

        'estagiario' => [
            'driver' => 'session',
            'provider' => 'estagiarios',
        ],
    ],

    'providers' => [
        'administradores' => [
            'driver' => 'eloquent',
            'model' => App\Models\Administrador::class,
        ],

        'estagiarios' => [
            'driver' => 'eloquent',
            'model' => App\Models\Estagiario::class,
        ],
    ],

    'passwords' => [
        'administradores' => [
            'provider' => 'administradores',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'estagiarios' => [
            'provider' => 'estagiarios',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
