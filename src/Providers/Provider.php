<?php

namespace Veezex\Medical\Providers;

use Illuminate\Support\Collection;

abstract class Provider
{
    abstract public function getCities(): Collection;
    abstract public function getMoscowAreas(): Collection;
    abstract public function getDistricts(array $cityIds): Collection;
}
