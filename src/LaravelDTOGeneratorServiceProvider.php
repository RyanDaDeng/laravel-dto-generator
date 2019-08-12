<?php

namespace TimeHunter\LaravelDTOGenerator;


use Illuminate\Support\ServiceProvider;
use TimeHunter\LaravelDTOGenerator\Commands\JsonToClassGeneratorCommand;

class LaravelDTOGeneratorServiceProvider extends ServiceProvider
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
            __DIR__.'/../config/dto-generator.php' => config_path('dto-generator.php'),
        ], 'dto-generator.config');

    }
}
