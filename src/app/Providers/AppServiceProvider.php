<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ルートURLを設定
        URL::forceRootUrl(\config('app.url'));

        // localを指定した環境以外ではHTTPSを強制する
        if (!$this->app->environment('local')) {
            \URL::forceScheme('https');
        }

        // Cashierによって自動的に登録されるデフォルトルートを無効
        Cashier::ignoreRoutes();
        // Cashierによって自動的に登録されるデフォルトのマイグレーションを無効
        Cashier::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
