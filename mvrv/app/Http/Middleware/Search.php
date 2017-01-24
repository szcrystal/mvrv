<?php

namespace App\Http\Middleware;

use Closure;

class Search
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
    	if($request->has('s')) {
        	return redirect('search/?s='. $request->s);
        }
        return $next($request);
    }
}
