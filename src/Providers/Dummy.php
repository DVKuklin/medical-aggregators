<?php

namespace Veezex\Medical\Providers;

class Dummy extends Provider
{
    public function cities(): iterable
    {
        return [];
    }
}
