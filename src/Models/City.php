<?php


namespace Veezex\Medical\Models;


class City extends Model
{
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
    public function getLat(): string
    {
        return $this->get('lat');
    }

    /**
     * @return string
     */
    public function getLng(): string
    {
        return $this->get('lng');
    }

    /**
     * @return bool
     */
    public function getHasDiagnostic(): bool
    {
        return $this->get('has_diagnostic');
    }

    /**
     * @return int
     */
    public function getTimezoneShift(): int
    {
        return $this->get('timezone_shift');
    }
}
