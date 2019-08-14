<?php

namespace App\Http\Middleware;

use Closure;

class SiteOpenIf
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
        if(!config('base.site_open')){
            return response()->view('home.siteClose');
        }
        return $next($request);
    }
}
