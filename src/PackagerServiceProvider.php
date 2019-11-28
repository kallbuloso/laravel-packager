<?php

namespace kallbuloso\Packager;

use Illuminate\Support\ServiceProvider;

/**
 * This is the service provider.
 *
 * Place the line below in the providers array inside app/config/app.php
 * <code>'kallbuloso\Packager\PackagerServiceProvider',</code>
 *
 * @author JeroenG
 **/
class PackagerServiceProvider extends ServiceProvider
{
    /**
     * The console commands.
     *
     * @var bool
     */
    protected $commands = [
        'kallbuloso\Packager\Commands\NewPackage',
        'kallbuloso\Packager\Commands\RemovePackage',
        'kallbuloso\Packager\Commands\GetPackage',
        'kallbuloso\Packager\Commands\GitPackage',
        'kallbuloso\Packager\Commands\ListPackages',
        'kallbuloso\Packager\Commands\MoveTests',
        'kallbuloso\Packager\Commands\CheckPackage',
        'kallbuloso\Packager\Commands\PublishPackage',
        'kallbuloso\Packager\Commands\EnablePackage',
        'kallbuloso\Packager\Commands\DisablePackage',
    ];

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/packager.php' => config_path('packager.php'),
        ]);
    }

    /**
     * Register the command.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/packager.php', 'packager');

        $this->commands($this->commands);
    }
}
