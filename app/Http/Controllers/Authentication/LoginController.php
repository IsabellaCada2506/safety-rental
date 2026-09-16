<?php

/**
 * Author: Isabella Cadavid Posada
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Controller handling user login, authentication, and logout.
 */

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('authentication.login');

        return view('authentication.login.index')->with('viewData', $viewData);
    }

    public function authenticate(
        LoginRequest $request
    ): RedirectResponse {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();

        if ($user instanceof User && $user->isAdmin()) {
            return redirect()->route('admin.dashboard.index');
        }

        return redirect()->route('home.index');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome.index');
    }
}
