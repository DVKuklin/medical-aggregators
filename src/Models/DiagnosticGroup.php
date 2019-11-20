<?php


namespace Veezex\Medical\Models;


use Illuminate\Support\Collection;

class DiagnosticGroup extends Model
{
    protected $required = ['name', 'diagnostics'];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('name');
    }

    /**
     * @return Collection
     */
    public function getDiagnostics(): Collection
    {
        return $this->get('diagnostics');
    }
}
