<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MetodePembayaranFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->randomElement(['BCA', 'Mandiri', 'BRI', 'OVO', 'GoPay']),
        ];
    }
}
