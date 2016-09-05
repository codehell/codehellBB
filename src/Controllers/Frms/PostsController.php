<?php

namespace Codehell\Codehellbb\Controllers\Frms;

use Codehell\Codehellbb\Entities\User;
use Illuminate\Http\Request;
use Codehell\Codehellbb\Entities\Forum;
use Codehell\Codehellbb\Entities\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class PostsController extends Controller
{
    public function create(Forum $forum)
    {
        $this->authorize('createPost', $forum);
        $posts = $forum->posts()->orderBy('created_at', 'DESC')
            ->with('user', 'forum')
            ->paginate();
        return view('codehellbb::forums.posts.create', compact('forum', 'posts'));
    }
    
    public function store(Request $request, Forum $forum)
    {
        $this->authorize('createPost', $forum);
        $this->validate($request, [
            'title' => 'required|max:127',
            'development' => 'required'
        ]);
        $post = new Post();
        $post->title = trim($request->title);
        $post->content = trim($request->development);
        $post->forum_id = $forum->id;
        $post->user_id = $request->user()->id;
        $post->disabled = false;
        $post->save();
        Log::info('The user ' . $request->user()->name . ' created post ' . $post->id . ' in forum ' . $forum->id);
        hell_update_visit_time($post);
        return redirect()
            ->route('forums.show', $forum->slug)
            ->with('success', trans('codehell::forum.alert.post_created'));
    }

    public function show($slug, Post $post)
    {
        $this->authorize('show', $post);
        $forum = Forum::where('slug', $slug)->firstOrFail();
        $comments = $post->postComments()->with('children')->get();

        hell_update_visit_time($post);

        return view('codehellbb::forums.posts.show', compact('forum', 'post', 'comments'));
    }

    public function edit($slug, Post $post)
    {
        $this->authorize('update', $post);
        $forum = Forum::where('slug', $slug)->firstOrFail();
        return view('codehellbb::forums.posts.edit', [
            'forum'  => $forum,
            'post'   => $post,
        ]);
    }
    
    public function update(Request $request, Post $post)
    {
        $this->authorize($post);
        $forum = $post->forum;
        $this->validate($request, [
            'title' => 'required|max:127',
            'development' => 'required'
        ]);
        $post->title = trim($request->title);
        $post->content = trim($request->development);
        $post->save();
        Log::notice('The user ' . $request->user()->name . ' updated post ' . $post->id . ' in forum ' . $forum->id);
        return redirect()
            ->route('posts.show', [$forum->slug, $post])
            ->with('success', trans('codehellbb::forum.alert.update_post'));
    }
    
    public function destroy(Post $post)
    {
        $this->authorize('destroy', $post);
        $post->delete();
        Log::notice('The user ' . auth()->user()->name . ' deleted post ' . "$post->id -> $post->title");
        return redirect()
            ->route('forums.show', $post->forum->slug)
            ->with('success', trans('codehellbb::forum.alert.delete_post'));
    }
}
