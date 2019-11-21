<?php /** @noinspection PhpUndefinedMethodInspection */

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
use Veezex\Medical\Providers\Docdoc;

class DocdocTest extends MedicalTestCase
{
    /** @test */
    public function it_can_get_clinics()
    {
        $this->mockResponseFile(['clinics.1.json', 'clinics.4.json']);
        $provider = app(Docdoc::class);

        $clinics = $provider->getClinics([1, 2]);
        $this->assertCount(2, $clinics);

        $this->assertEquals(new Clinic([
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
        ]), $clinics->get(0));

        // todo: second model test
    }

    /** @test */
    public function it_can_get_services()
    {
        $this->mockResponseFile(['services.json']);
        $provider = app(Docdoc::class);

        $services = $provider->getServices();
        $this->assertCount(2, $services);

        $this->assertEquals($services->get(0), new Service([
            'id' => 1,
            'diagnostic_id' => null,
            'speciality_id' => null,
            'name' => 'Услуги',
        ]));

        $this->assertEquals($services->get(1), new Service([
            'id' => 3427,
            'diagnostic_id' => 91,
            'speciality_id' => 90,
            'name' => 'Пластика уздечки верхней губы',
        ]));
    }

    /** @test */
    public function it_can_get_diagnostics()
    {
        $this->mockResponseFile(['diagnostics.json']);
        $provider = app(Docdoc::class);

        $diagnostics = $provider->getDiagnostics();
        $this->assertCount(2, $diagnostics);

        $this->assertEquals($diagnostics->get(0), new DiagnosticGroup([
            'id' => 1,
            'name'=> 'УЗИ (ультразвуковое исследование)',
            'diagnostics' => collect([
                new Diagnostic([
                    'id' => 71,
                    'name' => 'печени',
                    'full_name' => 'УЗИ (ультразвуковое исследование) печени',
                    'diagnostic_group_id' => 1,
                ]),
                new Diagnostic([
                    'id' => 72,
                    'name' => 'поджелудочной железы',
                    'full_name' => 'УЗИ (ультразвуковое исследование) поджелудочной железы',
                    'diagnostic_group_id' => 1,
                ]),
            ])
        ]));

        $this->assertEquals($diagnostics->get(1), new DiagnosticGroup([
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
        ]));
    }

    /** @test */
    public function it_can_get_specialities()
    {
        $this->mockResponseFile(['speciality.1.json', 'speciality.2.json']);
        $provider = app(Docdoc::class);

        $specialities = $provider->getSpecialities([1,2]);
        $this->assertCount(2, $specialities);

        $this->assertEquals($specialities->get(0), new Speciality([
            'id' => 67,
            'name'=> 'Акушер',
            'branch_name'=> 'Акушерство',
            'genitive_name'=> 'Акушера',
            'plural_name'=> 'Акушеры',
            'plural_genitive_name'=> 'Акушеров',
            'kids_reception'=> false,
            'city_ids' => [1,2]
        ]));

        $this->assertEquals($specialities->get(1), new Speciality([
            'id' => 68,
            'name'=> 'Аллерголог',
            'branch_name'=> 'Аллергология',
            'genitive_name'=> 'Аллерголога',
            'plural_name'=> 'Аллергологи',
            'plural_genitive_name'=> 'Аллергологов',
            'kids_reception'=> true,
            'city_ids' => [2]
        ]));
    }

    /** @test */
    public function it_can_get_metros()
    {
        $this->mockResponseFile(['metro.1.json', 'metro.2.json']);
        $provider = app(Docdoc::class);

        $metros = $provider->getMetros([1,2]);
        $this->assertCount(2, $metros);

        $this->assertEquals($metros->get(0), new Metro([
            'id' => 267,
            'city_id' => 4,
            'name' => 'Ботаническая',
            'line_name' => 'Первая Екатеринбург',
            'line_color' => 'cc0000',
            'lng' => '60.63336182',
            'lat' => '56.79748535',
            'district_ids' => [],
        ]));

        $this->assertEquals($metros->get(1), new Metro([
            'id' => 1,
            'city_id' => 1,
            'name' => 'Авиамоторная',
            'line_name' => 'Калининско-Солнцевская ',
            'line_color' => 'ffdd03',
            'lng' => '37.7166214',
            'lat' => '55.75143051',
            'district_ids' => [63],
        ]));
    }

    /** @test */
    public function it_can_get_districts()
    {
        $this->mockResponseFile(['districts.1.json', 'districts.2.json']);
        $provider = app(Docdoc::class);

        $districts = $provider->getDistricts([1,2]);
        $this->assertCount(2, $districts);

        $this->assertEquals($districts->get(0), new District([
            'id' => 1,
            'name' => 'Арбат',
            'city_id' => 1,
            'area_id' => 1,
        ]));

        $this->assertEquals($districts->get(1), new District([
            'id' => 139,
            'name' => 'Кировский',
            'city_id' => 2,
            'area_id' => null,
        ]));
    }

    /** @test */
    public function it_can_get_moscow_areas()
    {
        $this->mockResponseFile('area.json');
        $provider = app(Docdoc::class);

        $areas = $provider->getMoscowAreas();
        $this->assertCount(2, $areas);

        $this->assertEquals($areas->get(0), new Area([
            'id' => 1,
            'name' => 'Центральный Округ',
            'short_name' => 'ЦАО',
        ]));

        $this->assertEquals($areas->get(1), new Area([
            'id' => 2,
            'name' => 'Северный Округ',
            'short_name' => 'САО',
        ]));
    }

    /** @test */
    public function it_can_get_cities()
    {
        $this->mockResponseFile('city.json');
        $provider = app(Docdoc::class);

        $cities = $provider->getCities();
        $this->assertCount(2, $cities);

        $this->assertEquals($cities->get(0), new City([
            'id' => 1,
            'name' => 'Москва',
            'lat' => '55.755826',
            'lng' => '37.6173',
            'has_diagnostic' => true,
            'timezone_shift' => 3,
        ]));

        $this->assertEquals($cities->get(1), new City([
            'id' => 2,
            'name' => 'Санкт-Петербург',
            'lat' => '59.9342802',
            'lng' => '30.3350986',
            'has_diagnostic' => true,
            'timezone_shift' => 3,
        ]));
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
