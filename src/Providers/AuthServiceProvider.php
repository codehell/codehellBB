<?php

namespace Codehell\Codehellbb\Providers;

use Codehell\Codehellbb\Entities\Comment;
use Codehell\Codehellbb\Entities\Forum;
use Codehell\Codehellbb\Entities\Post;
use Codehell\Codehellbb\Entities\User;
use Codehell\Codehellbb\Policies\CommentPolicies;
use Codehell\Codehellbb\Policies\ForumPolicies;
use Codehell\Codehellbb\Policies\PostPolicies;
use Codehell\Codehellbb\Policies\ProfilePolicies;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
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
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('show-forums', '\Codehell\Codehellbb\Policies\ForumPolicies@index');
        Gate::define('create-forum', '\Codehell\Codehellbb\Policies\ForumPolicies@create');
        Gate::define('is-admin', function ($user) {
            return hell_has_skill_or_more($user, 'Admin');
        });
    }
}
