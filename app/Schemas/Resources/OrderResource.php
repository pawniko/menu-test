<?php

namespace App\Schemas\Resources;

/**
 * @OA\Schema(
 *      title="OrderResource",
 *      type="object"
 * )
 */
class OrderResource
{
    /**
     * @OA\Property(
     *     title="id",
     *     type="integer",
     *     example=1
     * )
     */
    public int $id;

    /**
     * @OA\Property(
     *     title="currency_code",
     *     type="string",
     *     example="EUR"
     * )
     */
    public string $currency_code;

    /**
     * @OA\Property(
     *     title="name",
     *     type="string",
     *     example="Euro"
     * )
     */
    public $name;

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
     *     title="surcharge_percent",
     *     type="string",
     *     example="0.5%"
     * )
     */
    public $surcharge_percent;

    /**
     * @OA\Property(
     *     title="surcharge_amount",
     *     type="string",
     *     example="1.5$"
     * )
     */
    public $surcharge_amount;

    /**
     * @OA\Property(
     *     title="total_paid_amount",
     *     type="string",
     *     example="15.34$"
     * )
     */
    public $total_paid_amount;

    /**
     * @OA\Property(
     *     title="created_at",
     *     type="string",
     *     example="2023-04-12 01:00:41"
     * )
     */
    public $created_at;
}
