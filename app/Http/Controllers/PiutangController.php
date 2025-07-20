<?php

namespace App\Http\Controllers;

use App\Models\ArusKas;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Piutang;

class PiutangController extends Controller
{
    public function indeks()
    {
        $piutang = Piutang::orderByDesc('created_at')->get();

        foreach ($piutang as $piu) 
            $piu['status_pembayaran'] = $piu->status == 0 ? 'Belum Lunas' : 'Lunas';

        return view('dashboard.pages.piutang.index', [
            'piutang' => $piutang
        ]);
    }

    public function tambah()
    {
        return view('dashboard.pages.piutang.form', [
            'piutang' => new Piutang(),
            'page_meta' => [
                'title' => 'TambahPiutang',
                'type' => 'create',
                'method' => 'POST',
                'action' => route('piutang')
            ]
        ]);
    }

    public function simpan(Request $request)
    {
        $piutang_data = $request->validate([
            'nama_pelanggan' => 'required|string|min:3|max:255',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'jatuh_tempo' => 'required|date',
            'status' => 'in:0,1'
        ]);

        $last = Piutang::orderByDesc('id_piutang')->first();
        if ($last && preg_match('/PIU-(\d+)/', $last->kode, $match)) {
            $nextNumber = intval($match[1]) + 1;
        } else {
            $nextNumber = 1;
        }
        $piutang_data['kode'] = 'PIU-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Piutang::create($piutang_data);

        Alert::success('Data piutang berhasil ditambahkan!');

        return redirect()->route('piutang')->with('success', 'Data piutang berhasil ditambahkan!');
    }

    public function edit($id) {

        $piutang = Piutang::where('id_piutang', $id)->firstOrFail();

        return view('dashboard.pages.piutang.form', [
            'piutang' => $piutang,
            'page_meta' => [
                'title' => 'Edit Piutang',
                'type' => 'edit',
                'method' => 'PUT',
                'action' => route('piutang.update', $piutang->id_piutang)
            ]
        ]);
    }

    public function update(Request $request, $id) {
        
        $piutang = Piutang::where('id_piutang', $id)->firstOrFail();

        $piutang_data = $request->validate([
            'nama_pelanggan'=> 'required|string|min:3|max:255',
            'jumlah'=> 'required|numeric|min:0',
            'tanggal'=> 'required|date',
            'jatuh_tempo'=> 'required|date',
            'status' => 'in:0,1'
        ]);

        Piutang::where('id_piutang', $id)->update($piutang_data);

        Alert::success('Data piutang berhasil diubah!');
        return redirect()->route('piutang');
    }

    public function hapus($id) {
        $piutang = Piutang::where('id_piutang', $id)->firstOrFail();
        $piutang->delete();

        Alert::success('Data piutang berhasil dihapus!');
        return redirect()->route('piutang');
    }

}
