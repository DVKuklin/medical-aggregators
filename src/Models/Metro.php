<?php


namespace Veezex\Medical\Models;


class Metro extends Model
{
    protected $required = ['city_id', 'name', 'line_name', 'line_color', 'lat', 'lng', 'district_ids'];

    /**
     * @return int
     */
    public function getDistrictIds(): array
    {
        return $this->get('district_ids');
    }

    /**
     * @return int
     */
    public function getLng(): string
    {
        return $this->get('lng');
    }

    /**
     * @return int
     */
    public function getLat(): string
    {
        return $this->get('lat');
    }

    /**
     * @return int
     */
    public function getLineColor(): string
    {
        return $this->get('line_color');
    }

    /**
     * @return int
     */
    public function getLineName(): string
    {
        return $this->get('line_name');
    }

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->get('city_id');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('name');
    }
}
