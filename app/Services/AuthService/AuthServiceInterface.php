<?php

namespace App\Services\AuthService;

use App\Models\User;

interface AuthServiceInterface
{
    public function createAccessToken(User $user) : string ;
    public function createRefreshToken(User $user) : string ;

}
