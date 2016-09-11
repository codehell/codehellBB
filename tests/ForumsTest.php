<?php

use Codehell\Codehellbb\Entities\Forum;
use Codehell\Codehellbb\Entities\Post;
use Codehell\Codehellbb\tests\Helpers;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ForumsTest extends Helpers
{
    use DatabaseTransactions;

    public function test_create_forum()
    {
        $user = $this->createUser('Admin');

        $this->actingAs($user)
            ->visit($this->baseUrl . '/forums')
            ->click('Create')
            ->seePageIs(route('forums.create'))
            ->type('Primera División', 'name')
            ->type('El foro de la Primera división', 'description')
            ->press('Save')
            ->see('Primera División');

        $this->seeInDatabase('forums',[
            'name' => 'Primera División',
            'description' => 'El foro de la Primera división',
            'user_id' => $user->id,
        ]);
    }

    public function test_edit_forum()
    {
        $user = $this->createUser('Admin');
        $moderator = $this->createUser('Moderator');
        $forum = factory(Forum::class)->create([
            'user_id' => $user->id
        ]);
        $this->actingAs($user)
            ->visit($this->baseUrl . '/forums')
            ->click('List')
            ->seePageIs(route('forums.index'))
            ->click($forum->slug)
            ->seePageIs(route('forums.show', $forum->slug))
            ->click('Edit')
            ->seeInField('name', $forum->name)
            ->select($moderator->id, 'owner')
            ->type('Another forum name', 'name')
            ->type('A description for the forum', 'description')
            ->press('Update')
            ->seePageIs(route('forums.show', $forum->slug));

        $this->seeInDatabase('forums',[
            'name'      => 'Another forum name',
            'description'=> 'A description for the forum',
            'user_id'   => $moderator->id
        ]);
    }

    public function test_delete_forum()
    {
        $user = $this->createUser('Admin');
        $forum = factory(Forum::class)->create([
            'user_id' => $user->id
        ]);
        $this->seeInDatabase('forums',[
            'name'      => $forum->name,
            'description'=> $forum->description,
            'user_id'   => $user->id
        ]);
        $this->actingAs($user)
            ->visit($this->baseUrl . '/forums')
            ->click('List')
            ->seePageIs(route('forums.index'))
            ->click($forum->slug)
            ->seePageIs(route('forums.show', $forum->slug))
            ->seePageIs(route('forums.show', $forum->slug))
            ->click('Edit')
            ->press('delete_confirm');

        $this->dontSeeInDatabase('forums',[
            'id'      => $forum->id,
        ]);
    }

    public function test_find_in_post()
    {
        $data = $this->createUserForumPost();
        $post = $data['post'];
        $another_post = factory(Post::class)->create([
            'content' => 'This is a post content for a test purposes'
        ]);
        $user = $data['user'];
        $words = explode(' ', $post->content);
        $this->actingAs($user)
            ->visit(route('forums.index'))
            ->type($words[0], 'search')
            ->press('button_search')
            ->seeInElement('a', $post->title)
            ->type('purposes', 'search')
            ->press('button_search')
            ->dontSeeInElement('a', $post->title)
            ->seeInElement('a', $another_post->title);
    }
}
