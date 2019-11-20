<?php


namespace Veezex\Medical\Models;


class Speciality extends Model
{
    protected $required = ['name', 'city_ids', 'branch_name', 'genitive_name', 'plural_name', 'plural_genitive_name', 'kids_reception'];

    /**
     * @return bool
     */
    public function getKidsReception(): bool
    {
        return $this->get('kids_reception');
    }

    /**
     * @return string
     */
    public function getPluralGenitiveName(): string
    {
        return $this->get('plural_genitive_name');
    }

    /**
     * @return string
     */
    public function getPluralName(): string
    {
        return $this->get('plural_name');
    }

    /**
     * @return string
     */
    public function getGenitiveName(): string
    {
        return $this->get('genitive_name');
    }

    /**
     * @return string
     */
    public function getBranchName(): string
    {
        return $this->get('branch_name');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('name');
    }

    /**
     * @return array
     */
    public function getCityIds(): array
    {
        return $this->get('city_ids');
    }
}
