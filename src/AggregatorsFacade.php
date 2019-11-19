<?php

namespace Veezex\Medical;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Veezex\MedicalServices\Skeleton\SkeletonClass
 */
class AggregatorsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'medical-aggregators';
    }
}
