<?php

/*
 * You can place your custom package configuration in here.
 */
/** @noinspection PhpFullyQualifiedNameUsageInspection */
return [
    'providers' => [
        \DVKuklin\Medical\Docdoc\Provider::class => [
            'test' => env('MEDICAL_DOCDOC_MODE', 'true'),
            'login' => env('MEDICAL_DOCDOC_LOGIN', ''),
            'password' => env('MEDICAL_DOCDOC_PASSWORD', ''),
            'max_tries' => 1,
            'retry_after' => 90,

            'models' => [
                'City' => DVKuklin\Medical\Docdoc\Models\City::class,
                'Area' => DVKuklin\Medical\Docdoc\Models\Area::class,
                'DiagnosticGroup' => DVKuklin\Medical\Docdoc\Models\DiagnosticGroup::class,
                'District' => DVKuklin\Medical\Docdoc\Models\District::class,
                'DoctorDetails' => DVKuklin\Medical\Docdoc\Models\DoctorDetails::class,
                'Metro' => DVKuklin\Medical\Docdoc\Models\Metro::class,
                'Review' => DVKuklin\Medical\Docdoc\Models\Review::class,
                'Service' => DVKuklin\Medical\Docdoc\Models\Service::class,
                'Speciality' => DVKuklin\Medical\Docdoc\Models\Speciality::class,
                'Clinic' => DVKuklin\Medical\Docdoc\Models\Clinic::class,
                'Doctor' => DVKuklin\Medical\Docdoc\Models\Doctor::class,
                'Slot' => DVKuklin\Medical\Docdoc\Models\Slot::class,
            ]
        ],
    ]
];
