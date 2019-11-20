<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Veezex\Medical\Tests;

use Veezex\Medical\Models\Area;
use Veezex\Medical\Models\City;
use Veezex\Medical\Models\District;
use Veezex\Medical\Models\Metro;
use Veezex\Medical\Models\Speciality;
use Veezex\Medical\Providers\Docdoc;

class DocdocTest extends MedicalTestCase
{
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
            'name_genitive'=> 'Акушера',
            'name_plural'=> 'Акушеры',
            'name_plural_genitive'=> 'Акушеров',
            'kids_reception'=> false,
            'city_ids' => [1,2]
        ]));

        $this->assertEquals($specialities->get(1), new Speciality([
            'id' => 68,
            'name'=> 'Аллерголог',
            'branch_name'=> 'Аллергология',
            'name_genitive'=> 'Аллерголога',
            'name_plural'=> 'Аллергологи',
            'name_plural_genitive'=> 'Аллергологов',
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
     * @param string $test
     * @param string $login
     * @param string $password
     */
    protected function setProviderConfig(string $login = '', string $password = '', string $test = 'true'): void
    {
        config([
            'medical-aggregators.providers' => [
                'Veezex\Medical\Providers\Docdoc' => [
                    'test' => $test,
                    'login' => $login,
                    'password' => $password,
                ],
            ],
        ]);
    }

}
