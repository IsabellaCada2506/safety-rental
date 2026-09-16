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
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(): View
    {
        $locations = Location::query()
            ->withCount(['cars', 'reservations'])
            ->orderBy('name')
            ->get();

        $viewData = [];
        $viewData['title'] = __('location.admin_title_index');
        $viewData['locations'] = $locations;

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
        $validatedData = $request->validated();

        $location = new Location;
        $location->setName((string) $validatedData['name']);
        $location->setAddress((string) $validatedData['address']);
        $location->setHeadquarters((string) $validatedData['headquarters']);
        $location->setTelephone((string) $validatedData['telephone']);
        $location->setCity((string) $validatedData['city']);
        $location->save();

        return redirect()->route('admin.location.index')
            ->with('success', __('location.created_success'));
    }

    public function edit(int $id): View
    {
        $location = Location::query()->findOrFail($id);

        $viewData = [];
        $viewData['title'] = __('location.admin_title_edit');
        $viewData['location'] = $location;

        return view('admin.location.edit')->with('viewData', $viewData);
    }

    public function update(UpdateLocationRequest $request, int $id): RedirectResponse
    {
        $location = Location::query()->findOrFail($id);
        $validatedData = $request->validated();

        $location->setName((string) $validatedData['name']);
        $location->setAddress((string) $validatedData['address']);
        $location->setHeadquarters((string) $validatedData['headquarters']);
        $location->setTelephone((string) $validatedData['telephone']);
        $location->setCity((string) $validatedData['city']);
        $location->save();

        return redirect()->route('admin.location.index')
            ->with('success', __('location.updated_success'));
    }

    public function delete(int $id): RedirectResponse
    {
        $location = Location::query()->findOrFail($id);
        $hasReferences = $location->cars()->count() > 0 || $location->reservations()->count() > 0;

        if ($hasReferences) {
            return back()->with('error', __('location.delete_error_referenced'));
        }

        $location->delete();

        return redirect()->route('admin.location.index')
            ->with('success', __('location.deleted_success'));
    }
}
