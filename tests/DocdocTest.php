<?php

namespace Veezex\Medical\Tests;

use Veezex\Medical\Providers\Docdoc;

class DocdocTest extends MedicalTestCase
{
    /** @test */
    public function it_can_make_api_request()
    {
        $this->setTestConfig('', '');
        $provider = app(Docdoc::class);

        dd($provider->apiGet('doctor/list'));
    }

    /**
     * @param string $test
     * @param string $login
     * @param string $password
     */
    protected function setTestConfig(string $login = '', string $password = '', string $test = 'true'): void
    {
        config(['medical-aggregators.providers' => [
            'Veezex\Medical\Providers\Docdoc' => [
                'test' => $test,
                'login' => $login,
                'password' => $password,
            ],
        ]]);
    }
}
