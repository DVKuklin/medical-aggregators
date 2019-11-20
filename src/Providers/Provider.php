<?php

namespace Veezex\Medical\Providers;

use Illuminate\Support\LazyCollection;

abstract class Provider
{
    abstract public function getCities(): LazyCollection;
    abstract public function getMoscowAreas(): LazyCollection;
}
