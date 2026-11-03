<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-06
 * Description: Controller for the public welcome landing page.
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        $viewData = [
            'title' => __('authentication.application_name'),
        ];

        return view('user.welcome.index')->with(
            'viewData',
            $viewData
        );
    }
}
