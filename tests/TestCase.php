<?php

namespace Fireworkweb\Gates\Tests;

use Fireworkweb\Gates\GatesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [ GatesServiceProvider::class ];
    }
}
