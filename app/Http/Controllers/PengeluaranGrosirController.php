<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\PersetujuanPengeluaranGrosir;

class PengeluaranGrosirController extends Controller
{
    public function indeks()
    {
        $pengeluaran_grosir = PersetujuanPengeluaranGrosir::orderByDesc('created_at')->get();

        return view('dashboard.pages.pengeluaran-grosir.index', [
            'pengeluaran_grosir' => $pengeluaran_grosir
        ]);
    }

    public function tambah()
    {

        return view('dashboard.pages.pengeluaran-grosir.form', [
            'pengeluaran_grosir' => new PersetujuanPengeluaranGrosir(),
            'page_meta' => [
                'title' => 'Pengajuan Pengeluaran Grosir',
                'type' => 'create',
                'method' => 'POST',
                'action' => route('pengeluaran-grosir')
            ]
        ]);
    }

    public function simpan(Request $request)
    {

        $pengeluaran_grosir_data = $request->validate([
            'nominal' => 'required|numeric|min:0',
            'tujuan' => 'required|string|min:3|max:255',
            'sumber_dana' => 'required|string|min:3|max:255',
            'dokumen' => 'nullable|file|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('dokumen')) {
            // File dikirim
            $file = $request->file('dokumen');
            $filename = time() . '.' . $file->extension();
            $file->move(public_path('uploads'), $filename);
        }

        $pengeluaran_grosir_data['dokumen'] = $filename ?? null;

        // Simpan nama file ke database
        PersetujuanPengeluaranGrosir::create($pengeluaran_grosir_data);

        Alert::success('Data pengeluaran grosir berhasil ditambahkan');
        return redirect()->route('pengeluaran-grosir');
    }

    public function edit($id)
    {

        $pengeluaran_grosir = PersetujuanPengeluaranGrosir::findOrFail($id);

        return view('dashboard.pages.pengeluaran-grosir.form', [
            'pengeluaran_grosir' => $pengeluaran_grosir,
            'page_meta' => [
                'title' => 'Pengajuan Pengeluaran Grosir',
                'type' => 'edit',
                'method' => 'PUT',
                'action' => route('pengeluaran-grosir.update', $pengeluaran_grosir->id_persetujuan_pengeluaran_grosir)
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $pengeluaran_grosir = PersetujuanPengeluaranGrosir::findOrFail($id);

        $pengeluaran_grosir_data = $request->validate([
            'nominal' => 'required|numeric|min:0',
            'tujuan' => 'required|string|min:3|max:255',
            'sumber_dana' => 'required|string|min:3|max:255',
            'dokumen' => 'nullable|file|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);

            if ($pengeluaran_grosir->dokumen && file_exists(public_path('uploads/' . $pengeluaran_grosir->dokumen))) {
                unlink(public_path('uploads/' . $pengeluaran_grosir->dokumen));
            }

            $pengeluaran_grosir_data['dokumen'] = $filename;
        }

        $pengeluaran_grosir->update($pengeluaran_grosir_data);

        Alert::success('Data pengeluaran grosir berhasil diubah');
        return redirect()->route('pengeluaran-grosir');
    }

    public function hapus($id) {
        $pengeluaran_grosir = PersetujuanPengeluaranGrosir::where('id_persetujuan_pengeluaran_grosir', $id)->firstOrFail();
        $pengeluaran_grosir->delete();

        Alert::success('Data pengeluaran grosir berhasil dihapus');
        return redirect()->route('pengeluaran-grosir');
    }

    public function catatan(Request $request) {
        $pengeluaran_grosir = PersetujuanPengeluaranGrosir::findOrFail($request->id_pengeluaran_grosir);
        $pengeluaran_grosir->catatan_pemimpin = $request->catatan_pemimpin;
        $pengeluaran_grosir->save();

        Alert::success('Catatan berhasil disimpan');
        return redirect()->route('pengeluaran-grosir');
    }

    public function approve($id)
    {
        $pengeluaran_grosir = PersetujuanPengeluaranGrosir::where('id_persetujuan_pengeluaran_grosir', $id)->firstOrFail();
        $pengeluaran_grosir->update([
            'status_persetujuan' => 1
        ]);
        Alert::success('Data pengeluaran grosir berhasil disetujui');
        return redirect()->route('pengeluaran-grosir');
    }

    public function reject($id)
    {
        $pengeluaran_grosir = PersetujuanPengeluaranGrosir::where('id_persetujuan_pengeluaran_grosir', $id)->firstOrFail();
        $pengeluaran_grosir->update([
            'status_persetujuan' => 2
        ]);
        Alert::success('Data pengeluaran grosir berhasil ditolak');
        return redirect()->route('pengeluaran-grosir');
    }

}
