<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BukuBesarFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_ref' => 1, // pastikan data ref dengan id 1 ada
            'nama_akun' => 'Kas',
            'type' => $this->faker->numberBetween(1, 2), // 1 = Debit, 2 = Kredit
            'total' => $this->faker->randomFloat(2, 10000, 1000000),
            'tanggal' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
