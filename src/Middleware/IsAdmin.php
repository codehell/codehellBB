<?php

namespace Codehell\Codehellbb\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{

    private $auth;

    public function __construct(Guard $guard)
    {
        $this->auth = $guard;
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
        if (Auth::guest() || $request->user()->skill != 'Admin')  {
            abort(403, 'You are not Administrator');
        }
        return $next($request);
    }
}
