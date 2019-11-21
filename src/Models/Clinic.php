<?php


namespace Veezex\Medical\Models;


class Clinic extends Model
{
    protected $required = [
        'district_id',
        'city_id',
        'branch_ids',
        'root_clinic_id',
        'name',
        'short_name',
        'url',
        'lng',
        'lat',
        'street_id',
        'addr_city',
        'addr_street',
        'addr_house',
        'description',
        'short_description',
        'type_clinic',
        'type_diagnostic',
        'type_doctor',
        'type_text',
        'phone',
        'replacement_phone',
        'direct_phone',
        'logo',
        'email',
        'rating',
        'min_price',
        'max_price',
        'online_schedule',
        'schedule',
        'highlight_discount',
        'request_form_surname',
        'request_form_birthday',
        'metro_ids',
        'speciality_ids',
        'service_ids',
        'diagnostic_ids',
    ];

    /**
     * @return array
     */
    public function getBranchIds(): array
    {
        return $this->get('branch_ids');
    }

    /**
     * @return int
     */
    public function getRootClinicId(): int
    {
        return $this->get('root_clinic_id');
    }

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->get('city_id');
    }

    /**
     * @return int
     */
    public function getDistrictId(): int
    {
        return $this->get('district_id');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('name');
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->get('short_name');
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->get('url');
    }

    /**
     * @return string
     */
    public function getLng(): string
    {
        return $this->get('lng');
    }

    /**
     * @return string
     */
    public function getLat(): string
    {
        return $this->get('lat');
    }

    /**
     * @return int
     */
    public function getStreetId(): int
    {
        return $this->get('street_id');
    }

    /**
     * @return string
     */
    public function getAddrCity(): string
    {
        return $this->get('addr_city');
    }

    /**
     * @return string
     */
    public function getAddrStreet(): string
    {
        return $this->get('addr_street');
    }

    /**
     * @return string
     */
    public function getAddrHouse(): string
    {
        return $this->get('addr_house');
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->get('description');
    }

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->get('short_description');
    }

    /**
     * @return bool
     */
    public function getTypeDiagnostic(): bool
    {
        return $this->get('type_diagnostic');
    }

    /**
     * @return bool
     */
    public function getTypeClinic(): bool
    {
        return $this->get('type_clinic');
    }

    /**
     * @return bool
     */
    public function getTypeDoctor(): bool
    {
        return $this->get('type_doctor');
    }

    /**
     * @return string
     */
    public function getTypeText(): string
    {
        return $this->get('type_text');
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->get('phone');
    }

    /**
     * @return string|null
     */
    public function getReplacementPhone(): ?string
    {
        return $this->get('replacement_phone');
    }

    /**
     * @return string
     */
    public function getDirectPhone(): string
    {
        return $this->get('direct_phone');
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->get('logo');
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->get('email');
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->get('rating');
    }

    /**
     * @return int
     */
    public function getMinPrice(): int
    {
        return $this->get('min_price');
    }

    /**
     * @return int
     */
    public function getMaxPrice(): int
    {
        return $this->get('max_price');
    }

    /**
     * @return bool
     */
    public function getOnlineSchedule(): bool
    {
        return $this->get('online_schedule');
    }

    /**
     * @return array
     */
    public function getSchedule(): array
    {
        return $this->get('schedule');
    }

    /**
     * @return int
     */
    public function getHighlightDiscount(): int
    {
        return $this->get('highlight_discount');
    }

    /**
     * @return bool
     */
    public function getRequestFormSurname(): bool
    {
        return $this->get('request_form_surname');
    }

    /**
     * @return bool
     */
    public function getRequestFormBirthday(): bool
    {
        return $this->get('request_form_birthday');
    }

    /**
     * @return array
     */
    public function getMetroIds(): array
    {
        return $this->get('metro_ids');
    }

    /**
     * @return array
     */
    public function getSpecialityIds(): array
    {
        return $this->get('speciality_ids');
    }

    /**
     * @return array
     */
    public function getServiceIds(): array
    {
        return $this->get('service_ids');
    }

    /**
     * @return array
     */
    public function getDiagnosticIds(): array
    {
        return $this->get('diagnostic_ids');
    }
}
