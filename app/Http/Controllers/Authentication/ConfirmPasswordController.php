<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-06
 * Description: Controller for confirming the authenticated user's password before sensitive actions.
 */

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    use ConfirmsPasswords;

    protected string $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('auth');
    }
}
