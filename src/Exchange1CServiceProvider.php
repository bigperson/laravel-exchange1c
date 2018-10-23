<?php
/**
 * This file is part of bigperson/laravel-exchange1c package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Bigperson\LaravelExchange1C;

use Bigperson\Exchange1C\Config;
use Bigperson\Exchange1C\Interfaces\EventDispatcherInterface;
use Bigperson\Exchange1C\Interfaces\ModelBuilderInterface;
use Bigperson\Exchange1C\ModelBuilder;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

/**
 * Class Exchange1CServiceProvider.
 */
class Exchange1CServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // routes
        $this->loadRoutesFrom(__DIR__.'/../publish/routes.php');

        // config
        $this->publishes([__DIR__.'/../publish/config/' => config_path()], 'config');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(Config::class, function ($app) {
            return new Config($app['config']['exchange1c']);
        });

        $this->app->singleton(EventDispatcherInterface::class, function ($app) {
            $laravelDispatcher = $app[Dispatcher::class];

            return new LaravelEventDispatcher($laravelDispatcher);
        });

        $this->app->singleton(ModelBuilderInterface::class, function ($app) {
            return $app[ModelBuilder::class];
        });
    }
}
