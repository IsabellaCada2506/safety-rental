<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Administrator controller for listing, editing, and deleting application users.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeleteUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->withCount('reservations')
            ->orderBy('name')
            ->orderBy('id')
            ->get();

        $viewData = [];
        $viewData['title'] = __('user.admin_title_index');
        $viewData['users'] = $users;

        return view('admin.user.index')->with('viewData', $viewData);
    }

    public function edit(int $id): View
    {
        $user = User::query()
            ->withCount('reservations')
            ->findOrFail($id);

        $viewData = [];
        $viewData['title'] = __('user.admin_title_edit');
        $viewData['user'] = $user;
        $viewData['roleOptions'] = [
            User::ROLE_ADMIN => __('user.role_admin'),
            User::ROLE_CUSTOMER => __('user.role_customer'),
        ];

        return view('admin.user.edit')->with('viewData', $viewData);
    }

    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $user = User::query()->findOrFail($id);
        $newRole = (string) $validatedData['role'];

        $adminCount = User::query()->where('role', User::ROLE_ADMIN)->count();
        if ($user->isAdmin() && $newRole === User::ROLE_CUSTOMER && $adminCount <= 1) {
            return back()
                ->withInput()
                ->withErrors(['role' => __('user.update_error_last_admin')]);
        }

        $user->setName((string) $validatedData['name']);
        $user->setLastName((string) $validatedData['last_name']);
        $user->setBirthDate(Carbon::parse((string) $validatedData['birth_date']));
        $user->setAddress((string) $validatedData['address']);
        $user->setLicenseNumber((int) $validatedData['license_number']);
        $user->setEmergencyContact((int) $validatedData['emergency_contact']);
        $user->setIdentificationNumber((int) $validatedData['identification_number']);
        $user->setEmergencyContactName((string) $validatedData['emergency_contact_name']);
        $user->setEmergencyContactLastName((string) $validatedData['emergency_contact_last_name']);
        $user->setEps((string) $validatedData['eps']);
        $user->setEmail((string) $validatedData['email']);
        $user->setRole($newRole);

        if (! empty($validatedData['password'])) {
            $user->setPassword((string) $validatedData['password']);
        }

        $user->save();

        return redirect()->route('admin.user.index')->with('success', __('user.updated_success'));
    }

    public function delete(DeleteUserRequest $request, int $id): RedirectResponse
    {
        $request->validated();
        $user = User::query()->withCount('reservations')->findOrFail($id);
        $actor = $request->user();

        if ($user->getId() === $actor?->getId()) {
            return back()->with('error', __('user.delete_error_self'));
        }

        $adminCount = User::query()->where('role', User::ROLE_ADMIN)->count();
        if ($user->isAdmin() && $adminCount <= 1) {
            return back()->with('error', __('user.delete_error_last_admin'));
        }

        if ($user->getReservationsCount() > 0) {
            return back()->with('error', __('user.delete_error_reservations'));
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success', __('user.deleted_success'));
    }
}
