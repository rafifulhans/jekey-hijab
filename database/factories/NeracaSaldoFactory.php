<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NeracaSaldoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_ref' => 1, // pastikan Ref tersedia
            'total' => $this->faker->randomFloat(2, 10000, 10000000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
