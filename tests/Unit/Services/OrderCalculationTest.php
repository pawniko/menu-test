<?php

namespace Tests\Unit\Services;

use App\Models\Currency;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class OrderCalculationTest extends TestCase
{
    public function test_order_service_calculation()
    {
        $currency                = new Currency();
        $currency->code          = 'EUR';
        $currency->exchange_rate = 1;

        $orderRepositoryMock    = Mockery::mock(OrderRepositoryInterface::class);
        $currencyRepositoryMock = Mockery::mock(CurrencyRepositoryInterface::class);
        $currencyRepositoryMock
            ->shouldReceive('findBy')
            ->once()
            ->with(['code' => 'EUR'])
            ->andReturn(new Collection([$currency]));

        $orderService = new OrderService($currencyRepositoryMock, $orderRepositoryMock);

        $expectedResult = [
            'from_currency'         => config('currency.default'),
            'purchased_currency'    => 'EUR',
            'currency_amount'       => 100,
            'exchange_rate'         => 1,
            'surcharge_percent'     => 5,
            'surcharge_amount'      => 5,
            'total_paid_amount'     => 104.9,
            'discount_percent'      => 2,
            'discount_amount'       => 0.1,
        ];

        $result = $orderService->getCalculation('EUR', 100);

        $this->assertEquals($expectedResult, $result);
    }
}
