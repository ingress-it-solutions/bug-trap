<?php

namespace BugTrap;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
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
        if(function_exists('config_path')) {
            /*
             * Publish configuration file
             */
            $this->publishes( [
                __DIR__ . '/../config/bugtrap.php' => config_path( 'bugtrap.php' ),
            ] );
        }

        $this->app['view']->addNamespace('bugtrap', __DIR__ . '/../resources/views');

        if(class_exists(\Illuminate\Foundation\AliasLoader::class)) {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias( 'BugTrap', 'BugTrap\Facade' );
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/bugtrap.php', 'bugtrap');

        $this->app->singleton(Bug-Trap::SERVICE, function ($app) {
            return new Bug-Trap;
        });
    }
}
