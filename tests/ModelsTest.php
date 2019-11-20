<?php

namespace Veezex\Medical\Tests;

use Veezex\Medical\Models\City;

class ModelsTest extends MedicalTestCase
{
    /** @test */
    public function city_model_has_accessors()
    {
        $city = new City([
            'id' => 1,
            'name' => 'Москва',
            'lat' => '55.755826',
            'lng' => '37.6173',
            'has_diagnostic' => true,
            'timezone_shift' => 3,
        ]);

        $this->assertEquals($city->getId(), 1);
        $this->assertEquals($city->getName(), 'Москва');
        $this->assertEquals($city->getLat(), '55.755826');
        $this->assertEquals($city->getLng(), '37.6173');
        $this->assertEquals($city->getHasDiagnostic(), true);
        $this->assertEquals($city->getTimezoneShift(), 3);
    }
}
