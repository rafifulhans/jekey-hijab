<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LabaRugiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_ref' => 1, // pastikan data Ref dengan ID 1 tersedia
            'nama_akun' => 'Kas',
            'type' => $this->faker->numberBetween(1, 2),
            'total' => $this->faker->randomFloat(2, 10000, 1000000),
            'tanggal' => $this->faker->date(),
        ];
    }
}
