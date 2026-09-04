<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        app()->setLocale(config('app.locale', 'vi'));

        // Chỉ áp dụng nếu có cài đặt package laravel/socialite (composer require laravel/socialite)
        // và đang chạy ở môi trường local — giúp tránh lỗi SSL/host khi test Google Login trên máy cá nhân.
        if (config('app.env') === 'local' && class_exists(\Laravel\Socialite\Facades\Socialite::class)) {
            \Laravel\Socialite\Facades\Socialite::extend('google', function ($app) {
                $config = $app['config']['services.google'];

                $provider = $app->make(\Laravel\Socialite\SocialiteManager::class)->buildProvider(
                    \Laravel\Socialite\Two\GoogleProvider::class,
                    $config
                );

                return $provider->stateless()->setHttpClient(new \GuzzleHttp\Client([
                    'verify' => false,
                    'timeout' => 30,
                ]));
            });
        }
    }
}
