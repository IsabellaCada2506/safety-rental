<?php

namespace App\Http\Controllers\User;

use App\Http\Clients\PartnerApiClient;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(PartnerApiClient $partnerApiClient): View
    {
        $viewData = ['title' => __('integrations.partners'), 'partner' => $partnerApiClient->fetch()];

        return view('user.partner.index')->with('viewData', $viewData);
    }
}
