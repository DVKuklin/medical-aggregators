<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'providers' => [
        'Veezex\Medical\Providers\Dummy' => [],
        'Veezex\Medical\Providers\Docdoc' => [
            'test' => env('MEDICAL_DOCDOC_MODE', 'true'),
            'login' => env('MEDICAL_DOCDOC_LOGIN', ''),
            'password' => env('MEDICAL_DOCDOC_PASSWORD', ''),
            'max_tries' => 1,
            'retry_after' => 90
        ],
    ]
];
