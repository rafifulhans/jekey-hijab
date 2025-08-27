<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_metode_pembayaran' => 1, // pastikan data metode_pembayaran ada
            'metode_pembayaran' => $this->faker->randomElement(['BCA', 'Mandiri']),
            'invoice' => 'INV-' . $this->faker->unique()->numerify('#####'),
            'nama_customer' => $this->faker->name(),
            'alamat_customer' => $this->faker->address(),
            'barang' => $this->faker->word(),
            'qty' => $this->faker->numberBetween(1, 10),
            'harga' => $this->faker->randomFloat(2, 10000, 500000),
            'total' => $this->faker->randomFloat(2, 10000, 1000000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
