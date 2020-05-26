<?php

namespace enesyurtlu\PlugMan\Facades;

use Illuminate\Support\Facades\Facade;

class PlugManFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PlugMan';
    }
}
