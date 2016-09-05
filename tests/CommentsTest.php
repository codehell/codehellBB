<?php

use Codehell\Codehellbb\Entities\Comment;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentsTest extends TestCase
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

        $this->seeInDatabase('cbb_comments',['comment' => 'This is a comment']);

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

        $this->seeInDatabase('cbb_comments',['comment' => 'This is a updated comment']);
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
        $this->seeInDatabase('cbb_comments', [
            'id' => $comment->id
        ]);
        $this->actingAs($user)
            ->call('DELETE', route('comments.destroy', $comment));
        $this->dontSeeInDatabase('cbb_comments', [
            'id' => $comment->id
        ]);
    }
}
