<?php

namespace Veezex\Medical\Tests;

use Orchestra\Testbench\TestCase;
use Veezex\Medical\MedicalAggregatorProvider;
use Veezex\Medical\AggregatorsFacade;

class MedicalTestCase extends TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [MedicalAggregatorProvider::class];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'MedicalAggregators' => AggregatorsFacade::class,
        ];
    }
}
