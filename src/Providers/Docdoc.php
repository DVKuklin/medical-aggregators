<?php


namespace Veezex\Medical\Providers;


class Docdoc extends Provider
{
    protected $endpoint = null;

    public function __construct(array $settings)
    {
        $this->endpoint = $settings['test'] === 'true'
            ? 'https://api.bookingtest.docdoc.pro'
            : 'https://back.docdoc.ru';
    }
}
