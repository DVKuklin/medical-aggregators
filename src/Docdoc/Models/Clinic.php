<?php


namespace Veezex\Medical\Docdoc\Models;


class Clinic extends Model
{
    protected $required = [
        'Id',
        'DistrictId',
        'CityId',
        'BranchesId',
        'ParentId',
        'Name',
        'ShortName',
        'URL',
        'Longitude',
        'Latitude',
        'StreetId',
        'City',
        'Street',
        'House',
        'Description',
        'ShortDescription',
        'isClinic',
        'IsDiagnostic',
        'IsDoctor',
        'TypeOfInstitution',
        'Phone',
        'ReplacementPhone',
        'PhoneAppointment',
        'Logo',
        'Email',
        'Rating',
        'MinPrice',
        'MaxPrice',
        'ScheduleState',
        'Schedule',
        'HighlightDiscount',
        'RequestFormSurname',
        'RequestFormBirthday',
        'Stations',
        'Specialities',
        'Services',
    ];

    /**
     * @return array
     */
    public function getBranchIds(): array
    {
        return $this->get('BranchesId');
    }

    /**
     * @return int
     */
    public function getRootClinicId(): int
    {
        return $this->get('ParentId');
    }

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->get('CityId');
    }

    /**
     * @return int
     */
    public function getDistrictId(): int
    {
        return $this->get('DistrictId');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('Name');
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->get('ShortName');
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->get('URL');
    }

    /**
     * @return string|null
     */
    public function getLng(): ?string
    {
        return $this->get('Longitude');
    }

    /**
     * @return string|null
     */
    public function getLat(): ?string
    {
        return $this->get('Latitude');
    }

    /**
     * @return int
     */
    public function getStreetId(): int
    {
        return $this->get('StreetId');
    }

    /**
     * @return string
     */
    public function getAddrCity(): string
    {
        return $this->get('City');
    }

    /**
     * @return string
     */
    public function getAddrStreet(): string
    {
        return $this->get('Street');
    }

    /**
     * @return string
     */
    public function getAddrHouse(): string
    {
        return $this->get('House');
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->get('Description');
    }

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->get('ShortDescription');
    }

    /**
     * @return bool
     */
    public function getTypeDiagnostic(): bool
    {
        return $this->get('IsDiagnostic') === 'yes';
    }

    /**
     * @return bool
     */
    public function getTypeClinic(): bool
    {
        return $this->get('isClinic') === 'yes';
    }

    /**
     * @return bool
     */
    public function getTypeDoctor(): bool
    {
        return $this->get('IsDoctor') === 'yes';
    }

    /**
     * @return string
     */
    public function getTypeText(): string
    {
        return $this->get('TypeOfInstitution');
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->get('Phone');
    }

    /**
     * @return string|null
     */
    public function getReplacementPhone(): ?string
    {
        return $this->get('ReplacementPhone');
    }

    /**
     * @return string
     */
    public function getDirectPhone(): string
    {
        return $this->get('PhoneAppointment');
    }

    /**
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->get('Logo');
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->get('Email');
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->get('Rating');
    }

    /**
     * @return int
     */
    public function getMinPrice(): int
    {
        return intval($this->get('MinPrice'));
    }

    /**
     * @return int
     */
    public function getMaxPrice(): int
    {
        return intval($this->get('MaxPrice'));
    }

    /**
     * @return bool
     */
    public function getOnlineSchedule(): bool
    {
        return $this->get('ScheduleState') === 'enable';
    }

    /**
     * @return array|null
     */
    public function getSchedule(): ?array
    {
        return $this->convertSchedule(
            $this->get('Schedule')
        );
    }

    /**
     * @return int|null
     */
    public function getHighlightDiscount(): ?int
    {
        return $this->get('HighlightDiscount') ?: null;
    }

    /**
     * @return bool
     */
    public function getRequestFormSurname(): bool
    {
        return $this->get('RequestFormSurname');
    }

    /**
     * @return bool
     */
    public function getRequestFormBirthday(): bool
    {
        return $this->get('RequestFormBirthday');
    }

    /**
     * @return array
     */
    public function getMetroIds(): array
    {
        return array_column($this->get('Stations', []), 'Id');
    }

    /**
     * @return array
     */
    public function getSpecialityIds(): array
    {
        return array_column($this->get('Specialities', []), 'Id');
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        return array_map(function($service) {
            return [
                'id' => $service['ServiceId'],
                'price' => $service['Price'],
                'special_price' => $service['SpecialPrice'],
            ];
        }, $this->get('Services.ServiceList', []));
    }

    /**
     * @return array
     */
    public function getDiagnostics(): array
    {
        return array_map(function($diagnostic) {
            return [
                'id' => $diagnostic['Id'],
                'price' => $diagnostic['Price'],
                'special_price' => $diagnostic['SpecialPrice'] ?: null,
            ];
        }, $this->get('Diagnostics', []));
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
            $dataLine = [
                'from' => $this->timeStringToMinutes($line['StartTime']),
                'to' => $this->timeStringToMinutes($line['EndTime'])
            ];

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
     * @param string $time
     *
     * @return integer
     */
    protected function timeStringToMinutes(string $time): int
    {
        [$hours, $minutes] = explode(':', $time);
        return intval($hours) * 60 + intval($minutes);
    }
}
