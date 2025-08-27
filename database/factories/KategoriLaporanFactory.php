<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriLaporanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->randomElement([
                'Arus Kas dari Aktivitas Operasi',
                'Arus Kas dari Aktivitas Investasi',
                'Modal Awal Konveksi'
            ]),
            'kode' => strtoupper($this->faker->bothify('JU#??')),
            'type' => $this->faker->numberBetween(1, 2),
        ];
    }
}
