<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Controller for switching the active application language.
 */

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function switch(string $lang): RedirectResponse
    {
        if (in_array($lang, ['en', 'es'], true)) {
            Session::put('locale', $lang);
        }

        return redirect()->back();
    }
}
