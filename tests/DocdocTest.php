<?php

namespace Veezex\Medical\Tests;

use Veezex\Medical\Providers\Docdoc;

class DocdocTest extends MedicalTestCase
{
    /** @test */
    public function it_can_make_api_request()
    {
        $this->setProviderConfig();
        $this->mockGuzzleResponses([
            [200, [], '{"test":1}']
        ]);

        $provider = app(Docdoc::class);
        $this->assertEquals(['test' => 1], $provider->apiGet('someurl'));
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
