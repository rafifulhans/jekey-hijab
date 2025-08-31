<?php

namespace App\Http\Controllers;

use App\Models\Marketplace;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MarketplaceController extends Controller
{
    public function indeks()
    {
        $marketplaces = Marketplace::orderBy('nama', 'asc')->get();
        return view('dashboard.users.sales.marketplace.index', [
            'marketplaces' => $marketplaces
        ]);
    }

    public function tambah()
    {
        return view('dashboard.users.sales.marketplace.form', [
            'marketplace' => new Marketplace(),
            'page_meta' => [
                'title' => 'Tambah Marketplace',
                'type' => 'create',
                'method' => 'POST',
                'action' => route('marketplace.simpan')
            ]
        ]);
    }

    public function edit($id) 
    {
        return view('dashboard.users.sales.marketplace.form', [
            'marketplace' => Marketplace::find($id),
            'page_meta' => [
                'title' => 'Edit Marketplace',
                'type' => 'edit',
                'method' => 'PUT',
                'action' => route('marketplace.update', $id)
            ]
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'nama' => 'required|string|max:255|unique:marketplace,nama'
        ]);

        Marketplace::create([
            'nama' => request()->input('nama')
        ]);

        Alert::success('Sukses', 'Marketplace berhasil ditambahkan!');

        return redirect()->route('marketplace');
    }

    public function update(Request $request, $id) 
    {
        request()->validate([
            'nama' => 'required|string|max:255|unique:marketplace,nama,' . $id .',id_marketplace' 
        ]);

        $marketplace = Marketplace::where('id_marketplace', request()->id);

        if ($marketplace->count() == 0) {
            Alert::warning('Gagal', 'Data tidak ditemukan');
        } else {
            Marketplace::where('id_marketplace', request()->id)->update([
                'nama' => $request->input('nama')
            ]); 

            Alert::success('Berhasil', 'Marketplace berhasil diubah');
        }

        return redirect()->back();
    }

    public function hapus($id) 
    {
        $marketplace = Marketplace::where('id_marketplace', $id);

        if ($marketplace->count() == 0) {
            Alert::warning('Gagal', 'Data tidak ditemukan');
        } else {
            $marketplace->delete();
            Alert::success('Sukses', 'Marketplace berhasil dihapus!');
        }

        return redirect()->route('marketplace');
    }
}
