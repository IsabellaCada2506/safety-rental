<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-11-03
 * Description: Controller for displaying the partner business listing fetched from an external API.
 */

namespace App\Http\Controllers\User;

use App\Http\Clients\PartnerApiClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(Request $request, PartnerApiClient $partnerApiClient): View
    {
        $partner = $partnerApiClient->fetch();
        $items = $partner['items'] ?? [];
        $perPage = 8;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($items, ($currentPage - 1) * $perPage, $perPage);

        $paginatedItems = new LengthAwarePaginator(
            $currentItems,
            count($items),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        $partner['items'] = $paginatedItems;

        $viewData = [
            'title' => __('integrations.partners'),
            'partner' => $partner,
        ];

        return view('user.partner.index')->with('viewData', $viewData);
    }
}
