<?php

namespace Veezex\Medical\Tests;

use Veezex\Medical\Models\City;
use Veezex\Medical\Providers\Docdoc;

class DocdocTest extends MedicalTestCase
{
    /** @test */
    public function it_can_get_cities()
    {
        $this->mockResponseFile('city.json');

        $provider = app(Docdoc::class);

        $cities = $provider->getCities();
        $this->assertCount(2, $cities);

        $city1 = $cities[0];
        $cityCheck1 = new City([
            'id' => 1,
            'name' => 'Москва',
            'lat' => '55.755826',
            'lng' => '37.6173',
            'has_diagnostic' => true,
            'timezone_shift' => 3,
        ]);

        $this->assertEquals($city1, $cityCheck1);

        $city2 = $cities[1];
        $cityCheck2 = new City([
            'id' => 2,
            'name' => 'Санкт-Петербург',
            'lat' => '59.9342802',
            'lng' => '30.3350986',
            'has_diagnostic' => true,
            'timezone_shift' => 3,
        ]);

        $this->assertEquals($city2, $cityCheck2);
    }

    /** @test */
    public function it_can_make_api_request()
    {
        $this->mockResponseJson('{"test":1}');

        $provider = app(Docdoc::class);
        $this->assertEquals(['test' => 1], $provider->apiGet('someurl'));
    }

    /**
     * @param string $fileName
     */
    protected function mockResponseFile(string $fileName)
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'docdoc' . DIRECTORY_SEPARATOR . $fileName);
        $this->mockResponseJson($json);
    }

    /**
     * @param string $json
     */
    protected function mockResponseJson(string $json)
    {
        $this->setProviderConfig();
        $this->mockGuzzleResponses([
            [200, [], $json]
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
