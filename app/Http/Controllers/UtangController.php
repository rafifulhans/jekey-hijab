<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Utang;

class UtangController extends Controller
{
    public function indeks()
    {
        $utang = Utang::orderByDesc('created_at')->get();

        foreach ($utang as $piu) 
            $piu['status_pembayaran'] = $piu->status == 0 ? 'Belum Lunas' : 'Lunas';

        return view('dashboard.pages.utang.index', [
            'utang' => $utang
        ]);
    }

    public function tambah()
    {
        return view('dashboard.pages.utang.form', [
            'utang' => new Utang(),
            'page_meta' => [
                'title' => 'Tambah Utang',
                'type' => 'create',
                'method' => 'POST',
                'action' => route('utang')
            ]
        ]);
    }

    public function simpan(Request $request)
    {
        $utang_data = $request->validate([
            'nama_pemasok' => 'required|string|min:3|max:255',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'jatuh_tempo' => 'required|date',
            'status' => 'in:0,1'
        ]);

        $last = Utang::orderByDesc('id_utang')->first();
        if ($last && preg_match('/UTG-(\d+)/', $last->kode, $match)) {
            $nextNumber = intval($match[1]) + 1;
        } else {
            $nextNumber = 1;
        }
        $utang_data['kode'] = 'UTG-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Utang::create($utang_data);

        Alert::success('Data utang berhasil ditambahkan!');

        return redirect()->route('utang');
    }

    public function edit($id) {

        $utang = Utang::where('id_utang', $id)->firstOrFail();

        return view('dashboard.pages.utang.form', [
            'utang' => $utang,
            'page_meta' => [
                'title' => 'Edit utang',
                'type' => 'edit',
                'method' => 'PUT',
                'action' => route('utang.update', $utang->id_utang)
            ]
        ]);
    }

    public function update(Request $request, $id) {
        
        $utang = Utang::where('id_utang', $id)->firstOrFail();

        $utang_data = $request->validate([
            'nama_pemasok'=> 'required|string|min:3|max:255',
            'jumlah'=> 'required|numeric|min:0',
            'tanggal'=> 'required|date',
            'jatuh_tempo'=> 'required|date',
            'status' => 'in:0,1'
        ]);

        Utang::where('id_utang', $id)->update($utang_data);

        Alert::success('Data utang berhasil diubah!');
        return redirect()->route('utang');
    }

    public function hapus($id) {
        $utang = Utang::where('id_utang', $id)->firstOrFail();
        $utang->delete();

        Alert::success('Data utang berhasil dihapus!');
        return redirect()->route('utang');
    }

}
