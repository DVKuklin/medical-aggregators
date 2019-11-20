<?php /** @noinspection PhpUndefinedMethodInspection */


namespace Veezex\Medical\Providers;



use Kozz\Laravel\Facades\Guzzle;

class Docdoc extends Provider
{
    /**
     * @var string
     */
    protected $endpoint;
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

        $this->login = $settings['login'];
        $this->password = $settings['password'];
    }

    /**
     * @return iterable
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cities(): iterable
    {
        $response = $this->apiGet('city');

        foreach ($response['CityList'] as $item) {
            dd($item);
        }

        return [];
    }

    /**
     * @param string $uri
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function apiGet(string $uri): array
    {
        $result = Guzzle::get("$this->endpoint$uri", [
            'auth' => [$this->login, $this->password]
        ]);
        return json_decode($result->getBody(), true);
    }
}
