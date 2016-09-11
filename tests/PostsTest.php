<?php

use Codehell\Codehellbb\tests\Helpers;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsTest extends Helpers
{
    use DatabaseTransactions;

    public function test_create_post()
    {
        $data = $this->createUserForumPost();
        $user = $data['user'];
        $forum = $data['forum'];

        $this->actingAs($user)
            ->visit(route('posts.create', $forum->id))
            ->see('Create new post')
            ->type('El post de los posts', 'title')
            ->type('Contenido del post de los posts', 'development')
            ->press('Save');

        $this->seeInDatabase('posts', [
            'title' => 'El post de los posts',
            'content' => 'Contenido del post de los posts'
        ]);

        $this->seePageIs(route('forums.show', $forum->slug))
            ->see(trans('forum.alert.post_created'));
    }

    public function test_edit_post()
    {
        $data = $this->createUserForumPost();
        $user = $data['user'];
        $forum = $data['forum'];
        $post = $data['post'];

        /*
         * Test cancel editing
         */
        $this->actingAs($user)
            ->visit(route('forums.show', $forum->slug))
            ->click('show_post_' . $post->id)
            ->seePageIs(route('posts.show', [$forum->slug, $post]))
            ->click('edit_post_' . $post->id)
            ->click(trans('codehellbb::forum.button.cancel'));

        /*
         * Test edit post
         */
        $this->click('edit_post_' . $post->id)
            ->seePageIs(route('posts.edit', [$forum->slug, $post]))
            ->see(trans('codehellbb::forum.title.edit_post'))
            ->type('This is the new title od the post', 'title')
            ->type('This is the new content of the post', 'development')
            ->press(trans('codehellbb::forum.button.save'))
            ->seePageIs(route('posts.show', [$forum->slug, $post]))
            ->see(trans('codehellbb::forum.alert.update_post'));

        $this->seeInDatabase('posts', [
           'title' => 'This is the new title od the post',
            'content' => 'This is the new content of the post'
        ]);
    }

    public function test_delete_post()
    {
        $data = $this->createUserForumPost();
        $user = $data['user'];
        $forum = $data['forum'];
        $post = $data['post'];

        $this->seeInDatabase('posts', [
            'title' => $post->title,
            'content' => $post->content,
        ]);
        $this->actingAs($user)
            ->visit(route('forums.show', $forum->slug))
            ->click('show_post_' . $post->id)
            ->seePageIs(route('posts.show', [$forum->slug, $post]))
            ->click('pre_delete_post')
            ->press(trans('codehellbb::forum.button.yes'));
        $this->seePageIs(route('forums.show', $forum->slug))
            ->see(trans('codehellbb::forum.alert.delete_post'));
        $this->dontSeeInDatabase('posts', [
            'title' => $post->title,
            'content' => $post->content,
        ]);
    }
}
