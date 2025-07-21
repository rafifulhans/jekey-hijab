<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Number;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;

use App\Models\Penjualan;
use App\Models\Marketplace;
use App\Models\Ekspedisi;
use App\Models\MetodePembayaran;
use App\Models\Produk;

class PenjualanController extends Controller
{
    public function indeks()
    {
        $penjualans = Penjualan::all();

        foreach ($penjualans as $penjualan_key => $penjualan) {
            $penjualans[$penjualan_key]->ongkir = Number::currency($penjualans[$penjualan_key]->ongkir, 'IDR', 'id_ID');
            $penjualans[$penjualan_key]->subtotal = Number::currency($penjualans[$penjualan_key]->subtotal, 'IDR', 'id_ID');
            $penjualans[$penjualan_key]->diskon = Number::currency($penjualans[$penjualan_key]->diskon, 'IDR', 'id_ID');
            $penjualans[$penjualan_key]->total = Number::currency($penjualans[$penjualan_key]->total, 'IDR', 'id_ID');
        }

        return view('dashboard.pages.penjualan.index', [
            'penjualans' => $penjualans
        ]);
    }

    public function tambah()
    {
        $marketplaces = Marketplace::all();
        $ekspedisis = Ekspedisi::all();
        $metodes = MetodePembayaran::all();
        $produks = Produk::all();

        return view('dashboard.pages.penjualan.form', [
            'marketplaces' => $marketplaces,
            'ekspedisis' => $ekspedisis,
            'metodes' => $metodes,
            'produks' => $produks,
            'penjualan' => new Penjualan(),
            'page_meta' => [
                    'title' => 'Penjualan',
                    'type' => 'create',
                    'method' => 'POST',
                    'action' => route('penjualan')
                ]
        ]);
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'marketplace' => 'required|exists:marketplace,id_marketplace',
            'no_resi' => 'required|string|max:50',
            'no_telp_pembeli' => 'required|numeric',
            'ekspedisi' => 'required|exists:ekspedisi,id_ekspedisi',
            'produk' => 'required|exists:marketplace,id_marketplace',
            'varian' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'ongkir' => 'nullable|numeric|min:0',
            'alamat_pembeli' => 'required|string|max:500',
            'email_pembeli' => 'required|email|max:255',
            'status_order' => ['required', Rule::in(array_keys(config('status.order')))],
            'status_pembayaran' => ['required', Rule::in(array_keys(config('status.pembayaran')))],
            'metode_pembayaran' => 'required|exists:metode_pembayaran,id_metode_pembayaran',
            'tanggal_pembayaran' => 'required|date'
        ]);

        $penjualan_data = [
            'id_marketplace' => $request->input('marketplace'),
            'id_ekspedisi' => $request->input('ekspedisi'),
            'id_metode_pembayaran' => $request->input('metode_pembayaran'),
            'id_produk' => $request->input('produk'),
            'nama_marketplace' => Marketplace::with('penjualan')->where('id_marketplace', $request->input('marketplace'))->first()->nama,
            'nama_ekspedisi' => Ekspedisi::with('penjualan')->where('id_ekspedisi', $request->input('ekspedisi'))->first()->nama,
            'nomor_resi' => $request->input('no_resi'),
            'nama_produk' => Produk::with('penjualan')->where('id_produk', $request->input('produk'))->first()->nama,
            'nama_varian' => $request->input('varian'),
            'qty' => $request->input('qty'),
            'subtotal' => $request->input('subtotal'),
            'diskon' => $request->input('diskon'),
            'ongkir' => $request->input('ongkir'),
            'total' => ($request->input('subtotal') * $request->input('qty')) + $request->input('ongkir') - $request->input('diskon'),
            'alamat_pembeli' => $request->input('alamat_pembeli'),
            'email_pembeli' => $request->input('email_pembeli'),
            'nomor_telepon_pembeli' => $request->input('no_telp_pembeli'),
            'status_order' => $request->input('status_order'),
            'status_pembayaran' => $request->input('status_pembayaran'),
            'metode_pembayaran' => MetodePembayaran::with('penjualan')->where('id_metode_pembayaran', $request->input('metode_pembayaran'))->first()->nama,
            'tanggal_pembayaran' => $request->input('tanggal_pembayaran')
        ];

        Penjualan::create($penjualan_data);

        Alert::success('Sukses', 'Penjualan berhasil ditambahkan!');

        return redirect()->route('penjualan');
    }

    public function edit($id)
    {
        $penjualan = Penjualan::where('id_penjualan', $id)->firstOrFail();
        $marketplaces = Marketplace::all();
        $ekspedisis = Ekspedisi::all();
        $metodes = MetodePembayaran::all();
        $produks = Produk::all();

        return view('dashboard.pages.penjualan.form', [
            'penjualan' => $penjualan,
            'marketplaces' => $marketplaces,
            'ekspedisis' => $ekspedisis,
            'metodes' => $metodes,
            'produks' => $produks,
            'page_meta' => [
                    'title' => 'Edit Penjualan',
                    'type' => 'edit',
                    'method' => 'PUT',
                    'action' => route('penjualan.update', $id)
                ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'marketplace' => 'required|exists:marketplace,id_marketplace',
            'no_resi' => 'required|string|max:50',
            'ekspedisi' => 'required|exists:ekspedisi,id_ekspedisi',
            'produk' => 'required|exists:marketplace,id_marketplace',
            'varian' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'ongkir' => 'nullable|numeric|min:0',
            'alamat_pembeli' => 'required|string|max:500',
            'no_telp_pembeli' => 'required|numeric',
            'email_pembeli' => 'required|email|max:255',
            'status_order' => ['required', Rule::in(array_keys(config('status.order')))],
            'status_pembayaran' => ['required', Rule::in(array_keys(config('status.pembayaran')))],
            'metode_pembayaran' => 'required|exists:metode_pembayaran,id_metode_pembayaran',
            'tanggal_pembayaran' => 'required|date'
        ]);

        $penjualan = Penjualan::where('id_penjualan', $id)->update([
            'id_marketplace' => $request->input('marketplace'),
            'id_ekspedisi' => $request->input('ekspedisi'),
            'id_metode_pembayaran' => $request->input('metode_pembayaran'),
            'id_produk' => $request->input('produk'),
            'nama_marketplace' => Marketplace::with('penjualan')->where('id_marketplace', $request->input('marketplace'))->first()->nama,
            'nama_ekspedisi' => Ekspedisi::with('penjualan')->where('id_ekspedisi', $request->input('ekspedisi'))->first()->nama,
            'nomor_resi' => $request->input('no_resi'),
            'nama_produk' => Produk::with('penjualan')->where('id_produk', $request->input('produk'))->first()->nama,
            'nama_varian' => $request->input('varian'),
            'qty' => $request->input('qty'),
            'subtotal' => $request->input('subtotal'),
            'diskon' => $request->input('diskon'),
            'ongkir' => $request->input('ongkir'),
            'total' => ($request->input('subtotal') * $request->input('qty')) + $request->input('ongkir') - $request->input('diskon'),
            'alamat_pembeli' => $request->input('alamat_pembeli'),
            'email_pembeli' => $request->input('email_pembeli'),
            'nomor_telepon_pembeli' => $request->input('no_telp_pembeli'),
            'status_order' => $request->input('status_order'),
            'status_pembayaran' => $request->input('status_pembayaran'),
            'metode_pembayaran' => MetodePembayaran::with('penjualan')->where('id_metode_pembayaran', $request->input('metode_pembayaran'))->first()->nama,
            'tanggal_pembayaran' => $request->input('tanggal_pembayaran'),
            'status_persetujuan' => 0
        ]);

        Alert::success('Sukses', 'Penjualan berhasil diperbarui!');

        return redirect()->route('penjualan');
    }

    public function hapus(Request $request, $id)
    {
        $penjualan = Penjualan::where('id_penjualan', $id)->firstOrFail();
        $penjualan->delete();

        Alert::success('Sukses', 'Penjualan berhasil dihapus!');

        return redirect()->route('penjualan');
    }

    public function approve(Request $request, $id) 
    {
        Penjualan::where('id_penjualan', $id)->update(['status_persetujuan' => 1]);

        Alert::success('Sukses', 'Penjualan berhasil disetujui!');

        return redirect()->route('penjualan');
    }

    public function koreksi(Request $request, $id) 
    {
        $penjualan = Penjualan::where('id_penjualan', $id)->update(['status_persetujuan' => 2]);

        Alert::success('Sukses', 'Penjualan berhasil dikirim untuk dikoreksi!');

        return redirect()->route('penjualan');
    }

    public function reject(Request $request, $id) 
    {
        Penjualan::where('id_penjualan', $id)->update(['status_persetujuan' => 3]);

        Alert::success('Sukses', 'Penjualan berhasil ditolak!');

        return redirect()->route('penjualan');
    }
}
