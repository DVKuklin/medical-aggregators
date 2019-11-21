<?php

namespace Veezex\Medical\Providers;

use Illuminate\Support\Collection;

abstract class Provider
{
    abstract public function getCities(): Collection;
    abstract public function getMoscowAreas(): Collection;
    abstract public function getDistricts(array $cityIds): Collection;
    abstract public function getSpecialities(array $cityIds): Collection;
    abstract public function getDiagnostics(): Collection;
    abstract public function getServices(): Collection;
    abstract public function getClinics(array $cityIds): Collection;
    abstract public function getDoctors(array $cityIds): Collection;
}
