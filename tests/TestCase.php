<?php

namespace Frikishaan\Autonumber\Tests;

use Frikishaan\Autonumber\AutonumberServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Prepare Database
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->artisan('migrate');
    }

    protected function getPackageProviders($app)
    {
        return [
            AutonumberServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
