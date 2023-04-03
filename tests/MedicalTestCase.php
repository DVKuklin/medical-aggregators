<?php

namespace DVKuklin\Medical\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kozz\Laravel\Providers\Guzzle;
use Orchestra\Testbench\TestCase;
use DVKuklin\Medical\MedicalAggregatorProvider;

class MedicalTestCase extends TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [MedicalAggregatorProvider::class, Guzzle::class];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            //'MedicalAggregators' => AggregatorsFacade::class,
        ];
    }

    /**
     * @param array $params
     */
    protected function mockGuzzleResponses(array $params)
    {
        $mock = new MockHandler(
            array_map(function ($paramsLine) {
                return new Response(... $paramsLine);
            }, $params)
        );

        $handler = HandlerStack::create($mock);
        config([
            'guzzle' => ['handler' => $handler],
        ]);
    }
}
