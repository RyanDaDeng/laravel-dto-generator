<?php

namespace TimeHunter\LaravelJsonToClassGenerator;


use Illuminate\Support\ServiceProvider;
use TimeHunter\LaravelJsonToClassGenerator\Commands\JsonToClassGeneratorCommand;

class LaravelJsonToClassGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
            $this->commands([
                JsonToClassGeneratorCommand::class,
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/jsontoclassgenerator.php' => config_path('jsontoclassgenerator.php'),
        ], 'jsontoclassgenerator.config');

    }
}
