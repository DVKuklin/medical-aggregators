<?php


namespace Veezex\Medical\Models;


class Metro extends Model
{
    protected $required = ['Id', 'CityId', 'Name', 'LineName', 'LineColor', 'Latitude', 'Longitude', 'DistrictIds'];

    /**
     * @return int
     */
    public function getDistrictIds(): array
    {
        return $this->get('DistrictIds');
    }

    /**
     * @return int
     */
    public function getLng(): string
    {
        return $this->get('Longitude');
    }

    /**
     * @return int
     */
    public function getLat(): string
    {
        return $this->get('Latitude');
    }

    /**
     * @return int
     */
    public function getLineColor(): string
    {
        return $this->get('LineColor');
    }

    /**
     * @return int
     */
    public function getLineName(): string
    {
        return $this->get('LineName');
    }

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
}
