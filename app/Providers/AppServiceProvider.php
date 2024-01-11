<?php

namespace App\Providers;

use App\Services\QuoteManager;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton(QuoteManager::class, fn (Application $app) => new QuoteManager($app));
    }
}
