<?php

namespace App\Schemas\Resources;

/**
 * @OA\Schema(
 *      title="CalculationResource",
 *      type="object"
 * )
 */
class CalculationResource
{
    /**
     * @OA\Property(
     *     title="exchange_rate",
     *     type="number",
     *     example=0.88
     * )
     */
    public $exchange_rate;

    /**
     * @OA\Property(
     *     title="surcharge_amount",
     *     type="string",
     *     example="1.25$"
     * )
     */
    public $surcharge_amount;

    /**
     * @OA\Property(
     *     title="total_paid_amount",
     *     type="string",
     *     example="125.55$"
     * )
     */
    public $total_paid_amount;

    /**
     * @OA\Property(
     *     title="discount_percent",
     *     type="string",
     *     example="0.88%"
     * )
     */
    public $discount_percent;

    /**
     * @OA\Property(
     *     title="discount_amount",
     *     type="string",
     *     example="1$"
     * )
     */
    public $discount_amount;
}
