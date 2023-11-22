<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoles
{
    public function handle(Request $request, Closure $next, ...$role)
    {
        $auth = Auth::user();
        if(! $auth){
            return redirect()->route("logout");
        }

        if(! in_array($auth->role, $role)){
            return redirect()->route("home");
        }
        return $next($request);
    }
}