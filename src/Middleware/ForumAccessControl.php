<?php

namespace Codehell\Codehellbb\Middleware;
use Closure;
use Codehell\Codehellbb\Entities\Forum;

class ForumAccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $forum_access = config('codehellbb.forum_access');
        $path = $request->decodedPath();

        foreach ($forum_access as $k => $fa)
        {
            if (($forum = Forum::find($k)) != null) {
                if (str_contains($path, $forum->slug) && ! hell_has_skill_or_more(auth()->user(), $fa)) {
                    return redirect()
                        ->route('forums.index')
                        ->with('warning', 'You do not have skill to access this forum');
                }
            }
        }
        return $next($request);
    }
}
