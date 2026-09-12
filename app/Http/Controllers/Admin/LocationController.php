<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Administrator controller for managing physical rental branch locations.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLocationRequest;
use App\Http\Requests\Admin\UpdateLocationRequest;
use App\Interfaces\LocationServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LocationController extends Controller
{
    private readonly LocationServiceInterface $locationService;

    public function __construct(LocationServiceInterface $locationService)
    {
        $this->locationService = $locationService;
    }

    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('location.admin_title_index');
        $viewData['locations'] = $this->locationService->getAllWithCounts();

        return view('admin.location.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('location.admin_title_create');

        return view('admin.location.create')->with('viewData', $viewData);
    }

    public function store(StoreLocationRequest $request): RedirectResponse
    {
        $this->locationService->createFromValidated($request->validated());

        return redirect()->route('admin.location.index')
            ->with('success', __('location.created_success'));
    }

    public function edit(int $id): View
    {
        $location = $this->locationService->findOrFail($id);

        $viewData = [];
        $viewData['title'] = __('location.admin_title_edit');
        $viewData['location'] = $location;

        return view('admin.location.edit')->with('viewData', $viewData);
    }

    public function update(UpdateLocationRequest $request, int $id): RedirectResponse
    {
        $location = $this->locationService->findOrFail($id);
        $this->locationService->updateFromValidated($location, $request->validated());

        return redirect()->route('admin.location.index')
            ->with('success', __('location.updated_success'));
    }

    public function delete(int $id): RedirectResponse
    {
        $location = $this->locationService->findOrFail($id);

        if (! $this->locationService->canBeDeleted($location)) {
            return back()->with('error', __('location.delete_error_referenced'));
        }

        $this->locationService->delete($location);

        return redirect()->route('admin.location.index')
            ->with('success', __('location.deleted_success'));
    }
}
