<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenExpiryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$request->bearerToken()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Add your token expiry logic here (e.g., based on created_at or last_used_at)
        // For example, deny access if token is older than 24 hours
        $token = $user->currentAccessToken();

        if ($token && $token->created_at->lt(now()->subDay())) {
            $token->delete(); // optional: auto-expire it
            return response()->json(['message' => 'Token expired'], 401);
        }

        return $next($request);
    }
}
