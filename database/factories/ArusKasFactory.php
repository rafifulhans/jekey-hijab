<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArusKasFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_ref' => 1, // pastikan data ref dengan id 1 ada
            'total' => $this->faker->randomFloat(2, 10000, 1000000),
            'tanggal' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
