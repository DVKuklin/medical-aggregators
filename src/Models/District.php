<?php


namespace Veezex\Medical\Models;


class District extends Model
{
    protected $required = ['name', 'city_id', 'area_id'];

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->get('city_id');
    }

    /**
     * @return int|null
     */
    public function getAreaId(): ?int
    {
        return $this->get('area_id');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('name');
    }
}
