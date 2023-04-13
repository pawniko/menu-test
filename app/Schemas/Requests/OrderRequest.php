<?php

namespace App\Schemas\Requests;

/**
 * @OA\Schema(
 *     title="OrderRequest",
 *     type="object",
 *     required={"currency_code", "amount"}
 * )
 */
class OrderRequest
{
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
     *     title="amount",
     *     type="number",
     *     example="150"
     * )
     */
    public float $amount;
}
