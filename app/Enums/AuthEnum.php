<?php

namespace App\Enums;

class AuthEnum
{
    const AUTH_TOKEN_NAME = 'auth_token';
    const AUTH_TOKEN_ABILITY = 'token-access';
    const REFRESH_TOKEN_NAME = 'refresh_token';
    const REFRESH_TOKEN_ABILITY = 'token-refresh';
    const TOKEN_MINUTES_EXPIRED = 10;
}
