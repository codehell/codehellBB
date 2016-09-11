<?php

use Codehell\Codehellbb\Entities\Forum;
use Codehell\Codehellbb\Entities\Post;
use Codehell\Codehellbb\Policies\ForumPolicies;
use Codehell\Codehellbb\tests\Helpers;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PoliciesTest extends Helpers
{
    use DatabaseTransactions;

    public function test_forum_policies_guest()
    {
        $data = $this->createUserForumPost();
        $user = $this->createUser('Guest');
        $forum_policy = new ForumPolicies;

        $this->assertFalse($forum_policy->index($user));
        $this->assertFalse($forum_policy->show($user, $data['forum']));
        $this->assertFalse($forum_policy->create($user));
        $this->assertFalse($forum_policy->createPost($user));
        $this->assertFalse($forum_policy->update($user, $data['forum']));
        $this->assertFalse($forum_policy->destroy($user, $data['forum']));
        $this->assertFalse($forum_policy->changeOwner($user));
    }

    public function test_forum_policies_user()
    {
        $data = $this->createUserForumPost();
        $user = $this->createUser('User');
        $forum_policy = new ForumPolicies;

        $this->assertTrue($forum_policy->index($user));
        $this->assertTrue($forum_policy->show($user, $data['forum']));
        $this->assertFalse($forum_policy->create($user));
        $this->assertTrue($forum_policy->createPost($user));
        $this->assertFalse($forum_policy->update($user, $data['forum']));
        $this->assertFalse($forum_policy->destroy($user, $data['forum']));
        $this->assertFalse($forum_policy->changeOwner($user));
    }

    public function test_forum_policies_moderator()
    {
        $data = $this->createUserForumPost();
        $user = $this->createUser('Moderator');
        $user_forum = factory(Forum::class)->create(['user_id' => $user->id]);
        $forum_policy = new ForumPolicies;

        $this->assertTrue($forum_policy->index($user));
        $this->assertTrue($forum_policy->show($user, $data['forum']));
        $this->assertTrue($forum_policy->create($user));
        $this->assertTrue($forum_policy->createPost($user));
        $this->assertFalse($forum_policy->update($user, $data['forum']));
        $this->assertTrue($forum_policy->update($user, $user_forum));
        $this->assertFalse($forum_policy->destroy($user, $data['forum']));
        $this->assertTrue($forum_policy->destroy($user, $user_forum));
        $this->assertFalse($forum_policy->changeOwner($user));

        factory(Post::class)->create(['forum_id' => $user_forum->id]);
        $this->assertFalse($forum_policy->destroy($user, $user_forum));
    }

    public function test_forum_policies_admin()
    {
        $data = $this->createUserForumPost();
        $user = $this->createUser('Admin');
        $user_forum = factory(Forum::class)->create(['user_id' => $user->id]);
        $forum_policy = new ForumPolicies;

        $this->assertTrue($forum_policy->index($user));
        $this->assertTrue($forum_policy->show($user, $data['forum']));
        $this->assertTrue($forum_policy->create($user));
        $this->assertTrue($forum_policy->createPost($user));
        $this->assertTrue($forum_policy->update($user, $data['forum']));
        $this->assertTrue($forum_policy->update($user, $user_forum));
        $this->assertTrue($forum_policy->destroy($user, $user_forum));
        $this->assertTrue($forum_policy->changeOwner($user));

        factory(Post::class)->create(['forum_id' => $data['forum']->id]);
        $this->assertTrue($forum_policy->destroy($user, $data['forum']));
    }
}
