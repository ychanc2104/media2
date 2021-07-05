<?php

namespace App\Http\Middleware;

use Closure;

class LoginRequiredMiddleware
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
        // default is not allow to access
        $is_allow_access = False;

        $web_id = session()->get('web_id');
        // $web_id not null
        if (!is_null($web_id))
        {
            $is_allow_access = True;
        }
        // if not allow
        if (!$is_allow_access)
        {
            return redirect()->to('/login');
        }
        return $next($request);
    }
}
