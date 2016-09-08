<?php

namespace Codehell\Codehellbb\Policies;

use Codehell\Codehellbb\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicies
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return hell_has_skill_or_more($user, 'Moderator');
    }

    public function edit(User $auth_user, User $user)
    {
        return hell_has_skill_or_more($auth_user, 'Admin') || $auth_user->id === $user->id;
    }

    public function update(User $auth_user, User $user)
    {
        return hell_has_skill_or_more($auth_user, 'Admin') || $auth_user->id === $user->id;
    }

    public function updatePassword(User $auth_user, User $user)
    {
        return $auth_user->id === $user->id;
    }

    public function updateEmail(User $auth_user, User $user)
    {
        return $auth_user->id === $user->id;
    }

    public function updateRole(User $user)
    {
        return hell_has_skill_or_more($user, 'Admin');
    }

}
