<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('front.loginForm')->with('error', 'You must be logged in to take the test.');
        }

        $user = Auth::user();

        // Check if user has an active subscription
        $hasActiveSubscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active') 
            ->where('expires_at', '>=', now())
            ->exists();

        if (!$hasActiveSubscription) {
            return redirect()->route('front.package')->with('error', 'You need an active subscription to start the test.');
        }

        return $next($request);
    }
}
