<?php

namespace App\Http\Requests;

use App\Enums\AvailableCurrencies;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class OrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'currency_code' => ['required', new Enum(AvailableCurrencies::class)],
            'amount'        => 'required|numeric',
        ];
    }
}
