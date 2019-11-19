<?php

namespace Veezex\Medical;

use Veezex\Medical\Providers\Provider;

class Aggregators
{
    /**
     * @param string $key
     * @return Provider
     */
    public function get(string $key): Provider
    {
        $list = config('medical-aggregators.list');
        if (!is_array($list) || !isset($list[$key])) {
            throw new \OutOfBoundsException("There is no aggregator named $key");
        }

        $serviceInfo = $list[$key];
        return new $serviceInfo['provider']($serviceInfo);
    }
}
