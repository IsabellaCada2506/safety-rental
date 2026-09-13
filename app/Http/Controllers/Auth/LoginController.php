<?php

/**
 * Author: Isabella Cadavid Posada
 * Author: Wendy Atehortua
 * Date: 2026-09-13
 * Description: Controller handling user login, authentication, and logout.
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {}

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('authentication.login');

        return view('auth.login.index')->with('viewData', $viewData);
    }

    public function authenticate(
        LoginRequest $request
    ): RedirectResponse {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();

        if ($user instanceof User && $this->userService->isAdmin($user)) {
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
