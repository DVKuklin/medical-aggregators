<?php


namespace Veezex\Medical\Models;


class City extends Model
{
    public function getId(): int
    {
        return $this->data['id'];
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getLat(): string
    {
        return $this->data['lat'];
    }

    public function getLng(): string
    {
        return $this->data['lng'];
    }

    public function getHasDiagnostic(): bool
    {
        return $this->data['has_diagnostic'];
    }

    public function getTimezoneShift(): int
    {
        return $this->data['timezone_shift'];
    }
}
