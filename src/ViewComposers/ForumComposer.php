<?php

namespace Codehell\Codehellbb\ViewComposers;

use Codehell\Codehellbb\Entities\Forum;
use Illuminate\View\View;

class ForumComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = auth()->user();
        $new_posts = $user->unvisitedPosts()->pluck('forum_id', 'id');
        $comments_counter = $user->unreadCommentsCounter();
        $forums = Forum::orderBy('name')->get();
        $view->with('forums', $forums)
            ->with('counter', $comments_counter)
            ->with('new_posts', $new_posts);
    }
}
