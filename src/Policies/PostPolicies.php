<?php

namespace Codehell\Codehellbb\Policies;

use Codehell\Codehellbb\Entities\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicies
{
    use HandlesAuthorization;

    public function show(User $user)
    {
        return hell_has_skill_or_more($user, 'User');
    }
    
    public function update(User $user, Post $post)
    {
        return hell_has_skill_or_more($user, 'Admin') ||
            ($user->id == $post->user_id && hell_has_skill_or_more($user, 'Moderator')) ||
            ($user->id == $post->user_id && $post->isEmpty());
    }
    
    public function destroy(User $user, Post $post)
    {
        return hell_has_skill_or_more($user, 'Admin') ||
            ($user->id == $post->user_id && hell_has_skill_or_more($user, 'Moderator')) ||
            ($user->id == $post->user_id && $post->isEmpty());
    }
}
