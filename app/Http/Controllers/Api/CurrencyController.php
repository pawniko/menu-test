<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyResource;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;

class CurrencyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/currencies",
     *     tags={"currencies"},
     *     summary="Get list of currencies",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/CurrencyResource")
     *             )
     *         )
     *     ),
     * )
     */
    public function index(CurrencyRepositoryInterface $currencyRepository)
    {
        return CurrencyResource::collection($currencyRepository->all());
    }
}
