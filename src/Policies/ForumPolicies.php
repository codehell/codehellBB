<?php

namespace Codehell\Codehellbb\Policies;

use Codehell\Codehellbb\Entities\User;
use Codehell\Codehellbb\Entities\Forum;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPolicies
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return hell_has_skill_or_more($user, 'User');
    }

    public function show(User $user, Forum $forum)
    {
        $forum_access = config('forums.forum_access');
        if (isset($forum_access[$forum->id])) {
            return hell_has_skill_or_more($user, $forum_access[$forum->id]);
        }

        return hell_has_skill_or_more($user, 'User');
    }

    public function create(User $user)
    {
        return hell_has_skill_or_more($user, 'Moderator');
    }

    public function createPost(User $user)
    {
        return hell_has_skill_or_more($user, 'User');
    }

    public function update(User $user, Forum $forum)
    {
        return hell_has_skill_or_more($user, 'Admin') ||
            (
                hell_has_skill_or_more($user, 'Moderator') &&
                $user->id == $forum->user_id);
    }

    public function destroy(User $user, Forum $forum)
    {
        return hell_has_skill_or_more($user, 'Admin') ||
            (
                hell_has_skill_or_more($user, 'Moderator') &&
                $user->id == $forum->user_id &&
                $forum->isEmpty()
            );
    }

    public function changeOwner(User $user)
    {
        return hell_has_skill_or_more($user, 'Admin');
    }
}
