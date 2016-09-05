<?php

namespace Codehell\Codehellbb\Policies;

use Codehell\Codehellbb\Entities\Comment;
use Codehell\Codehellbb\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicies
{
    use HandlesAuthorization;
    
    public function store(User $user)
    {
        return hell_has_skill_or_more($user, 'User');
    }

    public function update(User $user, Comment $comment)
    {
        return hell_has_skill_or_more($user, 'Admin') ||
        ($user->id == $comment->user_id &&
            !$comment->hasReplies() &&
            hell_has_skill_or_more($user, 'User'));
    }

    public function destroy(User $user, Comment $comment)
    {
        return hell_has_skill_or_more($user, 'Moderator') ||
        ($user->id == $comment->user_id &&
            !$comment->hasReplies() &&
            hell_has_skill_or_more($user, 'User'));
    }
}
