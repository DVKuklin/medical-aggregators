<?php


namespace Veezex\Medical\Models;


class Speciality extends Model
{
    protected $required = ['Id', 'Name', 'CityIds', 'BranchName', 'NameGenitive', 'NamePlural', 'NamePluralGenitive', 'KidsReception'];

    /**
     * @return bool
     */
    public function getKidsReception(): bool
    {
        return $this->get('KidsReception') === 1;
    }

    /**
     * @return string
     */
    public function getPluralGenitiveName(): string
    {
        return $this->get('NamePluralGenitive');
    }

    /**
     * @return string
     */
    public function getPluralName(): string
    {
        return $this->get('NamePlural');
    }

    /**
     * @return string
     */
    public function getGenitiveName(): string
    {
        return $this->get('NameGenitive');
    }

    /**
     * @return string
     */
    public function getBranchName(): string
    {
        return $this->get('BranchName');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('Name');
    }

    /**
     * @return array
     */
    public function getCityIds(): array
    {
        return $this->get('CityIds');
    }
}
