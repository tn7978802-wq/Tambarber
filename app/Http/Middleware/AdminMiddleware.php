<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isSystemOwner()) {
            return $next($request);
        }

        if (! $user || ! $user->isAdmin()) {
            abort(403, 'Khu vực này chỉ dành cho nhân sự được cấp quyền.');
        }

        return $next($request);
    }
}
