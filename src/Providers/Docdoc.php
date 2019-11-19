<?php


namespace Veezex\Medical\Providers;


use GuzzleHttp\Client;

class Docdoc extends Provider
{
    /**
     * @var string
     */
    protected $endpoint;
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var string
     */
    protected $login;
    /**
     * @var string
     */
    protected $password;

    /**
     * Docdoc constructor.
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->endpoint = $settings['test'] === 'true'
            ? 'https://api.bookingtest.docdoc.pro/public/rest/1.0.12/'
            : 'https://back.docdoc.ru/public/rest/1.0.12/';

        $this->client = new Client();
        $this->login = $settings['login'];
        $this->password = $settings['password'];
    }

    /**
     * @param string $uri
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function apiGet(string $uri): array
    {
        $result = $this->client->request('GET', "$this->endpoint$uri", [
            'auth' => [$this->login, $this->password]
        ]);
        return json_decode($result->getBody(), true);
    }
}
