<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\Auth\JwtTokenService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateJwt
{
    public function __construct(private readonly JwtTokenService $tokens)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $bearer = $request->bearerToken();

        if (! $bearer) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $payload = $this->tokens->decodeAccessToken($bearer);
        $user = $payload ? User::find($payload['sub'] ?? null) : null;

        if (! $user || $user->status !== 'active') {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
