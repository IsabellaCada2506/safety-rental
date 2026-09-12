<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-06
 * Description: Controller for handling email verification requests.
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerificationController extends Controller
{
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function index(Request $request): View|RedirectResponse
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended($this->redirectTo)
            : view('auth.verification.index');
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($this->redirectTo.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended($this->redirectTo.'?verified=1');
    }

    public function resend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($this->redirectTo);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }
}
