<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureManeger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $team=$request->route()->parameter('team');
        if (!$request->user()->isManeger($team)) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'アクセスできません'], 403);
            } else {
                return redirect('/')->with('danger', 'アクセスできません');
            }
        }
        return $next($request);
    }
}
