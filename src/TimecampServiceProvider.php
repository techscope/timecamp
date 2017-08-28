<?php

namespace techscope\Timecamp;

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
            __DIR__.'/config/timecamp.php', 'timecamp' => config_path('timecamp.php'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('timecamp', function ($app) {
            return new Timecamp($app);
        });

        $this->mergeConfigFrom(
            __DIR__.'/config/timecamp.php', 'timecamp'
        );
    }
}