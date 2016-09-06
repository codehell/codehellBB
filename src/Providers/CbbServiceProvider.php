<?php

namespace Codehell\Codehellbb\Providers;

use Codehell\Codehellbb\ViewComposers\ForumComposer;
use Illuminate\Support\ServiceProvider;

class CbbServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/codehellbb.php' => config_path('codehellbb.php')
        ], 'config_hell');
        $this->publishes([
            __DIR__ . '/../assets' => public_path('codehell/codehellbb'),
        ], 'public_hell');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'codehellbb');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'codehellbb');

        // Using class based composers...
        view()->composer(
            [
                'codehellbb::forums/index',
                'codehellbb::forums.posts.create',
                'codehellbb::forums.posts.show',
                'codehellbb::forums.posts.edit'
            ], ForumComposer::class
        );

        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../routes/web.php';
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
