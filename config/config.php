<?php

/*
 * You can place your custom package configuration in here.
 */
/** @noinspection PhpFullyQualifiedNameUsageInspection */
return [
    'providers' => [
        \Veezex\Medical\Docdoc\Provider::class => [
            'test' => env('MEDICAL_DOCDOC_MODE', 'true'),
            'login' => env('MEDICAL_DOCDOC_LOGIN', ''),
            'password' => env('MEDICAL_DOCDOC_PASSWORD', ''),
            'max_tries' => 1,
            'retry_after' => 90,

            'models' => [
                'City' => Veezex\Medical\Docdoc\Models\City::class,
                'Area' => Veezex\Medical\Docdoc\Models\Area::class,
                'DiagnosticGroup' => Veezex\Medical\Docdoc\Models\DiagnosticGroup::class,
                'District' => Veezex\Medical\Docdoc\Models\District::class,
                'DoctorDetails' => Veezex\Medical\Docdoc\Models\DoctorDetails::class,
                'Metro' => Veezex\Medical\Docdoc\Models\Metro::class,
                'Review' => Veezex\Medical\Docdoc\Models\Review::class,
                'Service' => Veezex\Medical\Docdoc\Models\Service::class,
                'Speciality' => Veezex\Medical\Docdoc\Models\Speciality::class,
                'Clinic' => Veezex\Medical\Docdoc\Models\Clinic::class,
                'Doctor' => Veezex\Medical\Docdoc\Models\Doctor::class,
            ]
        ],
    ]
];
