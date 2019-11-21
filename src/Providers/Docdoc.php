<?php /** @noinspection PhpUndefinedMethodInspection */


namespace Veezex\Medical\Providers;


use Exception;
use Illuminate\Support\Collection;
use Kozz\Laravel\Facades\Guzzle;
use Veezex\Medical\Models\City;
use Veezex\Medical\Models\Area;
use Veezex\Medical\Models\Diagnostic;
use Veezex\Medical\Models\DiagnosticGroup;
use Veezex\Medical\Models\District;
use Veezex\Medical\Models\Metro;
use Veezex\Medical\Models\Service;
use Veezex\Medical\Models\Speciality;

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
     * @var int
     */
    private $max_tries;
    /**
     * @var int
     */
    private $retry_after;

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
        $this->max_tries = $settings['max_tries'];
        $this->retry_after = $settings['retry_after'];
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function getCities(): Collection
    {
        $response = $this->apiGet('city');

        return collect(array_map(function($item) {
            return new City([
                'id' => $item['Id'],
                'name' => $item['Name'],
                'lat' => $item['Latitude'],
                'lng' => $item['Longitude'],
                'has_diagnostic' => $item['HasDiagnostic'],
                'timezone_shift' => $item['TimeZone'] + 3,
            ]);
        }, $response['CityList']));
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function getMoscowAreas(): Collection
    {
        $response = $this->apiGet('area');

        return collect(array_map(function($item) {
            return new Area([
                'id' => $item['Id'],
                'short_name' => $item['Name'],
                'name' => $item['FullName']
            ]);
        }, $response['AreaList']));
    }

    /**
     * @param array $cityIds
     * @return Collection
     * @throws \Exception
     */
    public function getDistricts(array $cityIds): Collection
    {
        $districts = [];

        foreach ($cityIds as $cityId) {
            $response = $this->apiGet("district/city/$cityId");

            $districts = array_merge($districts, array_map(function($item) use ($cityId) {
                return new District([
                    'id' => $item['Id'],
                    'city_id' => $cityId,
                    'area_id' => isset($item['Area']) ? $item['Area']['Id'] : null,
                    'name' => $item['Name']
                ]);
            }, $response['DistrictList']));
        }

        return collect($districts);
    }

    /**
     * @param array $cityIds
     * @return Collection
     * @throws \Exception
     */
    public function getMetros(array $cityIds): Collection
    {
        $metros = [];

        foreach ($cityIds as $cityId) {
            $response = $this->apiGet("metro/city/$cityId");

            $metros = array_merge($metros, array_map(function($item) use ($cityId) {
                return new Metro([
                    'id' => $item['Id'],
                    'city_id' => $item['CityId'],
                    'name' => $item['Name'],
                    'line_name' => $item['LineName'],
                    'line_color' => $item['LineColor'],
                    'lng' => (string) $item['Longitude'],
                    'lat' => (string) $item['Latitude'],
                    'district_ids' => $item['DistrictIds'],
                ]);
            }, $response['MetroList']));
        }

        return collect($metros);
    }

    /**
     * @param array $cityIds
     * @return Collection
     * @throws \Exception
     */
    public function getSpecialities(array $cityIds): Collection
    {
        $specialities = [];

        foreach ($cityIds as $cityId) {
            $response = $this->apiGet("speciality/city/$cityId");

            foreach ($response['SpecList'] as $item) {
                if (isset($specialities[$item['Id']])) {
                    $specialities[$item['Id']]['city_ids'][] = $cityId;
                    continue;
                }

                $specialities[$item['Id']] = [
                    'id' => $item['Id'],
                    'name'=> $item['Name'],
                    'branch_name'=> $item['BranchName'],
                    'genitive_name'=> $item['NameGenitive'],
                    'plural_name'=> $item['NamePlural'],
                    'plural_genitive_name'=> $item['NamePluralGenitive'],
                    'kids_reception'=> $item['KidsReception'] === 1,
                    'city_ids' => [$cityId]
                ];
            }
        }

        return collect(array_map(function($item) {
            $item['id'] = intval($item['id']);
            return new Speciality($item);
        }, array_values($specialities)));
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function getDiagnostics(): Collection
    {
        $response = $this->apiGet('diagnostic');

        return collect(array_map(function($item) {
            return new DiagnosticGroup([
                'id' => $item['Id'],
                'name' => $item['Name'],
                'diagnostics' => collect(array_map(function($subItem) use ($item) {
                    return new Diagnostic([
                        'id' => $subItem['Id'],
                        'name' => $subItem['Name'],
                        'full_name' => "{$item['Name']} {$subItem['Name']}",
                        'diagnostic_group_id' => $item['Id'],
                    ]);
                }, $item['SubDiagnosticList']))
            ]);
        }, $response['DiagnosticList']));
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function getServices(): Collection
    {
        $response = $this->apiGet('service/list');

        $services = array_map(function($item) {
            return new Service([
                'id' => $item['Id'],
                'diagnostic_id' => $item['DiagnosticaId'],
                'speciality_id' => $item['SectorId'],
                'name' => $item['Name']
            ]);
        }, $response['ServiceList']);

        return collect($services);
    }

    /**
     * @param string $uri
     * @return array
     * @throws \Exception
     */
    public function apiGet(string $uri): array
    {
        $tries = $this->max_tries;

        while ($tries--) {
            try {
                $result = Guzzle::get("$this->endpoint$uri", [
                    'auth' => [$this->login, $this->password]
                ]);
                break;
            } catch (Exception $e) {
                if ($tries === 0) {
                    throw $e;
                } else {
                    sleep($this->retry_after);
                }
            }
        }

        return json_decode($result->getBody(), true);
    }
}
