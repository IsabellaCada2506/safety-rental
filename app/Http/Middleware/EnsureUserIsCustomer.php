<?php

/**
 * Author: Isabella Cadavid Posada
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Middleware that restricts access to customer-only routes.
 */

namespace App\Http\Middleware;

use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsCustomer
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user instanceof User || $this->userService->isAdmin($user)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
