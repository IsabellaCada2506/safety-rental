<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-06
 * Description: Middleware that restricts access to admin-only routes.
 */

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user instanceof User || ! $user->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
