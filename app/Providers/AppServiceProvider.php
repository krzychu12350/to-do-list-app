<?php

namespace App\Providers;

use App\Contracts\GoogleCalendarServiceInterface;
use App\Contracts\TaskHistoryServiceInterface;
use App\Contracts\TaskServiceInterface;
use App\Contracts\TaskTokenServiceInterface;
use App\Models\Task;
use App\Models\TaskToken;
use App\Policies\TaskPolicy;
use App\Policies\TaskTokenPolicy;
use App\Services\GoogleCalendarService;
use App\Services\TaskHistoryService;
use App\Services\TaskService;
use App\Services\TaskTokenService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\AuthServiceInterface;
use App\Services\AuthService;
use Illuminate\Support\Facades\Gate;

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
            TaskService::class
        );
        $this->app->bind(
            TaskTokenServiceInterface::class,
            TaskTokenService::class
        );

        $this->app->bind(
            TaskHistoryServiceInterface::class,
            TaskHistoryService::class
        );

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
        Gate::policy(
            Task::class,
            TaskPolicy::class);
        Gate::policy(
            TaskToken::class,
            TaskTokenPolicy::class
        );
    }
}
