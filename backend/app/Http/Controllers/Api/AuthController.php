<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoginAttempt;
use App\Models\RefreshToken;
use App\Models\User;
use App\Services\Audit\AuditLogger;
use App\Services\Auth\JwtTokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        private readonly JwtTokenService $tokens,
        private readonly AuditLogger $audit,
    ) {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::query()
            ->where('username', $request->string('username'))
            ->orWhere('email', $request->string('username'))
            ->first();

        $valid = $user && Hash::check($request->string('password'), $user->password);

        LoginAttempt::create([
            'username' => $request->string('username'),
            'user_id' => $user?->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'successful' => $valid,
            'failure_reason' => $valid ? null : 'invalid_credentials',
            'attempted_at' => now(),
        ]);

        if (! $valid || $user->status !== 'active') {
            return response()->json(['message' => 'Invalid credentials.'], 422);
        }

        if ($user->two_factor_enabled && ! $request->filled('otp_code')) {
            return response()->json([
                'requires_otp' => true,
                'message' => 'OTP required.',
                'captcha_ready' => true,
            ], 202);
        }

        $user->update(['last_login_at' => now()]);
        $this->audit->record('login', $user, ['module' => 'auth'], $request);

        return response()->json([
            'user' => $user->load('roles.permissions'),
            'tokens' => $this->tokens->issue($user, $request->ip(), $request->userAgent()),
        ]);
    }

    public function refresh(Request $request): JsonResponse
    {
        $request->validate(['refresh_token' => ['required', 'string']]);

        $tokens = $this->tokens->refresh(
            $request->string('refresh_token'),
            $request->ip(),
            $request->userAgent()
        );

        if (! $tokens) {
            return response()->json(['message' => 'Invalid refresh token.'], 401);
        }

        return response()->json(['tokens' => $tokens]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user()->load('roles.permissions'),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        RefreshToken::query()
            ->where('user_id', $request->user()->id)
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);

        $this->audit->record('logout', $request->user(), ['module' => 'auth'], $request);

        return response()->json(['message' => 'Logged out.']);
    }
}
