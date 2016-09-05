<?php

namespace Codehell\Codehellbb\Controllers\Frms;

use Codehell\Codehellbb\Entities\Post;
use Codehell\Codehellbb\Entities\User;
use Codehell\Codehellbb\Entities\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ForumsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('show-forums');
        $search = '';
        if (isset($request->search)) {
            $search = $request->search;
            $posts = Post::orderBy('created_at', 'DESC')
                ->where('title', 'LIKE', "%$search%")
                ->orWhere('content', 'LIKE', "%$search%")
                ->with('user', 'forum')
                ->paginate();
        } else {
            $posts = Post::orderBy('created_at', 'DESC')
                ->with('user', 'forum')
                ->paginate();
        }
        return view('codehellbb::forums/index', compact('posts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-forum');
        return view('codehellbb::forums.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-forum');

        $this->validate($request, [
            'name' => 'required|max:64',
            'description' => 'required'
        ]);
        $forum = new Forum();
        $user = $request->user();
        $forum->name = trim($request->name);
        $forum->description = trim($request->description);
        $forum->slug = str_slug(trim($request->name));
        $forum->user_id = $user->id;
        $forum->save();
        Log::info('The user ' . $user->name . ' created the new forum ' . "$forum->id -> $forum->name");
        return redirect()->route('forums.show', $forum->slug)->with('success', trans('forum.alert.forum_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->authorize('show-forums');
        $forum = Forum::where('slug', $slug)->firstOrFail();
        $posts = $forum->posts()->orderBy('created_at', 'DESC')
            ->with('user', 'forum')
            ->paginate();
        return view('codehellbb::forums/index', compact('forum', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Forum $forum
     * @return \Illuminate\Http\Response
     */
    public function edit(Forum $forum)
    {
        $this->authorize('update', $forum);
        $users = new User;
        $allowed_users = $users->adminsAndModerators();
        return view('codehellbb::forums/edit', [
            'forum' => $forum,
            'users' => $allowed_users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Forum $forum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forum $forum)
    {
        $this->authorize('update', $forum);
        $user = $request->user();
        $this->validate($request, [
            'name' => 'required|max:64',
            'description' => 'required',
        ]);
        $forum->name = trim($request->name);
        $forum->description = trim($request->description);

        if (Gate::allows('changeOwner', $forum)){
            $this->validate($request, [
                'owner'=> 'required|exists:cbb_users,id'
            ]);
            $forum->user_id = $request->owner;
        }
        $forum->save();
        Log::notice('The user ' . $user->name . ' updated forum ' . "$forum->id -> $forum->name");
        return redirect()->route('forums.show', $forum->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Forum $forum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forum $forum)
    {
        $this->authorize('destroy', $forum);;
        $forum->delete();
        Log::notice('The user ' . auth()->user()->name . ' deleted forum ' . "$forum->id -> $forum->name");
        return redirect()->route('forums.index')->with('success', trans('forum.operation.deleted'));
    }
}
