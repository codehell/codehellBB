<?php

namespace Codehell\codehellbb\Controllers\Frms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Codehell\Codehellbb\Entities\Post;
use Codehell\Codehellbb\Entities\Comment;

class CommentsController extends Controller
{
    public function store(Request $request, Post $post, Comment $comment)
    {
        $this->authorize('store', $comment);
        $this->validate($request, [
           'comment' => 'required|min:5'
        ]);
        $comm_obj = new Comment();
        $forum = $post->forum;

        if ($comment->exists) {
            $comm_obj->parent = $comment->id;
        }
        $comm_obj->post_id = $post->id;

        $comm_obj->user_id = $request->user()->id;
        $comm_obj->comment = trim($request->comment);
        $comm_obj->save();

        Log::info('The user '
            . $request->user()->name
            . ' created the comment '
            . $comm_obj->id
            . ' in post '
            . $post->id);

        return redirect()->route('posts.show', [$forum->slug, $post])
            ->with('success', trans('codehellbb::forum.alert.comment_created'));
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $this->validate($request, [
            'comment' => 'required|min:5'
        ]);
        $post = $comment->post;
        $forum = $post->forum;
        $comment->comment = trim($request->comment);
        $comment->save();
        Log::notice('The user '
            . $request->user()->name
            . ' updated the comment '
            . $comment->id
            . ' in post '
            . $post->id);
        return redirect()->route('posts.show', [$forum->slug, $post])
            ->with('success', trans('codehellbb::forum.alert.comment_updated'));
    }

    public function destroy(Request $request, Comment $comment)
    {
        $this->authorize('destroy', $comment);
        $post = $comment->post;
        $forum = $post->forum;
        $comment->delete();
        Log::notice('The user '
            . $request->user()->name
            . ' deleted the comment '
            . $comment->id
            . ' in post '
            . $post->id);
        return redirect()->route('posts.show', [$forum->slug, $post])
            ->with('success', trans('codehellbb::forum.alert.comment_deleted'));
    }
}
