<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Veezex\Medical\Tests;

use Veezex\Medical\Models\Area;
use Veezex\Medical\Models\City;
use Veezex\Medical\Providers\Docdoc;

class DocdocTest extends MedicalTestCase
{
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

        $this->mockResponseJson('{"test":1}', 401);

        $provider = app(Docdoc::class);
        $provider->apiGet('someurl');
    }

    /**
     * @param string $fileName
     * @param int $status
     */
    protected function mockResponseFile(string $fileName, int $status = 200)
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'docdoc' . DIRECTORY_SEPARATOR . $fileName);
        $this->mockResponseJson($json, $status);
    }

    /**
     * @param string $json
     * @param int $status
     */
    protected function mockResponseJson(string $json, int $status = 200)
    {
        $this->setProviderConfig();
        $this->mockGuzzleResponses([
            [$status, [], $json]
        ]);
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
