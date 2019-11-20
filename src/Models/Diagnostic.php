<?php


namespace Veezex\Medical\Models;


class Diagnostic extends Model
{
    protected $required = ['name', 'full_name', 'diagnostic_group_id'];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('name');
    }

    /**
     * @return int
     */
    public function getDiagnosticGroupId(): int
    {
        return $this->get('diagnostic_group_id');
    }
}
