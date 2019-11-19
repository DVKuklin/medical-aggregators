<?php


namespace Veezex\Medical\Providers;


class Docdoc extends Provider
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var resource
     */
    protected $requestContext;

    /**
     * Docdoc constructor.
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->endpoint = $settings['test'] === 'true'
            ? 'https://api.bookingtest.docdoc.pro/public/rest/1.0.12/'
            : 'https://back.docdoc.ru/public/rest/1.0.12/';

        $this->requestContext = $this->getRequestContext($settings['login'], $settings['password']);
    }

    /**
     * @param string $login
     * @param string $password
     * @return resource
     */
    protected function getRequestContext(string $login, string $password)
    {
        return stream_context_create([
            'https'=> [
                'method' => 'GET',
                'header' => 'Authorization: Basic ' . base64_encode("$login:$password"),
                "protocol_version" => 1.1333
            ]
        ]);
    }

    /**
     * @param string $uri
     * @return array
     */
    public function request(string $uri): array
    {
        $response = file_get_contents("$this->endpoint$uri", false, $this->requestContext);
        return json_decode($response, true);
    }
}
