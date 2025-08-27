<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RefFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_akun' => $this->faker->randomElement(['Kas', 'Piutang', 'Utang', 'Modal']),
            'kode' => $this->faker->unique()->numerify('1##')
        ];
    }
}
