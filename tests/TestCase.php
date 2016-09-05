<?php

use Codehell\Codehellbb\Entities\Forum;
use Codehell\Codehellbb\Entities\Post;
use Codehell\Codehellbb\Entities\User;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    protected $name = 'Damumo';
    protected $email = 'admin@codehell.com';
    protected $password = 'secret';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    protected function createUser($skill)
    {
        return factory(User::class)->create([
            'skill' => $skill,
            'password' => bcrypt($this->password),
        ]);
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
