<?php

namespace Epmnzava\Tigosecure;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Epmnzava\Tigosecure\Skeleton\SkeletonClass
 */
class TigosecureFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tigosecure';
    }
}
