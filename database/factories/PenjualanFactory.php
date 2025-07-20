<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PenjualanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_marketplace' => 1,
            'id_ekspedisi' => 1,
            'id_metode_pembayaran' => 1,
            'nama_marketplace' => 'Tokopedia',
            'nama_ekspedisi' => 'J&T',
            'nomor_resi' => $this->faker->uuid(),
            'nama_produk' => $this->faker->word(),
            'nama_varian' => $this->faker->optional()->word(),
            'qty' => $this->faker->numberBetween(1, 10),
            'subtotal' => 100000,
            'diskon' => 5000,
            'ongkir' => 10000,
            'total' => 105000,
            'alamat_pembeli' => $this->faker->address(),
            'email_pembeli' => $this->faker->email(),
            'nomor_telepon_pembeli' => $this->faker->phoneNumber(),
            'status_order' => 1,
            'status_pembayaran' => 1,
            'metode_pembayaran' => 'BCA',
            'tanggal_pembayaran' => $this->faker->date(),
            'status_persetujuan' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
