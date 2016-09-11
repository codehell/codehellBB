<?php

use Codehell\Codehellbb\Entities\Comment;
use Codehell\Codehellbb\tests\Helpers;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentsTest extends Helpers
{
    use DatabaseTransactions;

    public function test_create_comment()
    {
        $data = $this->createUserForumPost();
        $user = $data['user'];
        $forum = $data['forum'];
        $post = $data['post'];

        $this->actingAs($user)
            ->visit(route('posts.show', [$forum->slug, $post->id]))
            ->click('reply_post')
            ->see('Write a comment');

        $this->call('POST', route('comments.store', $post), [
            'comment' => 'This is a comment',
        ]);

        $this->seeInDatabase('comments',['comment' => 'This is a comment']);

        $this->assertRedirectedToRoute('posts.show', [$forum->slug, $post->id]);
    }

    public function test_edit_comment()
    {
        $data = $this->createUserForumPost();
        $user = $data['user'];
        $post = $data['post'];
        $comment = factory(Comment::class)->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
        $this->actingAs($user)->call('PATCH', route('comments.update', $comment), [
            'comment' => 'This is a updated comment',
        ]);

        $this->seeInDatabase('comments',['comment' => 'This is a updated comment']);
    }

    public function test_delete_comment()
    {
        $data = $this->createUserForumPost();
        $user = $data['user'];
        $forum = $data['forum'];
        $post = $data['post'];
        $comment = factory(Comment::class)->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
        $this->seeInDatabase('comments', [
            'id' => $comment->id
        ]);
        $this->actingAs($user)
            ->call('DELETE', route('comments.destroy', $comment));
        $this->dontSeeInDatabase('comments', [
            'id' => $comment->id
        ]);
    }
}
