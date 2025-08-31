<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodePembayaran;
use RealRashid\SweetAlert\Facades\Alert;

class MetodePembayaranController extends Controller
{
    public function indeks()
    {
        $metode_pembayaran = MetodePembayaran::orderBy('nama', 'asc')->get();
        return view('dashboard.users.sales.metode-pembayaran.index', [
            'metode_pembayaran' => $metode_pembayaran
        ]);
    }

    public function tambah()
    {
        return view('dashboard.users.sales.metode-pembayaran.form', [
            'metode'    => new MetodePembayaran(),
            'page_meta' => [
                    'title' => 'Tambah Metode Pembayaran',
                    'type' => 'create',
                    'method' => 'POST',
                    'action' => route('metode-pembayaran.simpan')
                ]
        ]);
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:metode_pembayaran,nama'
        ]);

        MetodePembayaran::create([
            'nama' => $request->nama
        ]);

        Alert::success('Berhasil', 'Metode pembayaran berhasil ditambahkan');

        return redirect()->route('metode-pembayaran');
    }

    public function edit($id)
    {
        return view('dashboard.users.sales.metode-pembayaran.form', [
            'metode'    => MetodePembayaran::find($id),
            'page_meta' => [
                'title' => 'Edit Metode Pembayaran',
                'action' => route('metode-pembayaran.update', $id),
                'method' => 'PUT',
                'type' => 'edit'
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:metode_pembayaran,nama,' . $id .',id_metode_pembayaran'
        ]);

        $metode = MetodePembayaran::where('id_metode_pembayaran', $id)->first();
        if ($metode->count() == 0) {
            Alert::error('Gagal', 'Data tidak ditemukan');
        } else {

            MetodePembayaran::where('id_metode_pembayaran', $id)->update([
                'nama' => $request->input('nama')
            ]);

            Alert::success('Berhasil', 'Metode pembayaran berhasil diubah');
        }

        return redirect()->back();
    }

    public function hapus($id)
    {
        $metode = MetodePembayaran::where('id_metode_pembayaran', $id)->firstOrFail();
        if ($metode->count() == 0) {

            Alert::warning('Gagal', 'Data tidak ditemukan');

        } else {

            $metode->delete();
            Alert::success('Sukses', 'Data berhasil dihapus');
        }

        return redirect()->back();
    }
}
