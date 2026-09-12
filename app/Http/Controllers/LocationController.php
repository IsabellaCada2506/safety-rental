<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Customer controller for browsing rental locations and vehicles available at each branch.
 */

namespace App\Http\Controllers;

use App\Interfaces\LocationServiceInterface;
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
        $viewData['title'] = __('location.customer_title_index');
        $viewData['locations'] = $this->locationService->getAllWithCounts();

        return view('locations.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $location = $this->locationService->findWithAvailableCarsOrFail($id);

        $viewData = [];
        $viewData['title'] = $location->getName().' - '.__('location.customer_title_show');
        $viewData['location'] = $location;

        return view('locations.show')->with('viewData', $viewData);
    }
}
