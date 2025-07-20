<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{
    User, Ref, MetodePembayaran, Ekspedisi, Invoice, ArusKas, BukuBesar,
    JurnalPenyesuaian, JurnalTransaksi, JurnalUmum, KategoriLaporan,
    LabaRugi, Marketplace, NeracaSaldo, Penjualan, Produk,
    PersetujuanPengeluaranGrosir, Piutang, Utang
};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Referensi
        $refs = DB::table('ref')->insert(
            [
                ['nama_akun' => 'Kas', 'kode' => 101],
                ['nama_akun' => 'Pendapatan Jasa', 'kode' => 102],
                ['nama_akun' => 'Penjualan', 'kode' => 103],
                ['nama_akun' => 'Modal Awal', 'kode' => 104],
                ['nama_akun' => 'Piutang Usaha', 'kode' => 105],
                ['nama_akun' => 'Beban Gaji', 'kode' => 201],
                ['nama_akun' => 'Beban Listrik', 'kode' => 202],
                ['nama_akun' => 'Utang Usaha', 'kode' => 203],
                ['nama_akun' => 'Beban Operasional', 'kode' => 204],
                ['nama_akun' => 'Beban Pemasaran', 'kode' => 205]
            ]
        );

        // --- Master Data
        $metodes = DB::table('metode_pembayaran')->insert(
            [
                ['nama' => 'BCA'],
                ['nama' => 'Mandiri'],
                ['nama' => 'BRI'],
                ['nama' => 'BNI'],
                ['nama' => 'OVO'],
                ['nama' => 'DANA'],
                ['nama' => 'Gopay'],
                ['nama' => 'ShopeePay'],
                ['nama' => 'Cash on Delivery (COD)'],
                ['nama' => 'Transfer Bank'],
                ['nama' => 'Kartu Kredit'],
                ['nama' => 'QRIS'],
                ['nama' => 'LinkAja'],
                ['nama' => 'Alfamart'],
                ['nama' => 'Indomaret'],
                ['nama' => 'Kartu Debit'],
                ['nama' => 'Kartu Prabayar'],
                ['nama' => 'Virtual Account'],
                ['nama' => 'E-Wallet']
            ]
        );

        $marketplaces = DB::table('marketplace')->insert([
            ['nama' => 'Shopee'],
            ['nama' => 'Tokopedia'],
            ['nama' => 'Bukalapak'],
            ['nama' => 'Lazada'],
            ['nama' => 'Blibli'],
            ['nama' => 'JD.ID'],
            ['nama' => 'Zalora'],
            ['nama' => 'Bhinneka'],
            ['nama' => 'Elevenia'],
            ['nama' => 'Orami']
        ]);

        $ekspedisis = DB::table('ekspedisi')->insert([
            ['nama' => 'JNE'],
            ['nama' => 'TIKI'],
            ['nama' => 'POS Indonesia'],
            ['nama' => 'SiCepat'],
            ['nama' => 'Gojek'],
            ['nama' => 'Grab'],
            ['nama' => 'Anteraja'],
            ['nama' => 'Ninja Xpress'],
            ['nama' => 'Lion Parcel'],
            ['nama' => 'Wahana']
        ]);

        $produks = DB::table('produk')->insert([
            ['nama' => 'Jilbab Segi Empat', 'harga' => 50000, 'deskripsi' => 'Jilbab segi empat dengan bahan berkualitas tinggi.', 'slug' => 'jilbab-segi-empat'],
            ['nama' => 'Jilbab Pashmina', 'harga' => 75000, 'deskripsi' => 'Jilbab pashmina yang stylish dan nyaman dipakai.', 'slug' => 'jilbab-pashmina'],
            ['nama' => 'Jilbab Instan', 'harga' => 60000, 'deskripsi' => 'Jilbab instan yang mudah dipakai dan praktis.', 'slug' => 'jilbab-instan'],
            ['nama' => 'Jilbab Bergo', 'harga' => 80000, 'deskripsi' => 'Jilbab bergo dengan desain modern dan elegan.', 'slug' => 'jilbab-bergo'],
            ['nama' => 'Jilbab Syar’i', 'harga' => 90000, 'deskripsi' => 'Jilbab syar’i dengan bahan adem dan nyaman.', 'slug' => 'jilbab-syari'],
            ['nama' => 'Jilbab Khimar', 'harga' => 85000, 'deskripsi' => 'Jilbab khimar yang menutup aurat dengan baik.', 'slug' => 'jilbab-khimar'],
            ['nama' => 'Jilbab Hoodie', 'harga' => 95000, 'deskripsi' => 'Jilbab hoodie yang trendy dan cocok untuk aktivitas sehari-hari.', 'slug' => 'jilbab-hoodie'],
            ['nama' => 'Jilbab Casual', 'harga' => 70000, 'deskripsi' => 'Jilbab casual yang cocok untuk berbagai acara.', 'slug' => 'jilbab-casual'],
            ['nama' => 'Jilbab Formal', 'harga' => 100000, 'deskripsi' => 'Jilbab formal yang elegan untuk acara resmi.', 'slug' => 'jilbab-formal'],
            ['nama' => 'Jilbab Anak', 'harga' => 40000, 'deskripsi' => 'Jilbab anak dengan desain lucu dan nyaman.', 'slug' => 'jilbab-anak'],
            ['nama'=> 'Jilbab Sport', 'harga' => 55000, 'deskripsi' => 'Jilbab sport yang nyaman untuk berolahraga.', 'slug' => 'jilbab-sport'],
            ['nama'=> 'Jilbab Premium', 'harga' => 120000, 'deskripsi' => 'Jilbab premium dengan bahan berkualitas tinggi.', 'slug' => 'jilbab-premium'],
            ['nama'=> 'Jilbab Limited Edition', 'harga' => 150000, 'deskripsi' => 'Jilbab limited edition dengan desain eksklusif.', 'slug' => 'jilbab-limited-edition']
        ]);

        // // --- Invoice
        // Invoice::factory()->count(5)->create([
        //     'id_metode_pembayaran' => $metodes->random()->id,
        //     'metode_pembayaran' => $metodes->random()->nama,
        // ]);

        // // --- Kas dan Buku Besar
        // ArusKas::factory()->count(5)->create([
        //     'id_ref' => $refs->random()->id,
        // ]);

        // BukuBesar::factory()->count(5)->create([
        //     'id_ref' => $refs->random()->id,
        // ]);

        // // --- Jurnal
        // JurnalPenyesuaian::factory()->count(5)->create([
        //     'id_ref' => $refs->random()->id,
        // ]);

        // JurnalTransaksi::factory()->count(5)->create([
        //     'id_ref' => $refs->random()->id,
        //     'nama_akun' => 'Kas',
        // ]);

        // JurnalUmum::factory()->count(5)->create([
        //     'id_ref' => $refs->random()->id,
        //     'nama_akun' => 'Kas',
        // ]);

        // // --- Kategori Laporan
        // KategoriLaporan::factory()->count(3)->create();

        // // --- Laba Rugi
        // LabaRugi::factory()->count(5)->create([
        //     'id_ref' => $refs->random()->id,
        //     'nama_akun' => 'Kas',
        // ]);

        // // --- Neraca Saldo
        // NeracaSaldo::factory()->count(5)->create([
        //     'id_ref' => $refs->random()->id,
        // ]);

        // // --- Penjualan
        // Penjualan::factory()->count(5)->create([
        //     'id_marketplace' => $marketplaces->random()->id,
        //     'id_ekspedisi' => $ekspedisis->random()->id,
        //     'id_metode_pembayaran' => $metodes->random()->id,
        //     'nama_marketplace' => $marketplaces->random()->nama,
        //     'nama_ekspedisi' => $ekspedisis->random()->nama,
        //     'metode_pembayaran' => $metodes->random()->nama,
        // ]);

        // // --- Piutang & Utang
        // Piutang::factory()->count(5)->create();
        // Utang::factory()->count(5)->create();

        // // --- Pengeluaran Grosir
        // PersetujuanPengeluaranGrosir::factory()->count(2)->create();

        // --- Users
        $users = [
            ['username' => 'hans', 'email' => 'hans@gmail.com', 'role' => 1],
            ['username' => 'chyntia', 'email' => 'chyntia@gmail.com', 'role' => 2],
            ['username' => 'andi', 'email' => 'andi@gmail.com', 'role' => 3]
        ];

        foreach ($users as $user) 
        {
            User::factory()->create($user);
        }

    }
}
