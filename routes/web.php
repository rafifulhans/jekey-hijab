<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('/', Controllers\HomeController::class)->name('home')->middleware('guest');
Route::get('/login', Controllers\Auth\LoginController::class)->name('login')->middleware('guest');
Route::post('/login', [Controllers\Auth\LoginController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Controllers\DashboardController::class)->name('dashboard');
    Route::post('/logout', [Controllers\DashboardController::class, 'logout'])->name('logout'); 

    // Ringkasa Laporan
    Route::get('/ringkasan-laporan', [Controllers\DashboardController::class, 'ringkasan_laporan'])->name('ringkasan-laporan');

    // Laba Rugi Controller
    Route::get('/laba-rugi', [Controllers\Report\LabaRugiController::class, 'indeks'])->name('laba-rugi');
    Route::get('/laba-rugi/export', [Controllers\Report\LabaRugiController::class, 'export'])->name('laba-rugi.export');
    Route::post('/laba-rugi', [Controllers\Report\LabaRugiController::class, 'indeks'])->name('laba-rugi.filter-date');

    // Neraca Saldo Controller
    Route::get('/neraca-saldo', [Controllers\Report\NeracaSaldoController::class, 'indeks'])->name('neraca-saldo');
    Route::get('/neraca-saldo/export', [Controllers\Report\NeracaSaldoController::class, 'export'])->name('neraca-saldo.export');
    Route::post('/neraca-saldo', [Controllers\Report\NeracaSaldoController::class, 'indeks'])->name('neraca-saldo.filter-date');

    // Buku Besar Controller
    Route::get('/buku-besar', [Controllers\Report\BukuBesarController::class, 'indeks'])->name('buku-besar');
    Route::post('/buku-besar/add-group', [Controllers\Report\BukuBesarController::class, 'add_group'])->name('buku-besar.add-group');
    Route::get('/buku-besar/export', [Controllers\Report\BukuBesarController::class, 'export'])->name('buku-besar.export');
    Route::post('/buku-besar', [Controllers\Report\BukuBesarController::class, 'indeks'])->name('buku-besar.filter-date');

    // Arus Kas Controller
    Route::get('/arus-kas', [Controllers\Report\ArusKasController::class, 'indeks'])->name('arus-kas');
    Route::get('/arus-kas/export', [Controllers\Report\ArusKasController::class, 'export'])->name('arus-kas.export');
    Route::post('/arus-kas', [Controllers\Report\ArusKasController::class, 'indeks'])->name('arus-kas.filter-date');

    // Jurnal Transaksi Controller
    Route::get('/jurnal-transaksi', [Controllers\Report\JurnalTransaksiController::class, 'indeks'])->name('jurnal-transaksi');
    Route::get('/jurnal-transaksi/tambah', [Controllers\Report\JurnalTransaksiController::class, 'tambah'])->name('jurnal-transaksi.tambah');
    Route::post('/jurnal-transaksi/simpan', [Controllers\Report\JurnalTransaksiController::class, 'simpan'])->name('jurnal-transaksi.simpan');
    Route::get('/jurnal-transaksi/{id}/edit', [Controllers\Report\JurnalTransaksiController::class, 'edit'])->name('jurnal-transaksi.edit');
    Route::delete('/jurnal-transaksi/{id}/hapus', [Controllers\Report\JurnalTransaksiController::class, 'hapus'])->name('jurnal-transaksi.hapus');
    Route::put('/jurnal-transaksi/{id}/update', [Controllers\Report\JurnalTransaksiController::class, 'update'])->name('jurnal-transaksi.update');
    Route::get('/jurnal-transaksi/export', [Controllers\Report\JurnalTransaksiController::class, 'export'])->name('jurnal-transaksi.export');
    Route::post('/jurnal-transaksi', [Controllers\Report\JurnalTransaksiController::class, 'indeks'])->name('jurnal-transaksi.filter-date');

    // Jurnal Umum Controller
    Route::get('/jurnal-umum', [Controllers\Report\JurnalUmumController::class, 'indeks'])->name('jurnal-umum');
    Route::get('/jurnal-umum/export', [Controllers\Report\JurnalUmumController::class, 'export'])->name('jurnal-umum.export');
    Route::post('/jurnal-umum', [Controllers\Report\JurnalUmumController::class, 'indeks'])->name('jurnal-umum.filter-date');

    // Jurnal Penyesuaian Controller
    Route::get('/jurnal-penyesuaian', [Controllers\Report\JurnalPenyesuaianController::class, 'indeks'])->name('jurnal-penyesuaian');
    Route::get('/jurnal-penyesuaian/tambah', [Controllers\Report\JurnalPenyesuaianController::class, 'tambah'])->name('jurnal-penyesuaian.tambah');
    Route::post('/jurnal-penyesuaian', [Controllers\Report\JurnalPenyesuaianController::class, 'simpan'])->name('jurnal-penyesuaian.simpan');
    Route::get('/jurnal-penyesuaian/{id}/edit', [Controllers\Report\JurnalPenyesuaianController::class, 'edit'])->name('jurnal-penyesuaian.edit');
    Route::delete('/jurnal-penyesuaian/{id}/hapus', [Controllers\Report\JurnalPenyesuaianController::class, 'hapus'])->name('jurnal-penyesuaian.hapus');
    Route::put('/jurnal-penyesuaian/{id}/update', [Controllers\Report\JurnalPenyesuaianController::class, 'update'])->name('jurnal-penyesuaian.update');
    Route::get('/jurnal-penyesuaian/export', [Controllers\Report\JurnalPenyesuaianController::class, 'export'])->name('jurnal-penyesuaian.export');

    // Piutang & Utang Controller
    Route::get('/piutang', [Controllers\PiutangController::class, 'indeks'])->name('piutang');
    Route::get('/piutang/tambah', [Controllers\PiutangController::class, 'tambah'])->name('piutang.tambah');
    Route::post('/piutang', [Controllers\PiutangController::class, 'simpan'])->name('piutang.simpan');
    Route::get('/piutang/{id}/edit', [Controllers\PiutangController::class, 'edit'])->name('piutang.edit');
    Route::put('/piutang/{id}/update', [Controllers\PiutangController::class, 'update'])->name('piutang.update');
    Route::delete('/piutang/{id}/hapus', [Controllers\PiutangController::class, 'hapus'])->name('piutang.hapus');

    Route::get('/utang', [Controllers\UtangController::class, 'indeks'])->name('utang');
    Route::get('/utang/tambah', [Controllers\UtangController::class, 'tambah'])->name('utang.tambah');
    Route::post('/utang', [Controllers\UtangController::class, 'simpan'])->name('utang.simpan');
    Route::get('/utang/{id}/edit', [Controllers\UtangController::class, 'edit'])->name('utang.edit');
    Route::put('/utang/{id}/update', [Controllers\UtangController::class, 'update'])->name('utang.update');
    Route::delete('/utang/{id}/hapus', [Controllers\UtangController::class, 'hapus'])->name('utang.hapus');

    // Pengeluaran Grosir Controller
    Route::get('/pengeluaran-grosir', [Controllers\PengeluaranGrosirController::class, 'indeks'])->name('pengeluaran-grosir');
    Route::get('/pengeluaran-grosir/tambah', [Controllers\PengeluaranGrosirController::class, 'tambah'])->name('pengeluaran-grosir.tambah');
    Route::get('/pengeluaran-grosir/{id}/edit', [Controllers\PengeluaranGrosirController::class, 'edit'])->name('pengeluaran-grosir.edit');
    Route::post('/pengeluaran-grosir/', [Controllers\PengeluaranGrosirController::class, 'simpan'])->name(name: 'pengeluaran-grosir.simpan');
    Route::delete('/pengeluaran-grosir/{id}/hapus', [Controllers\PengeluaranGrosirController::class, 'hapus'])->name(name: 'pengeluaran-grosir.hapus');
    Route::put('/pengeluaran-grosir/{id}/update', [Controllers\PengeluaranGrosirController::class, 'update'])->name(name: 'pengeluaran-grosir.update');
    Route::post('/pengeluaran-grosir/{id}/approve', [Controllers\PengeluaranGrosirController::class, 'approve'])->name('pengeluaran-grosir.approve');
    Route::post('/pengeluaran-grosir/catatan', [Controllers\PengeluaranGrosirController::class, 'catatan'])->name('pengeluaran-grosir.catatan');
    Route::post('/pengeluaran-grosir/{id}/reject', [Controllers\PengeluaranGrosirController::class, 'reject'])->name('pengeluaran-grosir.reject');

    // Penjualan Controller
    Route::get('/penjualan', [Controllers\PenjualanController::class, 'indeks'])->name('penjualan');
    Route::get('/penjualan/tambah', [Controllers\PenjualanController::class, 'tambah'])->name('penjualan.tambah');
    Route::post('/penjualan', [Controllers\PenjualanController::class, 'simpan']);
    Route::get('/penjualan/{id}/edit', [Controllers\PenjualanController::class, 'edit'])->name('penjualan.edit');
    Route::put('/penjualan/{id}', [Controllers\PenjualanController::class, 'update'])->name('penjualan.update');
    Route::delete('/penjualan/{id}/hapus', [Controllers\PenjualanController::class, 'hapus'])->name('penjualan.hapus');
    Route::post('/penjualan/{id}/approve', [Controllers\PenjualanController::class, 'approve'])->name('penjualan.approve');
    Route::post('/penjualan/{id}/reject', [Controllers\PenjualanController::class, 'reject'])->name('penjualan.reject');
    Route::post('/penjualan/{id}/koreksi', [Controllers\PenjualanController::class, 'koreksi'])->name('penjualan.koreksi');

    // Invoice Controller
    Route::get('/invoice', [Controllers\InvoiceController::class, 'indeks'])->name('invoice');
    Route::get('/invoice/tambah', [Controllers\InvoiceController::class, 'tambah'])->name('invoice.tambah');
    Route::post('/invoice', [Controllers\InvoiceController::class, 'simpan'])->name('invoice.simpan');
    Route::get('/invoice/{id}/detail', [Controllers\InvoiceController::class, 'detail'])->name('invoice.detail');

    // Produk Controller
    Route::get('/produk', [Controllers\ProdukController::class, 'indeks'])->name('produk');
    Route::get('/produk/tambah', [Controllers\ProdukController::class, 'tambah'])->name('produk.tambah');
});