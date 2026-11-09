<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: Customer controller that displays the preceding team fleet consumed through HTTP.
 */

namespace App\Http\Controllers\User;

use App\Helpers\PartnerFleetHelper;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(): View
    {
        $partnerResult = PartnerFleetHelper::fetchAvailableVehicles();

        $viewData = [];
        $viewData['title'] = __('partner.title_index');
        $viewData['vehicles'] = $partnerResult['vehicles'];
        $viewData['isAvailable'] = $partnerResult['ok'];
        $viewData['errorKey'] = $partnerResult['errorKey'];

        return view('user.partner.index')->with('viewData', $viewData);
    }
}
