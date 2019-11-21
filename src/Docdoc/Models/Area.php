<?php


namespace Veezex\Medical\Docdoc\Models;


class Area extends Model
{
    protected $required = ['Id', 'Name', 'FullName'];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('FullName');
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->get('Name');
    }
}
