<?php

namespace Frikishaan\Autonumber;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Frikishaan\Autonumber\Skeleton\SkeletonClass
 */
class AutonumberFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'autonumber-laravel';
    }
}
