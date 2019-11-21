<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Veezex\Medical\Tests;

use Veezex\Medical\Providers\Docdoc;

class DocdocTest extends MedicalTestCase
{
    /** @test */
    public function it_can_get_clinics()
    {
        $this->mockResponseFile(['clinics.1.json', 'clinics.4.json']);
        $provider = app(Docdoc::class);

        $clinics = $provider->getClinics([1, 4]);
        $this->assertCount(2, $clinics);

        // 1
        $clinic = $clinics->get(0);
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

        // 2
        $clinic = $clinics->get(1);
        $this->assertEquals($clinic->getId(), 2764);
        $this->assertEquals($clinic->getDistrictId(), 154);
        $this->assertEquals($clinic->getCityId(), 4);
        $this->assertEquals($clinic->getBranchIds(), []);
        $this->assertEquals($clinic->getRootClinicId(), 2764);
        $this->assertEquals($clinic->getName(), 'Новая Больница');
        $this->assertEquals($clinic->getShortName(), 'Новая Больница');
        $this->assertEquals($clinic->getUrl(), "https://newhospital.ru/");
        $this->assertEquals($clinic->getLng(), "60.5526580000");
        $this->assertEquals($clinic->getLat(), "56.8313000000");
        $this->assertEquals($clinic->getStreetId(), 5885);
        $this->assertEquals($clinic->getAddrCity(), "Екатеринбург");
        $this->assertEquals($clinic->getAddrStreet(), "ул. Заводская");
        $this->assertEquals($clinic->getAddrHouse(), "д. 29");
        $this->assertEquals($clinic->getDescription(), "Медицинское объединение Новая больница – это многопрофильная клиника полного цикла, включающая амбулаторно-поликлиническое отделение, стационар и специализированные городские центры.\r\nКлиника служит научной площадкой для семи кафедр Уральского государственного медицинского университета.\r\nПрименяются современные подходы к консервативным методам лечения, аппаратной и лабораторной диагностике. Имеются платные комплексные и специализированные программы медицинского обслуживания: экспресс-диагностика «Check Up», ведение беременности, годовые программы для детей и взрослых. В клинике можно вызвать детского или взрослого врача на дом в пределах Екатеринбурга и окрестностей (до 40 км от ЕКАД). Это амбулаторно-поликлиническое отделение, детская поликлиника, стационар, городские центры диагностики и лечения, центр иммунопрофилактики, стоматологическая клиника, косметологическая клиника, сеть аптек.");
        $this->assertEquals($clinic->getShortDescription(), "Медицинское объединение Новая больница – это многопрофильная клиника полного цикла, включающая амбулаторно-поликлиническое отделение, стационар и специализированные городские центры.\r\nКлиника служит научной площадкой для семи кафедр Уральского государственного медицинского университета.\r\nПрименяются современные подходы к консервативным методам лечения, аппаратной и лабораторной диагностике. Имеются платные комплексные и специализированные программы медицинского обслуживания: экспресс-диагностика «Check Up», ведение беременности, годовые программы для детей и взрослых. В клинике можно вызвать детского или взрослого врача на дом в пределах Екатеринбурга и окрестностей (до 40 км от ЕКАД). Это амбулаторно-поликлиническое отделение, детская поликлиника, стационар, городские центры диагностики и лечения, центр иммунопрофилактики, стоматологическая клиника, косметологическая клиника, сеть аптек.");
        $this->assertEquals($clinic->getTypeClinic(), true);
        $this->assertEquals($clinic->getTypeDiagnostic(), true);
        $this->assertEquals($clinic->getTypeDoctor(), false);
        $this->assertEquals($clinic->getTypeText(), "многопрофильный медицинский центр");
        $this->assertEquals($clinic->getPhone(), "73433555657");
        $this->assertEquals($clinic->getReplacementPhone(), null);
        $this->assertEquals($clinic->getDirectPhone(), "+7 (343) 355-56-57; +7 (343) 302-36-26");
        $this->assertEquals($clinic->getLogo(), "https://cdn.docdoc.ru/clinic/logo/min_2764.jpg?1574300156");
        $this->assertEquals($clinic->getEmail(), "market@newhospital.ru");
        $this->assertEquals($clinic->getRating(), 9);
        $this->assertEquals($clinic->getMinPrice(), 1150);
        $this->assertEquals($clinic->getMaxPrice(), 1500);
        $this->assertEquals($clinic->getOnlineSchedule(), true);
        $this->assertEquals($clinic->getSchedule(), [
            'monday' => ['07:30', '20:00'],
            'tuesday' => ['07:30', '20:00'],
            'wednesday' => ['07:30', '20:00'],
            'thursday' => ['07:30', '20:00'],
            'friday' => ['07:30', '20:00'],
            'saturday' => ['08:00', '18:00'],
            'sunday' => ['08:00', '16:00'],
        ]);
        $this->assertEquals($clinic->getHighlightDiscount(), 0);
        $this->assertEquals($clinic->getRequestFormSurname(), false);
        $this->assertEquals($clinic->getRequestFormBirthday(), false);
        $this->assertEquals($clinic->getMetroIds(), []);
        $this->assertEquals($clinic->getSpecialityIds(), [73,85,91,102,112,114]);
        $this->assertEquals($clinic->getServiceIds(), []);
        $this->assertEquals($clinic->getDiagnosticIds(), [
            ['id' => 156, 'price' => 950, 'special_price' => null],
            ['id' => 53, 'price' => 2650, 'special_price' => null],
        ]);
    }

    /** @test */
    public function it_can_get_services()
    {
        $this->mockResponseFile(['services.json']);
        $provider = app(Docdoc::class);

        $services = $provider->getServices();
        $this->assertCount(2, $services);

        $service = $services->get(0);
        $this->assertEquals($service->getId(), 1);
        $this->assertEquals($service->getName(), 'Услуги');
        $this->assertEquals($service->getDiagnosticId(), null);
        $this->assertEquals($service->getSpecialityId(), null);

        $service = $services->get(1);
        $this->assertEquals($service->getId(), 3427);
        $this->assertEquals($service->getName(), 'Пластика уздечки верхней губы');
        $this->assertEquals($service->getDiagnosticId(), 91);
        $this->assertEquals($service->getSpecialityId(), 90);
    }

    /** @test */
    public function it_can_get_diagnostics()
    {
        $this->mockResponseFile(['diagnostics.json']);
        $provider = app(Docdoc::class);

        $diagnostics = $provider->getDiagnostics();
        $this->assertCount(2, $diagnostics);

        //////////
        $diagnosticGroup = $diagnostics->get(0);
        $this->assertEquals($diagnosticGroup->getId(), 1);
        $this->assertEquals($diagnosticGroup->getName(), 'УЗИ (ультразвуковое исследование)');
        $this->assertCount(2, $diagnosticGroup->getDiagnostics());

        $diagnostic1 = $diagnosticGroup->getDiagnostics()->get(0);
        $this->assertEquals($diagnostic1->getId(), 71);
        $this->assertEquals($diagnostic1->getName(), 'печени');
        $this->assertEquals($diagnostic1->getFullName(), 'УЗИ (ультразвуковое исследование) печени');
        $this->assertEquals($diagnostic1->getDiagnosticGroupId(), 1);

        $diagnostic2 = $diagnosticGroup->getDiagnostics()->get(1);
        $this->assertEquals($diagnostic2->getId(), 72);
        $this->assertEquals($diagnostic2->getName(), 'поджелудочной железы');
        $this->assertEquals($diagnostic2->getFullName(), 'УЗИ (ультразвуковое исследование) поджелудочной железы');
        $this->assertEquals($diagnostic2->getDiagnosticGroupId(), 1);

        ////////////////
        $diagnosticGroup = $diagnostics->get(1);
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
    public function it_can_get_specialities()
    {
        $this->mockResponseFile(['speciality.1.json', 'speciality.2.json']);
        $provider = app(Docdoc::class);

        $specialities = $provider->getSpecialities([1,2]);
        $this->assertCount(2, $specialities);

        $speciality = $specialities->get(0);
        $this->assertEquals($speciality->getId(), 67);
        $this->assertEquals($speciality->getName(), 'Акушер');
        $this->assertEquals($speciality->getBranchName(), 'Акушерство');
        $this->assertEquals($speciality->getGenitiveName(), 'Акушера');
        $this->assertEquals($speciality->getPluralName(), 'Акушеры');
        $this->assertEquals($speciality->getPluralGenitiveName(), 'Акушеров');
        $this->assertEquals($speciality->getKidsReception(), false);
        $this->assertEquals($speciality->getCityIds(), [1, 2]);

        $speciality = $specialities->get(1);
        $this->assertEquals($speciality->getId(), 68);
        $this->assertEquals($speciality->getName(), 'Аллерголог');
        $this->assertEquals($speciality->getBranchName(), 'Аллергология');
        $this->assertEquals($speciality->getGenitiveName(), 'Аллерголога');
        $this->assertEquals($speciality->getPluralName(), 'Аллергологи');
        $this->assertEquals($speciality->getPluralGenitiveName(), 'Аллергологов');
        $this->assertEquals($speciality->getKidsReception(), true);
        $this->assertEquals($speciality->getCityIds(), [2]);
    }

    /** @test */
    public function it_can_get_metros()
    {
        $this->mockResponseFile(['metro.1.json', 'metro.2.json']);
        $provider = app(Docdoc::class);

        $metros = $provider->getMetros([1,2]);
        $this->assertCount(2, $metros);

        $metro = $metros->get(0);
        $this->assertEquals($metro->getId(), 267);
        $this->assertEquals($metro->getCityId(), 4);
        $this->assertEquals($metro->getName(), 'Ботаническая');
        $this->assertEquals($metro->getLineName(), 'Первая Екатеринбург');
        $this->assertEquals($metro->getLineColor(), 'cc0000');
        $this->assertEquals($metro->getLng(), '60.63336182');
        $this->assertEquals($metro->getLat(), '56.79748535');
        $this->assertEquals($metro->getDistrictIds(), []);

        $metro = $metros->get(1);
        $this->assertEquals($metro->getId(), 1);
        $this->assertEquals($metro->getCityId(), 1);
        $this->assertEquals($metro->getName(), 'Авиамоторная');
        $this->assertEquals($metro->getLineName(), 'Калининско-Солнцевская ');
        $this->assertEquals($metro->getLineColor(), 'ffdd03');
        $this->assertEquals($metro->getLng(), '37.7166214');
        $this->assertEquals($metro->getLat(), '55.75143051');
        $this->assertEquals($metro->getDistrictIds(), [63]);
    }

    /** @test */
    public function it_can_get_districts()
    {
        $this->mockResponseFile(['districts.1.json', 'districts.2.json']);
        $provider = app(Docdoc::class);

        $districts = $provider->getDistricts([1,2]);
        $this->assertCount(2, $districts);

        $district = $districts->get(0);
        $this->assertEquals($district->getId(), 1);
        $this->assertEquals($district->getAreaId(), 1);
        $this->assertEquals($district->getCityId(), 1);
        $this->assertEquals($district->getName(), 'Арбат');

        $district = $districts->get(1);
        $this->assertEquals($district->getId(), 139);
        $this->assertEquals($district->getAreaId(), null);
        $this->assertEquals($district->getCityId(), 2);
        $this->assertEquals($district->getName(), 'Кировский');
    }

    /** @test */
    public function it_can_get_moscow_areas()
    {
        $this->mockResponseFile('area.json');
        $provider = app(Docdoc::class);

        $areas = $provider->getMoscowAreas();
        $this->assertCount(2, $areas);

        $area = $areas->get(0);
        $this->assertEquals($area->getId(), 1);
        $this->assertEquals($area->getName(), 'Центральный Округ');
        $this->assertEquals($area->getShortName(), 'ЦАО');

        $area = $areas->get(1);
        $this->assertEquals($area->getId(), 2);
        $this->assertEquals($area->getName(), 'Северный Округ');
        $this->assertEquals($area->getShortName(), 'САО');
    }

    /** @test */
    public function it_can_get_cities()
    {
        $this->mockResponseFile('city.json');
        $provider = app(Docdoc::class);

        $cities = $provider->getCities();
        $this->assertCount(2, $cities);

        $city = $cities->get(0);
        $this->assertEquals($city->getId(), 1);
        $this->assertEquals($city->getName(), 'Москва');
        $this->assertEquals($city->getLat(), '55.755826');
        $this->assertEquals($city->getLng(), '37.6173');
        $this->assertEquals($city->getHasDiagnostic(), true);
        $this->assertEquals($city->getTimezoneShift(), 3);

        $city = $cities->get(1);
        $this->assertEquals($city->getId(), 2);
        $this->assertEquals($city->getName(), 'Санкт-Петербург');
        $this->assertEquals($city->getLat(), '59.9342802');
        $this->assertEquals($city->getLng(), '30.3350986');
        $this->assertEquals($city->getHasDiagnostic(), true);
        $this->assertEquals($city->getTimezoneShift(), 3);

    }

    /** @test */
    public function throws_exception_if_error_request_status()
    {
        $this->expectException('GuzzleHttp\Exception\ClientException');

        $this->mockResponseJson(['{"test":1}'], 401);
        $this->setProviderConfig('', '', 'true', 1);

        $provider = app(Docdoc::class);
        $provider->apiGet('someurl');
    }

    /** @test */
    public function throws_exception_if_error_request_status_after_tries()
    {
        $this->expectException('GuzzleHttp\Exception\ClientException');

        $this->mockResponseJson(['{"test":1}', '{"test":1}'], 401);
        $this->setProviderConfig('', '', 'true', 2);

        $provider = app(Docdoc::class);
        $provider->apiGet('someurl');
    }

    /**
     * @param $fileName
     * @param int $status
     */
    protected function mockResponseFile($fileName, int $status = 200)
    {
        if (!is_array($fileName)) {
            $fileName = [$fileName];
        }

        $filePrefix = __DIR__ . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'docdoc' . DIRECTORY_SEPARATOR;
        $this->mockResponseJson(array_map(function($file) use ($filePrefix) {
            return file_get_contents($filePrefix . $file);
        }, $fileName), $status);
    }

    /**
     * @param array $bodies
     * @param int $status
     */
    protected function mockResponseJson(array $bodies, int $status = 200)
    {
        $this->setProviderConfig();
        $this->mockGuzzleResponses(array_map(function($body) use ($status) {
            return [$status, [], $body];
        }, $bodies));
    }

    /**
     * @param string $login
     * @param string $password
     * @param string $test
     * @param int $maxTries
     */
    protected function setProviderConfig(string $login = '', string $password = '', string $test = 'true', int $maxTries = 2): void
    {
        config([
            'medical-aggregators.providers' => [
                'Veezex\Medical\Providers\Docdoc' => [
                    'test' => $test,
                    'login' => $login,
                    'password' => $password,
                    'max_tries' => $maxTries,
                    'retry_after' => 0,
                ],
            ],
        ]);
    }

}
