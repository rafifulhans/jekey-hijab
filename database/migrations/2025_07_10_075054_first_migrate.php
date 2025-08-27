<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('marketplace', function (Blueprint $table) {
            $table->string('id_marketplace', 255)->primary();
            $table->string('nama', 50);
        });

        Schema::create('ekspedisi', function (Blueprint $table) {
            $table->string('id_ekspedisi', 255)->primary();
            $table->string('nama', 30);
        });

        Schema::create('produk', function (Blueprint $table) {
            $table->string('id_produk', 255)->primary();
            $table->string('nama');
            $table->decimal('harga', 10, 2)->default(0);
            $table->string('slug');
            $table->text('deskripsi')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('metode_pembayaran', function (Blueprint $table) {
            $table->string('id_metode_pembayaran', 255)->primary();
            $table->string('nama', 30);
        });

        Schema::create('penjualan', function (Blueprint $table) {
            $table->string('id_penjualan', 255)->primary();
            $table->string('id_marketplace', 255)->references('id_marketplace')->on('marketplace')->onDelete('cascade');
            $table->string('id_ekspedisi', 255)->references('id_ekspedisi')->on('ekspedisi');
            $table->string('id_metode_pembayaran', 255)->references('id_metode_pembayaran')->on('metode_pembayaran');
            $table->string('id_produk', 255)->references('id_produk')->on('produk');
            $table->string('nama_marketplace', 50);
            $table->string('nama_ekspedisi', 30);
            $table->string('nomor_resi', 50);
            $table->string('nama_produk');
            $table->string('nama_varian')->nullable();
            $table->integer('qty')->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('diskon', 10, 2)->default(0);
            $table->decimal('ongkir', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->text('alamat_pembeli');
            $table->string('email_pembeli');
            $table->string('nomor_telepon_pembeli', 30)->nullable();
            $table->tinyInteger('status_order')->default(0);
            $table->tinyInteger('status_pembayaran')->default(0);
            $table->string('metode_pembayaran', 50);
            $table->date('tanggal_pembayaran')->nullable();
            $table->tinyInteger('status_persetujuan')->default(0);
            $table->timestamps();
        });


        Schema::create('invoice', function (Blueprint $table) {
            $table->string('id_invoice', 255)->primary();
            $table->string('id_metode_pembayaran', 255)->references('id_metode_pembayaran')->on('metode_pembayaran');
            $table->string('metode_pembayaran', 30);
            $table->date('tanggal');
            $table->string('invoice');
            $table->string('nama_customer')->nullable();
            $table->text('alamat_customer')->nullable();
            $table->integer('total_barang')->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('diskon', 10, 2)->nullable()->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('invoice_barang', function (Blueprint $table) {
            $table->string('id_invoice_barang', 255)->primary();
            $table->string('id_invoice', 255)->references('id_invoice')->on('invoice')->onDelete('cascade');
            $table->string('nama_barang');
            $table->integer('qty');
            $table->decimal('harga', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('ref', function (Blueprint $table) {
            $table->string('id_ref', 255)->primary();
            $table->string('nama_akun', 50)->nullable();
            $table->string('kode', 30);
        });

        Schema::create('laba_rugi', function (Blueprint $table) {
            $table->string('id_laba_rugi', 255)->primary();
            $table->string('id_ref', 255)->nullable()->references('id_ref')->on('ref');
            $table->string('nama_akun', 50)->nullable();
            $table->tinyInteger('type')->nullable();
            $table->integer('jumlah');
            $table->decimal('total', 10, 2)->nullable();
            $table->date('tanggal');
        });

        Schema::create('neraca_saldo', function (Blueprint $table) {
            $table->string('id_neraca_saldo', 255)->primary();
            $table->string('id_ref', 255)->nullable()->references('id_ref')->on('ref');
            $table->string('nama_akun', 50);
            $table->decimal('debit', 10, 2)->nullable()->default(0);
            $table->decimal('kredit', 10, 2)->nullable()->default(0);
            $table->timestamps();
        });

        Schema::create('kategori_laporan', function (Blueprint $table) {
            $table->string('id_kategori_laporan', 255)->primary();
            $table->string('nama');
            $table->string('kode', 30);
            $table->tinyInteger('type')->nullable();
        });

        Schema::create('arus_kas', function (Blueprint $table) {
            $table->string('id_arus_kas', 255)->primary();
            $table->string('id_ref', 255)->nullable()->references('id_ref')->on('ref');
            $table->decimal('total', 10, 2);
            $table->date('tanggal');
            $table->tinyInteger('type')->nullable();
            $table->string('nama_akun', 50)->nullable();
            $table->integer('jumlah');
            $table->timestamps();
        });

        Schema::create('jurnal_transaksi', function (Blueprint $table) {
            $table->string('id_jurnal_transaksi', 255)->primary();
            $table->string('id_ref', 255)->nullable()->references('id_ref')->on('ref');
            $table->string('nama_akun', 50);
            $table->tinyInteger('type')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('jurnal_umum', function (Blueprint $table) {
            $table->string('id_jurnal_umum', 255)->primary();
            $table->string('id_ref', 255)->nullable()->references('id_ref')->on('ref');
            $table->string('nama_akun', 50);
            $table->tinyInteger('type')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('jurnal_penyesuaian', function (Blueprint $table) {
            $table->string('id_jurnal_penyesuaian', 255)->primary();
            $table->string('id_ref', 255)->nullable()->references('id_ref')->on('ref');
            $table->string('nama_akun', 50);
            $table->tinyInteger('type')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->string('keterangan', 50)->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('buku_besar', function (Blueprint $table) {
            $table->string('id_buku_besar', 255)->primary();
            $table->string('id_ref', 255)->nullable()->references('id_ref')->on('ref');
            $table->string('group', 50)->nullable();
            $table->string('keterangan', 50)->nullable();
            $table->decimal('debit', 10, 2)->nullable()->default(0);
            $table->decimal('kredit', 10, 2)->nullable()->default(0);
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('piutang', function (Blueprint $table) {
            $table->string('id_piutang', 255)->primary();
            $table->string('kode');
            $table->string('nama_pelanggan');
            $table->decimal('jumlah', 10, 2)->nullable();
            $table->date('tanggal');
            $table->date('jatuh_tempo');
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });

        Schema::create('utang', function (Blueprint $table) {
            $table->string('id_utang', 255)->primary();
            $table->string('kode');
            $table->string('nama_pemasok');
            $table->decimal('jumlah', 10, 2)->nullable();
            $table->date('tanggal');
            $table->date('jatuh_tempo');
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });

        Schema::create('persetujuan_pengeluaran_grosir', function (Blueprint $table) {
            $table->string('id_persetujuan_pengeluaran_grosir', 255)->primary();
            $table->decimal('nominal', 10, 2)->nullable();
            $table->string('tujuan', 50);
            $table->string('dokumen')->nullable();
            $table->string('sumber_dana');
            $table->text('catatan_pemimpin')->nullable();
            $table->tinyInteger('status_persetujuan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persetujuan_pengeluaran_grosir');
        Schema::dropIfExists('utang');
        Schema::dropIfExists('piutang');
        Schema::dropIfExists('buku_besar');
        Schema::dropIfExists('jurnal_penyesuaian');
        Schema::dropIfExists('jurnal_umum');
        Schema::dropIfExists('jurnal_transaksi');
        Schema::dropIfExists('arus_kas');
        Schema::dropIfExists('kategori_laporan');
        Schema::dropIfExists('neraca_saldo');
        Schema::dropIfExists('laba_rugi');
        Schema::dropIfExists('ref');
        Schema::dropIfExists('invoice');
        Schema::dropIfExists('penjualan');
        Schema::dropIfExists('metode_pembayaran');
        Schema::dropIfExists('produk');
        Schema::dropIfExists('ekspedisi');
        Schema::dropIfExists('marketplace');
    }
};
