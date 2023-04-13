<?php

namespace App\Http\Controllers\Api;

use App\Enums\AvailableCurrencies;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\CalculationResource;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService,
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/orders/calculation",
     *     tags={"orders"},
     *     summary="Get order calculation",
     *     @OA\Parameter(
     *         name="currency_code",
     *         in="query",
     *         description="Selected currency for order",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="EUR"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="Amount",
     *         required=true,
     *         @OA\Schema(
     *             type="number",
     *             example=100
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order calculation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/CalculationResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The currency code field is required. (and 1 more error)"
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "currency_code": {
     *                         "The currency code field is required."
     *                     },
     *                     "amount": {
     *                         "The currency code field is required."
     *                     }
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function calculation(OrderRequest $request)
    {
        $calculation = $this->orderService->getCalculation($request->validated());

        return new CalculationResource($calculation);
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     tags={"orders"},
     *     summary="Place an order",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/OrderRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order created",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/OrderResource"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The currency code field is required. (and 1 more error)"
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "currency_code": {
     *                         "The currency code field is required."
     *                     },
     *                     "amount": {
     *                         "The currency code field is required."
     *                     }
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function store(OrderRequest $request)
    {
        $order = $this->orderService->create($request->validated());

        return new OrderResource($order);
    }
}
