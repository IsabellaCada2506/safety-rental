<?php

// Author: Isabella Cadavid Posada

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function index(): View
    {
        $viewData = [
            'title' => __('authentication.forgot_password'),
        ];

        return view('auth.passwords.email')
            ->with('viewData', $viewData);
    }

    public function sendResetLink(
        ForgotPasswordRequest $request
    ): RedirectResponse {
        $status = Password::sendResetLink([
            'email' => $request->getEmail(),
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()
            ->withInput([
                'email' => $request->getEmail(),
            ])
            ->withErrors([
                'email' => __($status),
            ]);
    }
}
