<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-06
 * Description: Controller for the customer home dashboard view.
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $viewData = [
            'title' => __('authentication.user_dashboard'),
            'userName' => $user instanceof User ? $user->getName() : '',
        ];

        return view('user.home.index')->with('viewData', $viewData);
    }
}
