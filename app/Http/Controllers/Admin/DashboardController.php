<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-06
 * Description: Controller for the admin dashboard view.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $viewData = [
            'title' => __('authentication.admin_dashboard'),
            'userName' => $user instanceof User ? $user->getName() : '',
        ];

        return view('admin.dashboard.index')->with('viewData', $viewData);
    }
}
