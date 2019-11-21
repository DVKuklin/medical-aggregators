<?php


namespace Veezex\Medical\Docdoc\Models;


class Doctor extends Model
{
    protected $required = [
        'Id',
        'CityId',
        'Name',
        'Sex',
        'Rating',
        'Img',
        'Category',
        'Degree',
        'Rank',
        'Description',
        'TextAbout',
        'ExperienceYear',
        'Price',
        'SpecialPrice',
        'KidsReception',
        'isActive',
        'Departure',
        'AddPhoneNumber',
        'OpinionCount',
        'FocusClinic',
        'BookingClinics',
        'Clinics',
        'ClinicsInfo',
    ];

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->get('CityId');
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
    public function getSex(): string
    {
        return [
            '1' => 'female',
            '0' => 'male',
        ][$this->get('Sex')];
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->get('Rating');
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->get('Img');
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->get('Category') ?: null;
    }

    /**
     * @return string|null
     */
    public function getDegree(): ?string
    {
        return $this->get('Degree') ?: null;
    }

    /**
     * @return string|null
     */
    public function getRank(): ?string
    {
        return $this->get('Rank') ?: null;
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
    public function getAbout(): string
    {
        return $this->get('TextAbout');
    }

    /**
     * @return int
     */
    public function getExperienceYears(): int
    {
        return $this->get('ExperienceYear');
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->get('Price');
    }

    /**
     * @return int|null
     */
    public function getSpecialPrice(): ?int
    {
        return $this->get('SpecialPrice');
    }

    /**
     * @return bool
     */
    public function getKidsReception(): bool
    {
        return $this->get('KidsReception') === '1';
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->get('isActive');
    }

    /**
     * @return bool
     */
    public function getDeparture(): bool
    {
        return $this->get('Departure') === 1;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->get('AddPhoneNumber') ?: null;
    }

    /**
     * @return int
     */
    public function getReviewsCount(): int
    {
        return $this->get('OpinionCount');
    }

    /**
     * @return int
     */
    public function getFocusClinicId(): int
    {
        return $this->get('FocusClinic');
    }

    /**
     * @return array
     */
    public function getBookingClinicIds(): array
    {
        return $this->get('BookingClinics');
    }

    /**
     * @return array
     */
    public function getClinicIds(): array
    {
        return $this->get('Clinics');
    }

    /**
     * @return array
     */
    public function getPriceList(): array
    {
        $result = [];

        foreach ($this->get('ClinicsInfo') as $clinic) {
            $result[$clinic['ClinicId']] = array_map(function($speciality) {
                return [
                    'speciality_id' => $speciality['SpecialityId'],
                    'price' => $speciality['Price'],
                    'special_price' => $speciality['SpecialPrice'],
                    'departure_price' => [$speciality['DeparturePriceFrom'] ?? null, $speciality['DeparturePriceTo'] ?? null],
                ];
            }, $clinic['Specialities']);
        }

        return $result;
    }
}
