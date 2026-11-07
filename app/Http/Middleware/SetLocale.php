<?php

/**
 * Author: Isabella Ocampo
 * Author: Isabella Cadavid Posada
 * Date: 2026-11-04
 * Description: Apply the supported session language to each request.
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = array_keys(
            config('localization.supported', [])
        );

        $defaultLocale = (string) config(
            'localization.default',
            'es'
        );

        $locale = (string) Session::get(
            'locale',
            $defaultLocale
        );

        if (! in_array($locale, $supportedLocales, true)) {
            $locale = $defaultLocale;
        }

        App::setLocale($locale);

        return $next($request);
    }
}
