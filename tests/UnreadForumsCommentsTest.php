<?php

use Codehell\Codehellbb\Entities\Comment;
use Codehell\Codehellbb\Entities\Forum;
use Codehell\Codehellbb\Entities\Post;
use Codehell\Testsbb\Helpers;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UnreadForumsCommentsTest extends Helpers
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_unvisited_forum()
    {
        $user = $this->createUser('Admin');
        $another_user = $this->createUser('Moderator');
        $forum = factory(Forum::class)->create();
        $post = factory(Post::class)->create([
            'forum_id' => $forum->id,
            'user_id' => $another_user->id,
        ]);
        factory(Comment::class)->create([
            'user_id' => $another_user->id,
            'post_id'=> $post->id,
            'user_id' => $another_user->id,
        ]);
        /*
         * Counter has one when the post has a comment
         */
        $this->actingAs($user)
            ->visit(route('forums.index'))
            ->see($forum->name)
            ->see($post->title)
            ->seeElement('span.glyphicon')
            ->seeElement('a.active')
            ->seeInElement('span.badge', '1');
        /*
         * Counter has zero when visited the post
         */
        $this->actingAs($user)
            ->visit(route('posts.show', [$forum->slug, $post]))
            ->visit(route('forums.index'))
            ->see($forum->name)
            ->see($post->title)
            ->dontSeeElement('span.glyphicon')
            ->dontSeeElement('a.active')
            ->seeInElement('span.badge', '0');

        /*
         * Forum has class active when a new post was created
         */
        factory(Post::class)->create();
        $this->actingAs($user)
            ->visit(route('forums.index'))
            ->seeElement('span.glyphicon')
            ->seeElement('a.active');
    }
}
