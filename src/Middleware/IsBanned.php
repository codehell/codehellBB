<?php

namespace Codehell\Codehellbb\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class IsBanned
{

    protected $auth;

    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->auth->check() && $request->user()->profile->banned) {
            return redirect()->route('profiles.ban_message', $request->user()->id);
        }
        return $next($request);
    }
}
