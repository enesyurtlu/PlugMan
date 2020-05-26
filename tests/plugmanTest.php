<?php

namespace enesyurtlu\plugman\Tests;

use enesyurtlu\plugman\Facades\PlugManFacade;
use enesyurtlu\plugman\ServiceProvider;
use Orchestra\Testbench\TestCase;

class plugmanTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'plugman' => PlugManFacade::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
