<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-06
 * Description: Controller for displaying and updating the authenticated user's profile.
 */

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        $viewData = [
            'title' => __('authentication.profile'),
            'user' => $user,
        ];

        return view('profile.index')
            ->with('viewData', $viewData);
    }

    public function edit(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        $viewData = [
            'title' => __('authentication.edit_profile'),
            'user' => $user,
        ];

        return view('profile.edit')
            ->with('viewData', $viewData);
    }

    public function update(
        UpdateProfileRequest $request
    ): RedirectResponse {
        /** @var User $user */
        $user = $request->user();

        $user->setName($request->getName());
        $user->setLastName($request->getLastName());
        $user->setBirthDate(
            Carbon::parse($request->getBirthDate())
        );
        $user->setAddress($request->getAddress());
        $user->setLicenseNumber($request->getLicenseNumber());
        $user->setEmergencyContact(
            $request->getEmergencyContact()
        );
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
        $user->save();

        return redirect()
            ->route('profile.index')
            ->with(
                'status',
                __('authentication.profile_updated')
            );
    }
}
