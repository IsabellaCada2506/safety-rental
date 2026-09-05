<?php

// Author: Isabella Cadavid Posada

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function index(Request $request, string $token): View
    {
        $viewData = [
            'title' => __('authentication.reset_password'),
            'token' => $token,
            'email' => (string) $request->query('email', ''),
        ];

        return view('auth.passwords.reset')
            ->with('viewData', $viewData);
    }

    public function update(
        ResetPasswordRequest $request
    ): RedirectResponse {
        $status = Password::reset(
            [
                'email' => $request->getEmail(),
                'password' => $request->getPassword(),
                'password_confirmation' => $request->getPassword(),
                'token' => $request->getToken(),
            ],
            function (User $user, string $password): void {
                $user->setPassword($password);
                $user->setRememberTokenValue(Str::random(60));
                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with('status', __($status));
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
