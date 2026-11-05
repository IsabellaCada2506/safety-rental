<?php

/**
 * Author: Isabella Ocampo
 * Author: Isabella Cadavid Posada
 * Date: 2026-11-04
 * Description: Controller for switching the active application language.
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function switch(string $lang): RedirectResponse
    {
        if (in_array($lang, array_keys(config('localization.supported', [])), true)) {
            Session::put('locale', $lang);
        }

        return redirect()->back();
    }
}
