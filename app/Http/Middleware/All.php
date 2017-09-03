<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class All
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
        if (Session::has('login')) {
            $role = Session::get('login')->data->role;

            if ($role == 'administrator' || $role == 'moderator' || $role == 'educator') {
                return $next($request);
            }
        }
        return redirect()->route('home');
    }
}
