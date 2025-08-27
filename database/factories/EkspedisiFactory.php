<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EkspedisiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->randomElement(['J&T', 'SiCepat', 'JNE', 'AnterAja']),
        ];
    }
}
