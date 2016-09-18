<?php

namespace Codehell\Codehellbb\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Codehell\Codehellbb\Entities\Post;
use Codehell\Codehellbb\Entities\Forum;
use Codehell\Codehellbb\Entities\Comment;
use Codehell\Codehellbb\Policies\PostPolicies;
use Codehell\Codehellbb\Policies\ForumPolicies;
use Codehell\Codehellbb\Policies\CommentPolicies;
use Codehell\Codehellbb\Policies\ProfilePolicies;
use Codehell\Codehellbb\ViewComposers\ForumComposer;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class CbbServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Comment::class  => CommentPolicies::class,
        User::class     => ProfilePolicies::class,
        Forum::class    => ForumPolicies::class,
        Post::class     => PostPolicies::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../routes/web.php';
        }

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

        $this->registerPolicies();

        Gate::define('show-forums', '\Codehell\Codehellbb\Policies\ForumPolicies@index');
        Gate::define('create-forum', '\Codehell\Codehellbb\Policies\ForumPolicies@create');
        Gate::define('is-admin', function ($user) {
            return hell_has_skill_or_more($user, 'Admin');
        });
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
