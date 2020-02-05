<?php


namespace Veezex\Medical\Docdoc\Models;


class Service extends Model
{
    protected $required = ['Id', 'Name', 'DiagnosticaId', 'SectorId', 'Depth'];

    /**
     * @return string
     */
    public function getDepth(): string
    {
        return $this->get('Depth');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('Name');
    }

    /**
     * @return int|null
     */
    public function getSpecialityId(): ?int
    {
        return $this->get('SectorId');
    }

    /**
     * @return int|null
     */
    public function getDiagnosticId(): ?int
    {
        return $this->get('DiagnosticaId');
    }
}
