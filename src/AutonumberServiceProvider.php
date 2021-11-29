<?php

namespace Frikishaan\Autonumber;

use Frikishaan\Autonumber\Console\CreateAutonumberCommand;
use Frikishaan\Autonumber\Console\ListAllAutonumbersCommand;
use Illuminate\Support\ServiceProvider;

class AutonumberServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * load package assets
         */
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/autonumber.php' => config_path('autonumber.php'),
            ], 'config');

            // Registering package commands.
            $this->commands([
                CreateAutonumberCommand::class,
                ListAllAutonumbersCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/autonumber.php', 'autonumber');

        // Register the main class to use with the facade
        $this->app->singleton('autonumber-laravel', function () {
            return new Autonumber;
        });
    }
}
