<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $admin = auth()->guard('admin')->user();

        if (!$admin || !$admin->hasRole(0)) {
            return redirect()->route('admin.dashboard.index')->with('error', 'Unauthorized access!');
        }

        return $next($request);
    }
}

