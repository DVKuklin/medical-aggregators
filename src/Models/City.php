<?php


namespace Veezex\Medical\Models;


class City extends Model
{
    public function getId()
    {
        return $this->data['id'];
    }

    public function getName()
    {
        return $this->data['name'];
    }

    public function getLat()
    {
        return $this->data['lat'];
    }

    public function getLng()
    {
        return $this->data['lng'];
    }

    public function getHasDiagnostic()
    {
        return $this->data['has_diagnostic'];
    }

    public function getTimezoneShift()
    {
        return $this->data['timezone_shift'];
    }
}
