<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersetujuanPengeluaranGrosirFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nominal' => $this->faker->randomFloat(2, 100000, 5000000),
            'tujuan' => 'Pembelian Bahan Produksi',
            'dokumen' => 'bukti-pengeluaran.jpg',
            'sumber_dana' => 'Kas',
            'catatan_pemimpin' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
