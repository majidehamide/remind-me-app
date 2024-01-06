<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Services\UserService\UserService;
use App\Services\UserService\UserServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(UserServiceInterface::class, UserService::class);
    }
}
