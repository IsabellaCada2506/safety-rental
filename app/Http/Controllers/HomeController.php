<?php

// Autor: Isabella Cadavid Posada

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $viewData = [
            'title' => __('authentication.customer_dashboard'),
            'userName' => $user instanceof User ? $user->getName() : '',
        ];

        return view('home.index')->with('viewData', $viewData);
    }
}
