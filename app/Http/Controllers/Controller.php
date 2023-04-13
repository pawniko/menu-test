<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ApiResponseHelpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     version="1.0",
 *     title="Currency Exchange API",
 * )
 */
class Controller extends BaseController
{
    use ApiResponseHelpers, AuthorizesRequests, ValidatesRequests;
}
