<?php

namespace App\Providers;

use App\Services\OpenAIService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(OpenAIService::class, function ($app) {
            return new OpenAIService(
                config('openai.project_id'),
                config('openai.location'),
                config('openai.model_name')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
