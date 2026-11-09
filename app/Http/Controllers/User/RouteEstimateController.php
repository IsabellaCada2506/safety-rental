<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: Customer controller that estimates driving distance and duration to a rental branch.
 */

namespace App\Http\Controllers\User;

use App\Helpers\GoogleRoutesHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\EstimateRouteRequest;
use App\Models\Location;
use Illuminate\View\View;

class RouteEstimateController extends Controller
{
    public function show(EstimateRouteRequest $request): View
    {
        $validatedData = $request->validated();
        $location = Location::query()->findOrFail((int) $validatedData['location_id']);
        $originLatitude = (float) $validatedData['origin_latitude'];
        $originLongitude = (float) $validatedData['origin_longitude'];

        if (! $location->hasCoordinates()) {
            $viewData = [];
            $viewData['title'] = __('maps.title_show');
            $viewData['location'] = $location;
            $viewData['routeEstimate'] = null;
            $viewData['errorKey'] = 'missing_destination';
            $viewData['originLatitude'] = $originLatitude;
            $viewData['originLongitude'] = $originLongitude;

            return view('user.route-estimate.show')->with('viewData', $viewData);
        }

        $routeEstimate = GoogleRoutesHelper::estimateDrivingRoute(
            $originLatitude,
            $originLongitude,
            (float) $location->getLatitude(),
            (float) $location->getLongitude()
        );

        $viewData = [];
        $viewData['title'] = __('maps.title_show');
        $viewData['location'] = $location;
        $viewData['routeEstimate'] = $routeEstimate;
        $viewData['errorKey'] = $routeEstimate->isOk() ? null : $routeEstimate->getErrorKey();
        $viewData['originLatitude'] = $originLatitude;
        $viewData['originLongitude'] = $originLongitude;

        return view('user.route-estimate.show')->with('viewData', $viewData);
    }
}
