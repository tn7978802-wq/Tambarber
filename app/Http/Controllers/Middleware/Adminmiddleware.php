<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Chỉ cho phép người dùng có quyền quản trị (is_admin = true) truy cập /admin/*.
     * Tuỳ dự án thực tế, có thể đổi field 'is_admin' cho khớp với bảng users của bạn.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! ($user->is_admin ?? false)) {
            abort(403, 'Khu vực này chỉ dành cho quản trị viên.');
        }

        return $next($request);
    }
}