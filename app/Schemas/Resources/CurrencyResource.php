<?php

namespace App\Schemas\Resources;

/**
 * @OA\Schema(
 *      title="CurrencyResource",
 *      type="object"
 * )
 */
class CurrencyResource
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
     *     title="code",
     *     type="string",
     *     example="EUR"
     * )
     */
    public string $code;

    /**
     * @OA\Property(
     *     title="name",
     *     type="string",
     *     example="Euro"
     * )
     */
    public string $name;

    /**
     * @OA\Property(
     *     title="exchange_rate",
     *     type="number",
     *     example=0.88
     * )
     */
    public float $exchange_rate;
}
