<?php

namespace Codehell\Codehellbb\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Using class based composers...
        view()->composer(
            [
                'codehellbb::forums/index',
                'codehellbb::forums.posts.create',
                'codehellbb::forums.posts.show',
                'codehellbb::forums.posts.edit'
            ], 'Codehell\Codehellbb\ViewComposers\ForumComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
