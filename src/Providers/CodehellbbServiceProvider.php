<?php

namespace Codehell\Codehellbb\Providers;

use Codehell\Codehellbb\Middleware\ForumAccessControl;
use Illuminate\Support\ServiceProvider;

class CodehellbbServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/codehellbb.php'
        ]);
        $this->publishes([
            __DIR__ . '/../assets' => public_path('codehell/codehellbb'),
        ], 'public');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'codehellbb');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'codehellbb');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/../routes/web.php';
        include __DIR__ . '/../helpers.php';
    }
}
