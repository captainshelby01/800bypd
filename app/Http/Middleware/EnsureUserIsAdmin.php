<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in with an administrator account to access the admin panel.');
        }

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('account.dashboard')->with('error', 'Access Denied: You do not have administrator privileges.');
        }

        return $next($request);
    }
}
