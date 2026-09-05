<?php

// Author: Isabella Cadavid Posada

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index(): View
    {
        $viewData = [
            'title' => __('authentication.create_account'),
        ];

        return view('auth.register.index')
            ->with('viewData', $viewData);
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = new User;

        $user->setRole(User::ROLE_CUSTOMER);
        $user->setName($request->getName());
        $user->setLastName($request->getLastName());
        $user->setBirthDate(Carbon::parse($request->getBirthDate()));
        $user->setAddress($request->getAddress());
        $user->setLicenseNumber($request->getLicenseNumber());
        $user->setEmergencyContact($request->getEmergencyContact());
        $user->setIdentificationNumber(
            $request->getIdentificationNumber()
        );
        $user->setEmergencyContactName(
            $request->getEmergencyContactName()
        );
        $user->setEmergencyContactLastName(
            $request->getEmergencyContactLastName()
        );
        $user->setEps($request->getEps());
        $user->setEmail($request->getEmail());
        $user->setPassword($request->getPassword());
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home.index');
    }
}
