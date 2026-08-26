<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Chỉ cho phép nhân viên có quyền quản trị (admin_role = ADMIN) hoặc
     * System Owner (luôn có toàn quyền, không gì ngăn cản được) truy cập /admin/*.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Đặc quyền tối thượng cho System Owner.
        if ($user && $user->isSystemOwner()) {
            return $next($request);
        }

        if (! $user || ! $user->isAdmin()) {
            abort(403, 'Khu vực này chỉ dành cho nhân sự được cấp quyền.');
        }

        return $next($request);
    }
}
