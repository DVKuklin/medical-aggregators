<?php


namespace Veezex\Medical\Models;


use Illuminate\Support\Collection;

class DiagnosticGroup extends Model
{
    protected $required = ['Id', 'Name', 'SubDiagnosticList'];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('Name');
    }

    /**
     * @return Collection
     */
    public function getDiagnostics(): Collection
    {
        return collect(array_map(function($item) {
            return new Diagnostic($item);
        }, $this->get('SubDiagnosticList')));
    }
}
