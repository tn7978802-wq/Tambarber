<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Tin cậy proxy từ Cloudflare Tunnel để giữ đúng tên miền và HTTPS
        $middleware->trustProxies(at: '*');

        // 'admin' middleware bảo vệ khu vực quản trị (/admin/*).
        // Có thể thay bằng middleware kiểm tra role thực tế của bạn.
        $middleware->alias([
            'active' => \App\Http\Middleware\ActiveUserMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'system_owner' => \App\Http\Middleware\SystemOwnerMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();