<?php /** @noinspection PhpUndefinedMethodInspection */


namespace Veezex\Medical\Docdoc;


use Exception;
use Illuminate\Support\Collection;
use Kozz\Laravel\Facades\Guzzle;
use Veezex\Medical\ProviderContract;

class Provider implements ProviderContract
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
     * @var array
     */
    private $models;

    /**
     * Docdoc constructor.
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->endpoint = $settings['test']
            ? 'https://api.bookingtest.docdoc.pro/public/rest/1.0.12/'
            : 'https://back.docdoc.ru/public/rest/1.0.12/';

        $this->login = $settings['login'];
        $this->password = $settings['password'];
        $this->max_tries = $settings['max_tries'];
        $this->retry_after = $settings['retry_after'];
        $this->models = $settings['models'];
    }

    /**
     * @return string
     */
    public function getProviderName(): string
    {
        return 'Docdoc';
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function getCities(): Collection
    {
        $response = $this->apiGet('city');

        return collect(array_map(function ($item) {
            return new $this->models['City']($item);
        }, $response['CityList']));
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function getMoscowAreas(): Collection
    {
        $response = $this->apiGet('area');

        return collect(array_map(function ($item) {
            return new $this->models['Area']($item);
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

            $districts = array_merge($districts, array_map(function ($item) use ($cityId) {
                return new $this->models['District'](array_merge($item, ['CityId' => $cityId]));
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

            $metros = array_merge($metros, array_map(function ($item) {
                return new $this->models['Metro']($item);
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
                    $specialities[$item['Id']]['CityIds'][] = $cityId;
                    continue;
                }

                $item['CityIds'] = [$cityId];
                $specialities[$item['Id']] = $item;
            }
        }

        return collect(array_map(function ($item) {
            return new $this->models['Speciality']($item);
        }, array_values($specialities)));
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function getDiagnosticGroups(): Collection
    {
        $response = $this->apiGet('diagnostic');

        return collect(array_map(function ($item) {
            return new $this->models['DiagnosticGroup']($item);
        }, $response['DiagnosticList']));
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function getServices(): Collection
    {
        $response = $this->apiGet('service/list');

        $services = array_map(function ($item) {
            return new $this->models['Service']($item);
        }, $response['ServiceList']);

        return collect($services);
    }

    /**
     * @param array $cityIds
     * @return Collection
     * @throws Exception
     */
    public function getDoctors(array $cityIds): Collection
    {
        $doctors = [];

        foreach ($cityIds as $cityId) {
            $start = 0;
            $count = 500;
            do {
                $response = $this->apiGet("doctor/list/city/$cityId/start/$start/count/$count");

                foreach ($response['DoctorList'] as $item) {
                    $doctors[] = new $this->models['Doctor'](array_merge($item, ['CityId' => $cityId]));
                }

                $start += $count;
            } while (count($response['DoctorList']) === $count);
        }

        return collect($doctors);
    }

    /**
     * @param int $doctorId
     * @return mixed
     * @throws Exception
     */
    public function getDoctorDetails(int $doctorId)
    {
        $response = $this->apiGet("doctor/$doctorId");

        return new $this->models['DoctorDetails']($response['Doctor'][0]);
    }

    /**
     * @param int $doctorId
     * @return Collection
     * @throws Exception
     */
    public function getDoctorReviews(int $doctorId): Collection
    {
        return $this->getReviews($doctorId, 'review/doctor');
    }

    /**
     * @param int $clinicId
     * @return Collection
     * @throws Exception
     */
    public function getClinicReviews(int $clinicId): Collection
    {
        return $this->getReviews($clinicId, 'review/clinic');
    }

    /**
     * @param int $entityId
     * @param string $apiUrl
     * @return Collection
     * @throws Exception
     */
    protected function getReviews(int $entityId, string $apiUrl): Collection
    {
        $response = $this->apiGet("$apiUrl/$entityId");

        $reviews = array_map(function ($item) {
            return new $this->models['Review']($item);
        }, $response['ReviewList']);

        return collect($reviews);
    }

    /**
     * @param array $cityIds
     * @return Collection
     * @throws Exception
     */
    public function getClinics(array $cityIds): Collection
    {
        $clinics = [];

        foreach ($cityIds as $cityId) {
            $start = 0;
            $count = 500;
            do {
                $response = $this->apiGet("clinic/list/city/$cityId/start/$start/count/$count");

                foreach ($response['ClinicList'] as $item) {
                    $clinics[] = new $this->models['Clinic'](array_merge($item, ['CityId' => $cityId]));
                }

                $start += $count;
            } while (count($response['ClinicList']) === $count);
        }

        return collect($clinics);
    }

    /**
     * @param integer $doctorId
     * @param integer $clinicId
     * @param integer $days
     *
     * @return Collection
     */
    public function getDoctorSlots(int $doctorId, int $clinicId, int $days): Collection
    {
        $from = date('Y-m-d');
        $to = date('Y-m-d', time() + ($days * 24 * 3600));

        $response = $this->apiGet("slot/list/doctor/{$doctorId}/clinic/{$clinicId}/from/{$from}/to/{$to}");

        return collect($response['SlotList'])->transform(function($item) {
            return new $this->models['Slot']($item);
        });
    }

    /**
     * @param integer $diagnosticId
     * @param integer $clinicId
     * @param integer $days
     *
     * @return Collection
     */
    public function getDiagnosticSlots(int $diagnosticId, int $clinicId, int $days): Collection
    {
        $from = date('Y-m-d');
        $to = date('Y-m-d', time() + ($days * 24 * 3600));

        $response = $this->apiGet("slot/list/diagnostic/{$diagnosticId}/clinic/{$clinicId}/from/{$from}/to/{$to}");

        return collect($response['SlotList'])->transform(function($item) {
            return new $this->models['Slot']($item);
        });
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

        $result = json_decode($result->getBody(), true);

        if (array_key_exists('status', $result) && $result['status'] === 'error') {
            throw new Exception('Medical loader exception: ' . $result['message']);
        }

        return $result;
    }
}
