<?php

namespace App\Providers;

use App\Contracts\GoogleCalendarServiceInterface;
use App\Contracts\TaskServiceInterface;
use App\Services\GoogleCalendarService;
use App\Services\TaskService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\AuthServiceInterface;
use App\Services\AuthService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class
        );
        $this->app->bind(
            TaskServiceInterface::class,
            TaskService::class)
        ;
        $this->app->bind(
            GoogleCalendarServiceInterface::class,
            GoogleCalendarService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
