<?php

namespace Epmnzava\Tigosecure\Tests;

use Orchestra\Testbench\TestCase;
use Epmnzava\Tigosecure\TigosecureServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [TigosecureServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
