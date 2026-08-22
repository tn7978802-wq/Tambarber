<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SystemOwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isSystemOwner()) {
            abort(403, 'Hành động này chỉ dành cho Quản lý tối cao (System Owner).');
        }

        return $next($request);
    }
}
