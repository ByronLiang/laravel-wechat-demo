<?php

namespace Ganguo\JSend\Facades;

use Illuminate\Support\Facades\Facade;

class JSend extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'jsend';
    }
}
