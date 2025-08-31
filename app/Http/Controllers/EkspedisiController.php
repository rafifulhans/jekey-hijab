<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekspedisi;
use RealRashid\SweetAlert\Facades\Alert;

class EkspedisiController extends Controller
{
    public function indeks()
    {
        $ekspedisis = Ekspedisi::orderBy('nama', 'asc')->get();
        return view('dashboard.users.sales.ekspedisi.index', [
            'ekspedisis' => $ekspedisis
        ]);
    }

    public function tambah()
    {
        return view('dashboard.users.sales.ekspedisi.form', [
            'ekspedisi' => new Ekspedisi(),
            'page_meta' => [
                'title' => 'Tambah Ekspedisi',
                'type' => 'create',
                'method' => 'POST',
                'action' => route('ekspedisi.simpan')
            ]
        ]);
    }

    public function edit($id) 
    {
        return view('dashboard.users.sales.ekspedisi.form', [
            'ekspedisi' => Ekspedisi::find($id),
            'page_meta' => [
                'title' => 'Edit Ekspedisi',
                'type' => 'edit',
                'method' => 'PUT',
                'action' => route('ekspedisi.update', $id)
            ]
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'nama' => 'required|string|max:255|unique:ekspedisi,nama'
        ]);

        Ekspedisi::create([
            'nama' => request()->input('nama')
        ]);

        Alert::success('Sukses', 'Ekspedisi berhasil ditambahkan!');

        return redirect()->route('ekspedisi');
    }

    public function update(Request $request, $id) 
    {
        request()->validate([
            'nama' => 'required|string|max:255|unique:ekspedisi,nama,' . $id .',id_ekspedisi' 
        ]);

        $ekspedisi = Ekspedisi::where('id_ekspedisi', request()->id);

        if ($ekspedisi->count() == 0) {
            Alert::warning('Gagal', 'Ekspedisi tidak ditemukan');
        } else {
            Ekspedisi::where('id_ekspedisi', request()->id)->update([
                'nama' => $request->input('nama')
            ]); 

            Alert::success('Berhasil', 'Ekspedisi berhasil diubah');
        }

        return redirect()->back();
    }

    public function hapus($id) 
    {
        $ekspedisi = Ekspedisi::where('id_ekspedisi', $id);

        if ($ekspedisi->count() == 0) {
            Alert::warning('Gagal', 'EKspedisi tidak ditemukan');
        } else {
            $ekspedisi->delete();
            Alert::success('Sukses', 'Ekspedisi berhasil dihapus!');
        }

        return redirect()->route('ekspedisi');
    }
}
