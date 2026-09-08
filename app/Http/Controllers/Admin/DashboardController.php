<?php

/**
 * Author: Isabella Cadavid Posada
 * Contributor: Alejandro
 * Date: 07/09/2026
 * Description: Administrator dashboard controller.
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
            'title' => __('admin.dashboard_title'),
            'userName' => $user instanceof User ? $user->getName() : '',
        ];

        return view('admin.dashboard.index')->with('viewData', $viewData);
    }
}
