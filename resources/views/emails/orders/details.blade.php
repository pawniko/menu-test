@component('mail::message')
    # Order Details

    Here are the details of your order:

    @component('mail::table')
        | Field             | Value                                 |
        | ------------------|:-------------------------------------:|
        | Currency          | {{ $order->purchasedCurrency->code }} |
        | Amount            | {{ $currencyAmount }}                 |
        | Exchange Rate     | {{ $order->exchange_rate }}           |
        | Surcharge Percent | {{ $order->surcharge_percent }}%      |
        | Surcharge Amount  | {{ $surchargeAmount }}                |
        | Total Paid Amount | {{ $totalPaidAmount }}                |

        @if ($order->discount_percent)
            | Discount Percent | {{ $surchargeAmount }}        |
            | Discount Amount  | {{ $order->discount_amount }} |
        @endif
    @endcomponent

@endcomponent
