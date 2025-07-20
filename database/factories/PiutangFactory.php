<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PiutangFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode' => 'PIU-' . $this->faker->unique()->numerify('###'),
            'nama_pelanggan' => $this->faker->name(),
            'jumlah' => $this->faker->randomFloat(2, 50000, 1000000),
            'tanggal' => $this->faker->date(),
            'jatuh_tempo' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'status' => $this->faker->numberBetween(0, 1),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
