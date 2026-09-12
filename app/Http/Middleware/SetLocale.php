<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Middleware to configure application locale based on user session.
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            App::setLocale((string) Session::get('locale'));
        }

        return $next($request);
    }
}
