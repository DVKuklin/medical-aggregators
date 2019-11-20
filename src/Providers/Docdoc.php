<?php /** @noinspection PhpUndefinedMethodInspection */


namespace Veezex\Medical\Providers;



use Illuminate\Support\LazyCollection;
use Kozz\Laravel\Facades\Guzzle;
use Veezex\Medical\Models\City;
use Veezex\Medical\Models\Area;

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
     * @return LazyCollection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCities(): LazyCollection
    {
        $response = $this->apiGet('city');

        return new LazyCollection(function() use ($response) {
            foreach ($response['CityList'] as $item) {
                yield new City([
                    'id' => $item['Id'],
                    'name' => $item['Name'],
                    'lat' => $item['Latitude'],
                    'lng' => $item['Longitude'],
                    'has_diagnostic' => $item['HasDiagnostic'],
                    'timezone_shift' => $item['TimeZone'] + 3,
                ]);
            }
        });
    }

    /**
     * @return LazyCollection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMoscowAreas(): LazyCollection
    {
        $response = $this->apiGet('area');

        return new LazyCollection(function() use ($response) {
            foreach ($response['AreaList'] as $item) {
                yield new Area([
                    'id' => $item['Id'],
                    'short_name' => $item['Name'],
                    'name' => $item['FullName']
                ]);
            }
        });
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
