<?php


namespace Veezex\Medical\Models;


class Service extends Model
{
    protected $required = ['name', 'diagnostic_id', 'speciality_id'];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('name');
    }

    /**
     * @return int|null
     */
    public function getSpecialityId(): ?int
    {
        return $this->get('speciality_id');
    }

    /**
     * @return int|null
     */
    public function getDiagnosticId(): ?int
    {
        return $this->get('diagnostic_id');
    }
}
