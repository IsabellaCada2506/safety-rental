<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-06
 * Description: Controller for displaying and updating the authenticated user's profile.
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $viewData = [
            'title' => __('authentication.profile'),
            'user' => $user,
        ];

        return view('user.profile.index')
            ->with('viewData', $viewData);
    }

    public function edit(Request $request): View
    {
        $user = $request->user();

        $viewData = [
            'title' => __('authentication.edit_profile'),
            'user' => $user,
        ];

        return view('user.profile.edit')
            ->with('viewData', $viewData);
    }

    public function update(
        UpdateProfileRequest $request
    ): RedirectResponse {
        $user = $request->user();
        $validatedData = $request->validated();

        if ($user instanceof User) {
            $user->setName((string) $validatedData['name']);
            $user->setLastName((string) $validatedData['last_name']);
            $user->setBirthDate(
                Carbon::parse((string) $validatedData['birth_date'])
            );
            $user->setAddress((string) $validatedData['address']);
            $user->setLicenseNumber((int) $validatedData['license_number']);
            $user->setEmergencyContact(
                (int) $validatedData['emergency_contact']
            );
            $user->setIdentificationNumber(
                (int) $validatedData['identification_number']
            );
            $user->setEmergencyContactName(
                (string) $validatedData['emergency_contact_name']
            );
            $user->setEmergencyContactLastName(
                (string) $validatedData['emergency_contact_last_name']
            );
            $user->setEps((string) $validatedData['eps']);
            $user->setEmail((string) $validatedData['email']);
            $user->save();
        }

        return redirect()
            ->route('profile.index')
            ->with(
                'status',
                __('authentication.profile_updated')
            );
    }
}
