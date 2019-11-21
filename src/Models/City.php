<?php


namespace Veezex\Medical\Models;


class City extends Model
{
    protected $required = ['Id', 'Name', 'Longitude', 'Latitude', 'HasDiagnostic', 'TimeZone'];

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
    public function getLat(): string
    {
        return $this->get('Latitude');
    }

    /**
     * @return string
     */
    public function getLng(): string
    {
        return $this->get('Longitude');
    }

    /**
     * @return bool
     */
    public function getHasDiagnostic(): bool
    {
        return $this->get('HasDiagnostic');
    }

    /**
     * @return int
     */
    public function getTimezoneShift(): int
    {
        return $this->get('TimeZone') + 3;
    }
}
