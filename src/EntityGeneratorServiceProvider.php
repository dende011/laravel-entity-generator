<?php

namespace Dende011\LaravelEntityGenerator;

use Illuminate\Support\ServiceProvider;
use Dende011\LaravelEntityGenerator\Console\Commands\MakeEntity;

class EntityGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeEntity::class,
            ]);
        }
    }
}
