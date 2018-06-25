<?php

namespace Ganguo\JSend;

use Illuminate\Support\ServiceProvider;

class JSendServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('jsend', function ($app) {
            return new JSend();
        });
    }
}
