<?php

/**
 * Author: Isabella Cadavid Posada
 * Date: 2026-09-05
 * Description: Base controller providing common authorization and validation traits.
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
