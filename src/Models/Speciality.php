<?php


namespace Veezex\Medical\Models;


class Speciality extends Model
{
    protected $required = ['name', 'city_ids', 'branch_name', 'name_genitive', 'name_plural', 'name_plural_genitive', 'kids_reception'];

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
    public function getNamePluralGenitive(): string
    {
        return $this->get('name_plural_genitive');
    }

    /**
     * @return string
     */
    public function getNamePlural(): string
    {
        return $this->get('name_plural');
    }

    /**
     * @return string
     */
    public function getNameGenitive(): string
    {
        return $this->get('name_genitive');
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
        return $this->get('city_id');
    }
}
