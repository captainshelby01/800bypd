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

        if (!in_array(Auth::user()->role, ['admin', 'staff'])) {
            return redirect()->route('account.dashboard')->with('error', 'Access Denied: You do not have administrator or staff privileges.');
        }

        return $next($request);
    }
}
