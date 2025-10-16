<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route_name = 'admin.login-page';
        if(!Auth::check()){
           if(str_contains($request->getUri(),'/candidate/')){
                $route_name = 'candidate.login-page';
           } 
            return redirect()->route($route_name, ['redirect_uri' => $request->getUri()]);
        }
        return $next($request);
    }
}
