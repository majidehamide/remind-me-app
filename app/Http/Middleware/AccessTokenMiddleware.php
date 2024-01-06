<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\AuthEnum;
use Illuminate\Http\Request;
use App\Helpers\JsonResponseHelper;
use Symfony\Component\HttpFoundation\Response;

class AccessTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ( ! $request->user() || ! $request->user()->tokenCan(AuthEnum::AUTH_TOKEN_ABILITY)) {
            return JsonResponseHelper::unauthorizedError();
        }
        return $next($request);
    }
}
