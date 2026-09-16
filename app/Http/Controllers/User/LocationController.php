<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Customer controller for browsing rental locations and vehicles available at each branch.
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Location;
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
        $viewData['title'] = __('location.user_title_index');
        $viewData['locations'] = $locations;

        return view('user.location.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $location = Location::query()
            ->with([
                'cars' => function ($query): void {
                    $query->with('category')
                        ->where('status', Car::STATUS_ACTIVE);
                },
            ])
            ->findOrFail($id);

        $viewData = [];
        $viewData['title'] = $location->getName().' - '.__('location.user_title_show');
        $viewData['location'] = $location;

        return view('user.location.show')->with('viewData', $viewData);
    }
}
