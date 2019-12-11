<?php /** @noinspection PhpUndefinedMethodInspection */


namespace Veezex\Medical\Docdoc;


use Exception;
use Illuminate\Support\Collection;
use Kozz\Laravel\Facades\Guzzle;
use Veezex\Medical\Docdoc\Models\City;
use Veezex\Medical\Docdoc\Models\Area;
use Veezex\Medical\Docdoc\Models\DiagnosticGroup;
use Veezex\Medical\Docdoc\Models\District;
use Veezex\Medical\Docdoc\Models\DoctorDetails;
use Veezex\Medical\Docdoc\Models\Metro;
use Veezex\Medical\Docdoc\Models\Review;
use Veezex\Medical\Docdoc\Models\Service;
use Veezex\Medical\Docdoc\Models\Speciality;
use Veezex\Medical\Docdoc\Models\Clinic;
use Veezex\Medical\Docdoc\Models\Doctor;
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

        return collect(array_map(function($item) {
            return new City($item);
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
            return new Area($item);
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
                return new District(array_merge($item, ['CityId' => $cityId]));
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

            $metros = array_merge($metros, array_map(function($item) {
                return new Metro($item);
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

        return collect(array_map(function($item) {
            return new Speciality($item);
        }, array_values($specialities)));
    }

    /**
     * @return Collection
     * @throws \Exception
     */
    public function getDiagnosticGroups(): Collection
    {
        $response = $this->apiGet('diagnostic');

        return collect(array_map(function($item) {
            return new DiagnosticGroup($item);
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
            return new Service($item);
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
                    $doctors[] = new Doctor(array_merge($item, ['CityId' => $cityId]));
                }

                $start += $count;
            } while (count($response['DoctorList']) === $count);
        }

        return collect($doctors);
    }

    /**
     * @param int $doctorId
     * @return DoctorDetails
     * @throws Exception
     */
    public function getDoctorDetails(int $doctorId): DoctorDetails
    {
        $response = $this->apiGet("doctor/$doctorId");

        return new DoctorDetails($response['Doctor'][0]);
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

        $reviews = array_map(function($item) {
            return new Review($item);
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
                    $clinics[] = new Clinic(array_merge($item, ['CityId' => $cityId]));
                }

                $start += $count;
            } while (count($response['ClinicList']) === $count);
        }

        return collect($clinics);
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
