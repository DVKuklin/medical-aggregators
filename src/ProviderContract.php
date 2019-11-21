<?php

namespace Veezex\Medical;

use Illuminate\Support\Collection;

interface ProviderContract
{
    public function getCities(): Collection;
    public function getMoscowAreas(): Collection;
    public function getDistricts(array $cityIds): Collection;
    public function getSpecialities(array $cityIds): Collection;
    public function getDiagnostics(): Collection;
    public function getServices(): Collection;
    public function getClinics(array $cityIds): Collection;
    public function getDoctors(array $cityIds): Collection;
}
