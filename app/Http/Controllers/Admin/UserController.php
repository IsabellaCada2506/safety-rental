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
use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    private readonly UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('user.admin_title_index');
        $viewData['users'] = $this->userService->getAll();

        return view('admin.user.index')->with('viewData', $viewData);
    }

    public function edit(int $id): View
    {
        $user = $this->userService->findOrFail($id);

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
        $user = $this->userService->findOrFail($id);
        $newRole = (string) $validatedData['role'];

        if (! $this->userService->canChangeRole($user, $newRole)) {
            return back()
                ->withInput()
                ->withErrors(['error' => $this->userService->roleChangeDenialReason($user, $newRole)]);
        }

        $this->userService->updateByAdmin($user, $validatedData);

        return redirect()
            ->route('admin.user.index')
            ->with('success', __('user.updated_success'));
    }

    public function delete(DeleteUserRequest $request, int $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $user = $this->userService->findOrFail($id);
        $actor = $request->user();

        if (! $actor instanceof User || ! $this->userService->canBeDeleted($user, $actor)) {
            return back()->withErrors([
                'error' => $actor instanceof User
                    ? $this->userService->deleteDenialReason($user, $actor)
                    : __('user.delete_error_forbidden'),
            ]);
        }

        $this->userService->delete($user);

        return redirect()
            ->route('admin.user.index')
            ->with('success', __('user.deleted_success'));
    }
}
