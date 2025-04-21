<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // If user is authenticated, use their preferred language
        if (Auth::check() && Auth::user()->language) {
            App::setLocale(Auth::user()->language);
        }
        // Otherwise check session
        else if ($request->session()->has('locale')) {
            App::setLocale($request->session()->get('locale'));
        }
        // Default to English
        else {
            App::setLocale('en');
        }

        return $next($request);
    }
}
