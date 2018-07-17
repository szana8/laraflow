<?php

namespace szana8\Laraflow;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use szana8\Laraflow\Traits\EventMap;

class LaraflowServiceProvider extends ServiceProvider
{
    use EventMap;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/Translation', 'laraflow');

        $this->registerEvents();

    }
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    protected function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        foreach ($this->events as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }
}