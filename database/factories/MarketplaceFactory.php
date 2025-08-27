<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MarketplaceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->randomElement(['Tokopedia', 'Shopee', 'Lazada', 'Bukalapak']),
        ];
    }
}
