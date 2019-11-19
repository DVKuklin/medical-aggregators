<?php

namespace Veezex\Medical\Tests;

use Veezex\Medical\Providers\Dummy;
use Veezex\Medical\Providers\Provider;

class AggregatorsTest extends MedicalTestCase
{
    /** @test */
    public function it_has_one_dummy_provider_by_default()
    {
        $service = app(Dummy::class);
        $this->assertInstanceOf(Dummy::class, $service);
        $this->assertInstanceOf(Provider::class, $service);
    }
}
