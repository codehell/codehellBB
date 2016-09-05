<?php

use Codehell\Codehellbb\Entities\Comment;
use Codehell\Codehellbb\Policies\CommentPolicies;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentPoliciesTest extends TestCase
{
    use DatabaseTransactions;

    public function test_post_comment_guest()
    {
        $this->createUserForumPost();
        $user = $this->createUser('Guest');

        $my_comment = factory(Comment::class)->create([
            'user_id' => $user->id,
        ]);

        $policies = new CommentPolicies();

        $this->assertFalse($policies->store($user));
        $this->assertFalse($policies->update($user, $my_comment));
        $this->assertFalse($policies->destroy($user, $my_comment));
    }

    public function test_post_comment_user()
    {
        $data = $this->createUserForumPost();
        
        $post = $data['post'];
        $user = $this->createUser('User');
        $another_user = $data['user'];

        $my_comment = factory(Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $another_comment = factory(Comment::class)->create([
            'user_id' => $another_user->id,
            'post_id'   => $post->id
        ]);

        $policies = new CommentPolicies();

        $this->assertTrue($policies->store($user));
        $this->assertTrue($policies->update($user, $my_comment));
        $this->assertTrue($policies->destroy($user, $my_comment));
        $this->assertFalse($policies->update($user, $another_comment));
        $this->assertFalse($policies->destroy($user, $another_comment));
        //Make reply
        factory(Comment::class)->create([
            'user_id' => $another_user->id,
            'parent' => $my_comment->id,
            'post_id'   => $post->id
        ]);
        //When has replies
        $this->assertFalse($policies->update($user, $my_comment));
        $this->assertFalse($policies->destroy($user, $my_comment));
    }
    
    public function test_post_comment_moderator()
    {
        $data = $this->createUserForumPost();
        
        $post = $data['post'];
        $user = $this->createUser('Moderator');
        $another_user = $data['user'];

        $my_comment = factory(Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $another_comment = factory(Comment::class)->create([
            'user_id' => $another_user->id,
            'post_id'   => $post->id
        ]);

        $policies = new CommentPolicies();

        $this->assertTrue($policies->store($user));
        $this->assertTrue($policies->update($user, $my_comment));
        $this->assertTrue($policies->destroy($user, $my_comment));
        $this->assertFalse($policies->update($user, $another_comment));
        $this->assertTrue($policies->destroy($user, $another_comment));
        //Make reply
        factory(Comment::class)->create([
            'user_id' => $another_user->id,
            'parent' => $my_comment->id,
            'post_id'   => $post->id
        ]);
        //When has replies
        $this->assertFalse($policies->update($user, $my_comment));
        $this->assertTrue($policies->destroy($user, $my_comment));
    }

    public function test_post_comment_admin()
    {
        $data = $this->createUserForumPost();

        $post = $data['post'];
        $user = $this->createUser('Admin');
        $another_user = $data['user'];

        $my_comment = factory(Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $another_comment = factory(Comment::class)->create([
            'user_id' => $another_user->id,
            'post_id'   => $post->id
        ]);

        $policies = new CommentPolicies();

        $this->assertTrue($policies->store($user));
        $this->assertTrue($policies->update($user, $my_comment));
        $this->assertTrue($policies->destroy($user, $my_comment));
        $this->assertTrue($policies->update($user, $another_comment));
        $this->assertTrue($policies->destroy($user, $another_comment));
        //Make reply
        factory(Comment::class)->create([
            'user_id' => $another_user->id,
            'parent' => $my_comment->id,
            'post_id'   => $post->id
        ]);
        //When has replies
        $this->assertTrue($policies->update($user, $my_comment));
        $this->assertTrue($policies->destroy($user, $my_comment));
    }
}
