<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 開発環境以外（Herokuなど）では、全てのURL生成を強制的にHTTPSにする
        if (app()->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
