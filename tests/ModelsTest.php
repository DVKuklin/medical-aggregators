<?php

namespace Veezex\Medical\Tests;

use Veezex\Medical\Models\Area;
use Veezex\Medical\Models\City;
use Veezex\Medical\Models\District;
use Veezex\Medical\Models\Metro;

class ModelsTest extends MedicalTestCase
{
    /** @test */
    public function metro_model_has_accessors()
    {
        $district = new Metro([
            'id' => 267,
            'city_id' => 4,
            'name' => 'Ботаническая',
            'line_name' => 'Первая Екатеринбург',
            'line_color' => 'cc0000',
            'lng' => '60.63336182',
            'lat' => '56.79748535',
            'district_ids' => [],
        ]);

        $this->assertEquals($district->getId(), 267);
        $this->assertEquals($district->getCityId(), 4);
        $this->assertEquals($district->getName(), 'Ботаническая');
        $this->assertEquals($district->getLineName(), 'Первая Екатеринбург');
        $this->assertEquals($district->getLineColor(), 'cc0000');
        $this->assertEquals($district->getLng(), '60.63336182');
        $this->assertEquals($district->getLat(), '56.79748535');
        $this->assertEquals($district->getDistrictIds(), []);
    }

    /** @test */
    public function district_model_has_accessors()
    {
        $district = new District([
            'id' => 3,
            'name' => 'Железнодорожный район',
            'area_id' => 22,
            'city_id' => 33,
        ]);

        $this->assertEquals($district->getId(), 3);
        $this->assertEquals($district->getAreaId(), 22);
        $this->assertEquals($district->getCityId(), 33);
        $this->assertEquals($district->getName(), 'Железнодорожный район');
    }

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

    /** @test */
    public function area_model_has_accessors()
    {
        $city = new Area([
            'id' => 3,
            'short_name' => 'Moscow1',
            'name' => 'Moscow2'
        ]);

        $this->assertEquals($city->getId(), 3);
        $this->assertEquals($city->getName(), 'Moscow2');
        $this->assertEquals($city->getShortName(), 'Moscow1');
    }
}
