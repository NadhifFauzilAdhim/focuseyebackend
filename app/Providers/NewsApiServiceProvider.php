<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\NewsApiService;

class NewsApiServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(NewsApiService::class, function ($app) {
            return new NewsApiService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
