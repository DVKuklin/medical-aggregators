<?php

namespace Veezex\Medical\Tests;

use Veezex\Medical\Models\Area;
use Veezex\Medical\Models\City;
use Veezex\Medical\Models\Diagnostic;
use Veezex\Medical\Models\DiagnosticGroup;
use Veezex\Medical\Models\District;
use Veezex\Medical\Models\Metro;
use Veezex\Medical\Models\Service;
use Veezex\Medical\Models\Speciality;

class ModelsTest extends MedicalTestCase
{
    /** @test */
    public function service_model_has_accessors()
    {
        $district = new Service([
            'id' => 1,
            'diagnostic_id' => null,
            'speciality_id' => 22,
            'name' => 'Услуги',
        ]);

        $this->assertEquals($district->getId(), 1);
        $this->assertEquals($district->getName(), 'Услуги');
        $this->assertEquals($district->getDiagnosticId(), null);
        $this->assertEquals($district->getSpecialityId(), 22);
    }

    /** @test */
    public function diagnostic_group_model_has_accessors()
    {
        $diagnosticGroup = new DiagnosticGroup([
            'id' => 19,
            'name'=> 'КТ (компьютерная томография)',
            'diagnostics' => collect([
                new Diagnostic([
                    'id' => 118,
                    'name' => 'головного мозга',
                    'full_name' => 'КТ (компьютерная томография) головного мозга',
                    'diagnostic_group_id' => 19,
                ]),
            ])
        ]);

        $this->assertEquals($diagnosticGroup->getId(), 19);
        $this->assertEquals($diagnosticGroup->getName(), 'КТ (компьютерная томография)');

        $this->assertCount(1, $diagnosticGroup->getDiagnostics());
        $diagnostic = $diagnosticGroup->getDiagnostics()->get(0);

        $this->assertEquals($diagnostic->getId(), 118);
        $this->assertEquals($diagnostic->getName(), 'головного мозга');
        $this->assertEquals($diagnostic->getFullName(), 'КТ (компьютерная томография) головного мозга');
        $this->assertEquals($diagnostic->getDiagnosticGroupId(), 19);
    }

    /** @test */
    public function speciality_model_has_accessors()
    {
        $speciality = new Speciality([
            'id' => 67,
            'name' => 'Акушер',
            'branch_name' => 'Акушерство',
            'genitive_name' => 'Акушера',
            'plural_name' => 'Акушеры',
            'plural_genitive_name' => 'Акушеров',
            'kids_reception' => false,
            'city_ids' => [1, 2]
        ]);

        $this->assertEquals($speciality->getId(), 67);
        $this->assertEquals($speciality->getName(), 'Акушер');
        $this->assertEquals($speciality->getBranchName(), 'Акушерство');
        $this->assertEquals($speciality->getGenitiveName(), 'Акушера');
        $this->assertEquals($speciality->getPluralName(), 'Акушеры');
        $this->assertEquals($speciality->getPluralGenitiveName(), 'Акушеров');
        $this->assertEquals($speciality->getKidsReception(), false);

        $this->assertEquals($speciality->getCityIds(), [1, 2]);
    }

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
