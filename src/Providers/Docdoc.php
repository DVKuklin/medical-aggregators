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
use Veezex\Medical\Models\Clinic;

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
     * @param array $cityIds
     * @return Collection
     * @throws Exception
     */
    public function getDoctors(array $cityIds): Collection
    {
        $doctors = [];

        // todo

        return collect($doctors);
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
                    $clinics[] = new Clinic([
                        'id' => $item['Id'],
                        'district_id' => intval($item['DistrictId']),
                        'city_id' => $cityId,
                        'branch_ids' => $item['BranchesId'],
                        'root_clinic_id' => $item['ParentId'],
                        'name' => $item['Name'],
                        'short_name' => $item['ShortName'],
                        'url' => $item['URL'],
                        'lng' => $item['Longitude'],
                        'lat' => $item['Latitude'],
                        'street_id' => intval($item['StreetId']),
                        'addr_city' => $item['City'],
                        'addr_street' => $item['Street'],
                        'addr_house' => $item['House'],
                        'description' => $item['Description'],
                        'short_description' => $item['ShortDescription'],
                        'type_clinic' => $item['isClinic'] === 'yes',
                        'type_diagnostic' => $item['IsDiagnostic'] === 'yes',
                        'type_doctor' => $item['IsDoctor'] === 'yes',
                        'type_text' => $item['TypeOfInstitution'],
                        'phone' => $item['Phone'],
                        'replacement_phone' => $item['ReplacementPhone'],
                        'direct_phone' => $item['PhoneAppointment'],
                        'logo' => $item['Logo'],
                        'email' => $item['Email'],
                        'rating' => $item['Rating'],
                        'min_price' => intval($item['MinPrice']),
                        'max_price' => intval($item['MaxPrice']),
                        'online_schedule' => $item['ScheduleState'] === 'enable',
                        'schedule' => $this->convertSchedule($item['Schedule']),
                        'highlight_discount' => $item['HighlightDiscount'],
                        'request_form_surname' => $item['RequestFormSurname'],
                        'request_form_birthday' => $item['RequestFormBirthday'],
                        'metro_ids' => array_column($item['Stations'] ?? [], 'Id'),
                        'speciality_ids' => array_column($item['Specialities'] ?? [], 'Id'),
                        'service_ids' => array_map(function($service) {
                            return [
                                'id' => $service['ServiceId'],
                                'price' => $service['Price'],
                                'special_price' => $service['SpecialPrice'],
                            ];
                        }, $item['Services']['ServiceList']),
                        'diagnostic_ids' => array_map(function($diagnostic) {
                            return [
                                'id' => $diagnostic['Id'],
                                'price' => $diagnostic['Price'],
                                'special_price' => $diagnostic['SpecialPrice'] ?: null,
                            ];
                        }, $item['Diagnostics'] ?? []),
                    ]);
                }

                $start += $count;
            } while (count($response['ClinicList']) === $count);
        }

        return collect($clinics);
    }

    /**
     * @param array $scheduleArray
     * @return array|null
     */
    protected function convertSchedule(array $scheduleArray): ?array
    {
        if (empty($scheduleArray)) {
            return null;
        }

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $data = [];
        foreach ($scheduleArray as $line) {
            $dataLine = [$line['StartTime'], $line['EndTime']];

            if ($line['Day'] === '0') {
                for ($i = 0; $i < 5; $i++) {
                    $data[$days[$i]] = $dataLine;
                }
            } else {
                $day = intval($line['Day']) - 1;
                $data[$days[$day]] = $dataLine;
            }
        }

        return $data;
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
