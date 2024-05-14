<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Traits\ApiHelpers;

class RestrictRegistrationToOneAdmin
{
    
    use ApiHelpers; // Using the apiHelpers Trait
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // check if a Admin authenticated
        if( auth('sanctum')->check() && $this->isAdmin($request->user()) ){ 
            return $next($request);
        } else {
            return $this->onError(401, 'Unauthorized Access');
        }
        return $next($request);
    }
}