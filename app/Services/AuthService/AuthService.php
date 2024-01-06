<?php

namespace App\Services\AuthService;

use App\Enums\AuthEnum;
use App\Models\User;

class AuthService implements AuthServiceInterface
{
    public function createAccessToken(User $user) : string {
        return $user->createToken(
            AuthEnum::AUTH_TOKEN_NAME,[AuthEnum::AUTH_TOKEN_ABILITY], 
            now()->addMinutes(AuthEnum::TOKEN_MINUTES_EXPIRED)
        )->plainTextToken;
    }

    public function createRefreshToken(User $user) : string {
        return $user->createToken(
            AuthEnum::REFRESH_TOKEN_NAME,[AuthEnum::REFRESH_TOKEN_ABILITY], 
            now()->addWeek()
        )->plainTextToken;
    }
}
