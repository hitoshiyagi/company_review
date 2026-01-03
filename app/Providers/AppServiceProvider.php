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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // これを追記：Herokuのプロキシヘッダー（X-Forwarded-Proto）をチェックする
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            \URL::forceScheme('https');
        }

        // もしくはこれだけでもOK（本番環境なら強制）
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    }
}
