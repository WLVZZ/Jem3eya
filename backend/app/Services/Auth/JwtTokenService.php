<?php

namespace App\Services\Auth;

use App\Models\RefreshToken;
use App\Models\User;
use Carbon\CarbonImmutable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class JwtTokenService
{
    public function issue(User $user, ?string $ip = null, ?string $userAgent = null): array
    {
        $refreshToken = Str::random(80);
        $refreshExpiresAt = now()->addDays(config('jwt.refresh_ttl_days'));

        RefreshToken::create([
            'user_id' => $user->id,
            'token_hash' => Hash::make($refreshToken),
            'expires_at' => $refreshExpiresAt,
            'ip_address' => $ip,
            'user_agent' => $userAgent,
        ]);

        return [
            'token_type' => 'Bearer',
            'access_token' => $this->accessToken($user),
            'expires_in' => config('jwt.access_ttl_minutes') * 60,
            'refresh_token' => $refreshToken,
            'refresh_expires_at' => $refreshExpiresAt->toISOString(),
        ];
    }

    public function refresh(string $refreshToken, ?string $ip = null, ?string $userAgent = null): ?array
    {
        $tokens = RefreshToken::query()
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->latest('id')
            ->get();

        $record = $tokens->first(fn (RefreshToken $token) => Hash::check($refreshToken, $token->token_hash));

        if (! $record || ! $record->user) {
            return null;
        }

        $record->update(['revoked_at' => now()]);

        return $this->issue($record->user, $ip, $userAgent);
    }

    public function decodeAccessToken(string $token): ?array
    {
        try {
            $payload = JWT::decode($token, new Key((string) config('jwt.secret'), 'HS256'));

            return (array) $payload;
        } catch (Throwable) {
            return null;
        }
    }

    private function accessToken(User $user): string
    {
        $now = CarbonImmutable::now();

        return JWT::encode([
            'iss' => config('jwt.issuer'),
            'iat' => $now->timestamp,
            'nbf' => $now->timestamp,
            'exp' => $now->addMinutes(config('jwt.access_ttl_minutes'))->timestamp,
            'sub' => $user->id,
            'username' => $user->username,
            'roles' => $user->roles()->pluck('slug')->values()->all(),
        ], (string) config('jwt.secret'), 'HS256');
    }
}
