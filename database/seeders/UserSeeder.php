<?php

namespace Database\Seeders;

use App\Enums\AvailableCurrencies;
use App\Models\Currency;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class UserSeeder extends Seeder
{
    public function __construct(protected OrderService $orderService)
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->create([
                'name'  => 'Nikola Pavlovic',
                'email' => 'pawniko@gmail.com',
            ])->each(function ($user) {
                $this->createUserOrders($user);
            });
    }

    private function createUserOrders(User $user): void
    {
        Auth::login($user);

        foreach (Currency::all() as $currency) {
            if (AvailableCurrencies::tryFrom($currency->code)) {
                $this->orderService->create([
                    'currency_code' => $currency->code,
                    'amount'        => 100,
                ]);
            }
        }
    }
}
