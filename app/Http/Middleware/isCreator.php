<?php

namespace App\Http\Middleware;

use App\Utilities\RoleLevelChecker;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class isCreator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (RoleLevelChecker::checkMinimumByRoleName(Auth::user(), 'article_creator')) {
            return $next($request);
        }
        throw new NotFoundHttpException();
    }
}
