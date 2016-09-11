<?php

namespace Codehell\Codehellbb\tests;
use Codehell\Codehellbb\Entities\Forum;
use Codehell\Codehellbb\Entities\Post;
use Codehell\Codehellbb\Entities\Profile;
use Codehell\Codehellbb\Entities\User;

class Helpers extends \TestCase
{
    protected $name = 'Damumo';
    protected $email = 'admin@codehell.com';
    protected $password = 'secret';

    protected function createUser($skill)
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($this->password),
        ]);
        factory(Profile::class)->create([
            'user_id' => $user->id,
            'skill' => $skill,
        ]);
        return $user;
    }

    protected function createUserForumPost()
    {
        $user = $this->createUser('Admin');
        $forum = factory(Forum::class)->create([
            'user_id' => $user->id
        ]);
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
            'forum_id' => $forum->id
        ]);

        return [
            'user' => $user,
            'forum' => $forum,
            'post' => $post
        ];
    }
}
