<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JurnalPenyesuaianFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_ref' => 1, // pastikan ada di tabel ref
            'total' => $this->faker->randomFloat(2, 10000, 1000000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
