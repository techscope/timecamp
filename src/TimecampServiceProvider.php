<?php

namespace Techscope\Timecamp;

use Illuminate\Support\ServiceProvider;

class TimecampServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/timecamp.php', config_path('timecamp.php'),
        ], 'config');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/timecamp.php', 'timecamp'
        );

        $this->app->bind('timecamp', function ($app) {
            return new Timecamp($app);
        });
    }
}