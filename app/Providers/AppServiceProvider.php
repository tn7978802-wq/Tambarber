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
        // dùng HTTPS cho tất cả môi trường KHÔNG PHẢI local
        if (config('app.env') !== 'local' || request()->server->get('HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme('https');
        }
        app()->setLocale(config('app.locale', 'vi'));

        if (config('app.env') === 'local' && class_exists(\Laravel\Socialite\Facades\Socialite::class)) {
            \Laravel\Socialite\Facades\Socialite::extend('google', function ($app) {
                $config = $app['config']['services.google'];

                $provider = $app->make(\Laravel\Socialite\SocialiteManager::class)->buildProvider(
                    \Laravel\Socialite\Two\GoogleProvider::class,
                    $config
                );

                return $provider->stateless()->setHttpClient(new \GuzzleHttp\Client([
                    'verify' => false,
                    'timeout' => 60,
                ]));
            });
        }
    }
}
