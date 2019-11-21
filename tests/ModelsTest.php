<?php

namespace Veezex\Medical\Tests;

use Veezex\Medical\Models\Area;
use Veezex\Medical\Models\City;
use Veezex\Medical\Models\Clinic;
use Veezex\Medical\Models\Diagnostic;
use Veezex\Medical\Models\DiagnosticGroup;
use Veezex\Medical\Models\District;
use Veezex\Medical\Models\Metro;
use Veezex\Medical\Models\Service;
use Veezex\Medical\Models\Speciality;

class ModelsTest extends MedicalTestCase
{
    /** @test */
    public function clinic_model_has_accessors()
    {
        $clinic = new Clinic([
            'id' => 44,
            'district_id' => 63,
            'city_id' => 1,
            'branch_ids' => [250, 251, 252, 253, 254, 255, 256, 257, 258, 259, 260, 2275, 2276, 15757, 33033, 42522],
            'root_clinic_id' => 44,
            'name' => 'МедЦентрСервис на Авиамоторной',
            'short_name' => 'МедЦентрСервис на Авиамоторной',
            'url' => 'http://www.medcentrservis.ru',
            'lng' => "37.7165130000",
            'lat' => "55.7534580000",
            'street_id' => 12,
            'addr_city' => "Москва",
            'addr_street' => "ул. Авиамоторная",
            'addr_house' => "д. 41Б",
            'description' => "Многопрофильный медицинский центр. Диагностика и лечение взрослых. Расположен в 7 мин. ходьбы от м. Авиамоторная. Прием происходит по предварительной записи.",
            'short_description' => "Многопрофильный медицинский центр. Диагностика и лечение взрослых. Расположен в 7 мин. ходьбы от м. Авиамоторная. Прием происходит по предварительной записи.",
            'type_clinic' => true,
            'type_diagnostic' => false,
            'type_doctor' => false,
            'type_text' => "медицинская клиника",
            'phone' => "74952553137",
            'replacement_phone' => null,
            'direct_phone' => "+7 (495) 255-31-37; +7 (495) 104-77-99; +7 (495) 132-37-37; +7 (495) 151-23-32; +7 (495) 185-21-21",
            'logo' => "https://cdn.bookingtest.docdoc.pro/clinic/logo/min_44.jpg?1573413879",
            'email' => "test@test.ru",
            'rating' => 9.04,
            'min_price' => 1500,
            'max_price' => 1500,
            'online_schedule' => true,
            'schedule' => [
                'monday' => ['00:00', '24:00'],
                'tuesday' => ['00:00', '24:00'],
                'wednesday' => ['00:00', '24:00'],
                'thursday' => ['00:00', '24:00'],
                'friday' => ['00:00', '24:00'],
                'saturday' => ['00:00', '24:00'],
                'sunday' => ['00:00', '24:00'],
            ],
            'highlight_discount' => 0,
            'request_form_surname' => false,
            'request_form_birthday' => true,
            'metro_ids' => [1],
            'speciality_ids' => [70,72,73,91,93],
            'service_ids' => [
                ['id' => 3821, 'price' => 1700, 'special_price' => null],
                ['id' => 3841, 'price' => 1000, 'special_price' => null],
                ['id' => 3865, 'price' => 1500, 'special_price' => null],
                ['id' => 3819, 'price' => 2500, 'special_price' => null],
                ['id' => 3817, 'price' => 2500, 'special_price' => null],
                ['id' => 3835, 'price' => 17000, 'special_price' => null],
                ['id' => 3859, 'price' => 4600, 'special_price' => null],
                ['id' => 3849, 'price' => 6200, 'special_price' => null],
                ['id' => 4633, 'price' => 750, 'special_price' => null],
                ['id' => 4625, 'price' => 1200, 'special_price' => 1000],
            ],
            'diagnostic_ids' => [],
        ]);

        $this->assertEquals($clinic->getId(), 44);
        $this->assertEquals($clinic->getDistrictId(), 63);
        $this->assertEquals($clinic->getCityId(), 1);
        $this->assertEquals($clinic->getBranchIds(), [250, 251, 252, 253, 254, 255, 256, 257, 258, 259, 260, 2275, 2276, 15757, 33033, 42522]);
        $this->assertEquals($clinic->getRootClinicId(), 44);
        $this->assertEquals($clinic->getName(), 'МедЦентрСервис на Авиамоторной');
        $this->assertEquals($clinic->getShortName(), 'МедЦентрСервис на Авиамоторной');
        $this->assertEquals($clinic->getUrl(), 'http://www.medcentrservis.ru');
        $this->assertEquals($clinic->getLng(), "37.7165130000");
        $this->assertEquals($clinic->getLat(), "55.7534580000");
        $this->assertEquals($clinic->getStreetId(), 12);
        $this->assertEquals($clinic->getAddrCity(), "Москва");
        $this->assertEquals($clinic->getAddrStreet(), "ул. Авиамоторная");
        $this->assertEquals($clinic->getAddrHouse(), "д. 41Б");
        $this->assertEquals($clinic->getDescription(), "Многопрофильный медицинский центр. Диагностика и лечение взрослых. Расположен в 7 мин. ходьбы от м. Авиамоторная. Прием происходит по предварительной записи.");
        $this->assertEquals($clinic->getShortDescription(), "Многопрофильный медицинский центр. Диагностика и лечение взрослых. Расположен в 7 мин. ходьбы от м. Авиамоторная. Прием происходит по предварительной записи.");
        $this->assertEquals($clinic->getTypeClinic(), true);
        $this->assertEquals($clinic->getTypeDiagnostic(), false);
        $this->assertEquals($clinic->getTypeDoctor(), false);
        $this->assertEquals($clinic->getTypeText(), "медицинская клиника");
        $this->assertEquals($clinic->getPhone(), "74952553137");
        $this->assertEquals($clinic->getReplacementPhone(), null);
        $this->assertEquals($clinic->getDirectPhone(), "+7 (495) 255-31-37; +7 (495) 104-77-99; +7 (495) 132-37-37; +7 (495) 151-23-32; +7 (495) 185-21-21");
        $this->assertEquals($clinic->getLogo(), "https://cdn.bookingtest.docdoc.pro/clinic/logo/min_44.jpg?1573413879");
        $this->assertEquals($clinic->getEmail(), "test@test.ru");
        $this->assertEquals($clinic->getRating(), 9.04);
        $this->assertEquals($clinic->getMinPrice(), 1500);
        $this->assertEquals($clinic->getMaxPrice(), 1500);
        $this->assertEquals($clinic->getOnlineSchedule(), true);
        $this->assertEquals($clinic->getSchedule(), [
            'monday' => ['00:00', '24:00'],
            'tuesday' => ['00:00', '24:00'],
            'wednesday' => ['00:00', '24:00'],
            'thursday' => ['00:00', '24:00'],
            'friday' => ['00:00', '24:00'],
            'saturday' => ['00:00', '24:00'],
            'sunday' => ['00:00', '24:00'],
        ]);
        $this->assertEquals($clinic->getHighlightDiscount(), 0);
        $this->assertEquals($clinic->getRequestFormSurname(), false);
        $this->assertEquals($clinic->getRequestFormBirthday(), true);
        $this->assertEquals($clinic->getMetroIds(), [1]);
        $this->assertEquals($clinic->getSpecialityIds(), [70,72,73,91,93]);
        $this->assertEquals($clinic->getServiceIds(), [
            ['id' => 3821, 'price' => 1700, 'special_price' => null],
            ['id' => 3841, 'price' => 1000, 'special_price' => null],
            ['id' => 3865, 'price' => 1500, 'special_price' => null],
            ['id' => 3819, 'price' => 2500, 'special_price' => null],
            ['id' => 3817, 'price' => 2500, 'special_price' => null],
            ['id' => 3835, 'price' => 17000, 'special_price' => null],
            ['id' => 3859, 'price' => 4600, 'special_price' => null],
            ['id' => 3849, 'price' => 6200, 'special_price' => null],
            ['id' => 4633, 'price' => 750, 'special_price' => null],
            ['id' => 4625, 'price' => 1200, 'special_price' => 1000],
        ]);
        $this->assertEquals($clinic->getDiagnosticIds(), []);
    }

    /** @test */
    public function service_model_has_accessors()
    {
        $service = new Service([
            'id' => 1,
            'diagnostic_id' => null,
            'speciality_id' => 22,
            'name' => 'Услуги',
        ]);

        $this->assertEquals($service->getId(), 1);
        $this->assertEquals($service->getName(), 'Услуги');
        $this->assertEquals($service->getDiagnosticId(), null);
        $this->assertEquals($service->getSpecialityId(), 22);
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
