<?php

namespace App\Http\Middleware;

use Closure;

class LoginSession
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
        $successLogin = session()->has('success_login');
        $dosen = session()->has('dosen');

        if($successLogin && $dosen)
        {
            return $next($request);
        }
        return redirect('/');

        
    }
}
