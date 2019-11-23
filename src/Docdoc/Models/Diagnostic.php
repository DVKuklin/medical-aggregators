<?php


namespace Veezex\Medical\Docdoc\Models;


class Diagnostic extends Model
{
    protected $required = ['Id', 'Name', 'GroupName'];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('GroupName') . ' ' . $this->get('Name');
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->get('Name');
    }
}
