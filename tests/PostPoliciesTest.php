<?php


use Codehell\Codehellbb\Entities\Comment;
use Codehell\Codehellbb\Entities\Post;
use Codehell\Codehellbb\Policies\PostPolicies;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostPoliciesTest extends TestCase
{
    use DatabaseTransactions;

    public function test_post_policies_guest()
    {
        $data = $this->createUserForumPost();
        $user = $this->createUser('Guest');
        $policies = new PostPolicies();
        $this->assertFalse($policies->show($user));
        $this->assertFalse($policies->update($user, $data['post']));
        $this->assertFalse($policies->destroy($user, $data['post']));
    }

    public function test_post_policies_user()
    {
        $data = $this->createUserForumPost();
        $forum = $data['forum'];
        $another_post = $data['post'];
        $user = $this->createUser('User');
        $post = factory(Post::class)->create([
                    'user_id' => $user->id,
                    'forum_id' => $forum->id
                ]);
        $policies = new PostPolicies();

        $this->assertTrue($policies->show($user));
        $this->assertTrue($policies->update($user, $post));
        $this->assertFalse($policies->update($user, $another_post));
        $this->assertTrue($policies->destroy($user, $post));
        $this->assertFalse($policies->destroy($user, $another_post));
        factory(Comment::class)->create(['post_id' => $post->id]);
        $this->assertFalse($policies->update($user, $post));
        $this->assertFalse($policies->destroy($user, $post));
    }
    
    public function test_post_policies_moderator()
    {
        $data = $this->createUserForumPost();
        $forum = $data['forum'];
        $another_post = $data['post'];
        $user = $this->createUser('Moderator');
        $post = factory(Post::class)->create([
                    'user_id' => $user->id,
                    'forum_id' => $forum->id
                ]);
        $policies = new PostPolicies();

        $this->assertTrue($policies->show($user));
        $this->assertTrue($policies->update($user, $post));
        $this->assertFalse($policies->update($user, $another_post));
        $this->assertTrue($policies->destroy($user, $post));
        $this->assertFalse($policies->destroy($user, $another_post));
        factory(Comment::class)->create(['post_id' => $post->id]);
        $this->assertTrue($policies->update($user, $post));
        $this->assertTrue($policies->destroy($user, $post));
    }

    public function test_post_policies_admin()
    {
        $data = $this->createUserForumPost();
        $forum = $data['forum'];
        $another_post = $data['post'];
        $user = $this->createUser('Admin');
        $post = factory(Post::class)->create([
                    'user_id' => $user->id,
                    'forum_id' => $forum->id
                ]);
        $policies = new PostPolicies();

        $this->assertTrue($policies->show($user));
        $this->assertTrue($policies->update($user, $post));
        $this->assertTrue($policies->update($user, $another_post));
        $this->assertTrue($policies->destroy($user, $post));
        $this->assertTrue($policies->destroy($user, $another_post));
        factory(Comment::class)->create(['post_id' => $post->id]);
        $this->assertTrue($policies->update($user, $post));
        $this->assertTrue($policies->destroy($user, $post));
    }
}
