<?php

namespace App\Http\Controllers;

use App\Models\LabaRugi;
use App\Models\NeracaSaldo;
use App\Models\BukuBesar;
use App\Models\ArusKas;
use App\Models\JurnalUmum;
use App\Models\JurnalTransaksi;
use App\Models\JurnalPenyesuaian;
use App\Models\Ref;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RefController extends Controller
{
    public function indeks()
    {
        $refs = Ref::orderBy('nama_akun', 'asc')->get();

        return view('dashboard.users.finance.ref.index', [
            'refs' => $refs
        ]);
    }

    public function tambah()
    {
        return view('dashboard.users.finance.ref.form', [
            'ref' => new Ref(),
            'page_meta' => [
                    'title' => 'Tambah Ref',
                    'type' => 'create',
                    'method' => 'POST',
                    'action' => route('ref')
                ]
        ]);
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nama_akun' => 'required|unique:nama_akun',
            'kode' => 'required|unique:kode'
        ]);

        Ref::create([
            'nama_akun' => $request->nama_akun,
            'kode' => $request->kode
        ]);

        Alert::success('Sukses', 'Penjualan berhasil ditambahkan!');

        return redirect()->route('ref');
    }

    public function edit(Ref $id)
    {
        return view('dashboard.users.finance.ref.form', [
            'ref' => $id,
            'page_meta' => [
                    'title' => 'Edit Ref',
                    'type' => 'edit',
                    'method' => 'PUT',
                    'action' => route('ref.update', $id)
                ]
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_akun' => 'required|unique:ref,nama_akun,'.$request->nama_akun.',nama_akun',
            'kode' => 'required|unique:ref,kode,'.$request->kode.',kode'
        ]);

        $ref = Ref::where('id_ref', $id)->firstOrFail();

        if ($ref->count() == 0) {
            Alert::error('Gagal', 'Data tidak ditemukan');
        } else {

            if ($request->nama_akun == $ref->nama_akun && $request->kode == $ref->kode) 
            {
                Alert::warning('Tidak Ada Perubahan');
                return redirect()->back();
            }

            // Update id_ref di semua tabel

            $laba_rugi = LabaRugi::where('id_ref', $ref->id_ref)->first();
            if ($laba_rugi) 
            {
                $laba_rugi->update([
                    'id_ref' => $id,
                    'nama_akun' => $request->nama_akun
                ]);
            }

            $neraca_saldo = NeracaSaldo::where('id_ref', $ref->id_ref)->first();
            if ($neraca_saldo) 
            {
                $neraca_saldo->update([
                    'id_ref' => $id,
                    'nama_akun' => $request->nama_akun
                ]);
            }

            $arus_kas = ArusKas::where('id_ref', $ref->id_ref)->first();
            if ($arus_kas) 
            {
                $arus_kas->update([
                    'id_ref' => $id,
                    'nama_akun' => $request->nama_akun
                ]);
            }

            $jurnal_transaksi = JurnalTransaksi::where('id_ref', $ref->id_ref)->first();
            if ($jurnal_transaksi) 
            {
                $jurnal_transaksi->update([
                    'id_ref' => $id,
                    'nama_akun' => $request->nama_akun
                ]);
            }

            $jurnal_umum = JurnalUmum::where('id_ref', $ref->id_ref)->first();
            if ($jurnal_umum) 
            {
                $jurnal_umum->update([
                    'id_ref' => $id,
                    'nama_akun' => $request->nama_akun
                ]);
            }

            $jurnal_penyesuaian = JurnalPenyesuaian::where('id_ref', $ref->id_ref)->first();
            if ($jurnal_penyesuaian) 
            {
                $jurnal_penyesuaian->update([
                    'id_ref' => $id,
                    'nama_akun' => $request->nama_akun
                ]);
            }

            $buku_besar = BukuBesar::where('id_ref', $ref->id_ref)->first();
            if ($buku_besar) 
            {
                $buku_besar->update([
                    'id_ref' => $id
                ]);
            }

            Ref::where('id_ref', $id)->update([
                'nama_akun' => $request->nama_akun,
                'kode' => $request->kode
            ]);

            Alert::success('Sukses', 'Data berhasil diupdate');
        }

        return redirect()->back();
    }

    public function hapus($id)
    {
        $ref = Ref::where('id_ref', $id)->firstOrFail();
        if ($ref->count() == 0) {

            Alert::error('Gagal', 'Data tidak ditemukan');

        } else {

            $is_used_in_laba_rugi = LabaRugi::where('id_ref', $ref->id_ref)->first();
            $is_used_in_neraca_saldo = NeracaSaldo::where('id_ref', $ref->id_ref)->first();
            $is_used_in_arus_kas = ArusKas::where('id_ref', $ref->id_ref)->first();
            $is_used_in_jurnal_transaksi = JurnalTransaksi::where('id_ref', $ref->id_ref)->first();
            $is_used_in_jurnal_umum = JurnalUmum::where('id_ref', $ref->id_ref)->first();
            $is_used_in_jurnal_penyesuaian = JurnalPenyesuaian::where('id_ref', $ref->id_ref)->first();
            $is_used_in_buku_besar = BukuBesar::where('id_ref', $ref->id_ref)->first();
            
            if ($is_used_in_laba_rugi || $is_used_in_neraca_saldo || $is_used_in_arus_kas || $is_used_in_jurnal_transaksi || $is_used_in_jurnal_umum || $is_used_in_jurnal_penyesuaian || $is_used_in_buku_besar) {
                Alert::error('Gagal', 'Data tidak dapat dihapus karena sedang digunakan');
                return redirect()->back();
            } else {
                $ref->delete();
                Alert::success('Sukses', 'Data berhasil dihapus');
            }
        }

        return redirect()->back();
    }
}
