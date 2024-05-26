<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthenticateAdmin
{
    public function handle($request, Closure $next)
    {
       if(session()->has('admin')) {
         return $next($request);
       }
       return Redirect::route('login_admin');
    }
}
