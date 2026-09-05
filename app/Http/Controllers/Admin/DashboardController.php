<?php

// Autor: Isabella Cadavid Posada

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
