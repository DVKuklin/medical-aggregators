<?php

namespace Veezex\Medical\Providers;


use Illuminate\Support\LazyCollection;

class Dummy extends Provider
{
    public function getCities(): LazyCollection
    {
        return collect([]);
    }

    public function getMoscowAreas(): LazyCollection
    {
        return collect([]);
    }
}
