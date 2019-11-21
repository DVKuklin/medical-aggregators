<?php


namespace Veezex\Medical\Docdoc\Models;


class District extends Model
{
    protected $required = ['Id', 'CityId', 'Name', 'CityId'];

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->get('CityId');
    }

    /**
     * @return int|null
     */
    public function getAreaId(): ?int
    {
        return $this->get('Area.Id');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('Name');
    }
}
