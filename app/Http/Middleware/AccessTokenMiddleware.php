<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\JsonResponseHelper;
use Symfony\Component\HttpFoundation\Response;
use App\Services\AuthService\AuthServiceInterface;
use Illuminate\Routing\Controllers\Middleware;

class AccessTokenMiddleware extends Middleware
{
    protected $authService;
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;   
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!is_null($request->user()) && $this->authService->isAuthHasAccessToken($request->user())) {
            return $next($request);
        }
        
        return JsonResponseHelper::unauthorizedError();
    }
}
