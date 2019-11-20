<?php

namespace Veezex\Medical\Providers;

abstract class Provider
{
    abstract public function getCities(): iterable;
}
