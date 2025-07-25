<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\NeracaSaldo;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;


use App\Models\JurnalPenyesuaian;
use App\Models\Ref;
use App\Models\LabaRugi;
use App\Models\JurnalTransaksi;

class JurnalPenyesuaianController extends Controller
{

    public function indeks()
    {
        $jurnal_transaksi = JurnalTransaksi::first();
        $jurnal_penyesuaian_all = JurnalPenyesuaian::orderBy('created_at', 'asc')->get();

        $jurnal_penyesuaian = [];
        foreach ($jurnal_penyesuaian_all as $jup) {
            $jurnal_penyesuaian[date('d / m / Y', strtotime($jup->tanggal))][] = $jup;
        }

        return view('dashboard.pages.report.jurnal-penyesuaian.index', [
            'jurnal_penyesuaian' => $jurnal_penyesuaian,
            'jurnal_transaksi' => $jurnal_transaksi
        ]);
    }

    public function tambah()
    {
        $jurnal_transaksi = JurnalTransaksi::first();
        if (empty($jurnal_transaksi)) 
        {
            Alert::warning('Maaf', 'Jurnal transaksi perlu di buat terlebih dahulu!');
            return redirect()->route('jurnal-penyesuaian');
        }

        return view('dashboard.pages.report.jurnal-penyesuaian.form', [
            'jurnal_penyesuaian' => new JurnalPenyesuaian(),
            'refs' => Ref::all(),
            'page_meta' => [
                'title' => 'Buat Jurnal Penyesuaian',
                'type' => 'create',
                'method' => 'POST',
                'action' => route('jurnal-penyesuaian')
            ]
        ]);
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|min:3|max:255',
            'total' => 'required|numeric|min:0',
            'ref' => 'required|exists:ref,id_ref',
            'type' => 'required|in:1,2'
        ]);

        $jurnal_transaksi = JurnalTransaksi::first();
        if (empty($jurnal_transaksi)) 
        {
            Alert::warning('Maaf', 'Jurnal transaksi perlu di buat terlebih dahulu!');
            return redirect()->route('jurnal-penyesuaian');
        }

        JurnalPenyesuaian::create([
            'tanggal' => $request->input('tanggal'),
            'keterangan' => $request->input('keterangan'),
            'total' => $request->input('total'),
            'id_ref' => $request->input('ref'),
            'type' => $request->input('type'),
            'nama_akun' => Ref::with('jurnalPenyesuaian')->where('id_ref', $request->input('ref'))->first()->nama_akun
        ]);

        $q_update_neraca = [];

        $neraca = NeracaSaldo::where('id_ref', $request->input('ref'))->first();

        if (!empty($neraca)) {
            switch ($request->input('type')) {
                case 1:
                    $debit_sum = $request->input('total') - $neraca->debit;
                    $q_update_neraca['debit'] = $neraca->debit + $debit_sum;
                    break;
                case 2:
                    $kredit_sum = $request->input('total') - $neraca->kredit;
                    $q_update_neraca['kredit'] = $neraca->kredit + $kredit_sum;
                    break;
            }
         
            NeracaSaldo::where('id_neraca_saldo', $neraca->id_neraca_saldo)->update($q_update_neraca);
        }

        $laba_rugi = LabaRugi::where([
            'id_ref' => $request->input('ref'),
            'type' => $request->input('type'),
            'tanggal' => $request->input('tanggal')
        ])->first();

        if (!empty($laba_rugi)) {
            $total_sum = $request->input('total') - ($laba_rugi->total ?? 0);

            LabaRugi::where('id_laba_rugi', $laba_rugi->id_laba_rugi)->update([
                'total' => $laba_rugi->total + $total_sum
            ]);
        }

        Alert::success('Berhasil', 'Jurnal Penyesuaian Berhasil Ditambahkan');
        return redirect()->route('jurnal-penyesuaian');
    }

    public function edit($id)
    {
        return view('dashboard.pages.report.jurnal-penyesuaian.form', [
            'jurnal_penyesuaian' => JurnalPenyesuaian::where('id_jurnal_penyesuaian', $id)->first(),
            'refs' => Ref::all(),
            'page_meta' => [
                    'title' => 'Edit Jurnal Penyesuaian',
                    'type' => 'edit',
                    'method' => 'PUT',
                    'action' => route('jurnal-penyesuaian.update', $id)
                ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string|min:3|max:255',
            'total' => 'required|numeric|min:0',
        ]);

        $jurnal_transaksi = JurnalTransaksi::first();
        if (empty($jurnal_transaksi)) 
        {
            Alert::warning('Maaf', 'Jurnal transaksi perlu di buat terlebih dahulu!');
            return redirect()->route('jurnal-penyesuaian');
        }

        $jurnal_penyesuaian = JurnalPenyesuaian::where('id_jurnal_penyesuaian', $id)->first();

        JurnalPenyesuaian::where('id_jurnal_penyesuaian', $id)->update([
            'keterangan' => $request->input('keterangan'),
            'total' => $request->input('total'),
        ]);

        $neraca = NeracaSaldo::where('id_ref', $request->input('ref'))->first();

        if (!empty($neraca)) {
            $q_update_neraca = [];

            switch ($request->input('type')) {
                case 1:
                    $debit_sum = $request->input('total') - $neraca->debit;
                    $q_update_neraca['debit'] = $neraca->debit + $debit_sum;
                    break;
                case 2:
                    $kredit_sum = $request->input('total') - $neraca->kredit;
                    $q_update_neraca['kredit'] = $neraca->kredit + $kredit_sum;
                    break;
            }

            NeracaSaldo::where('id_ref', $request->input('ref'))->update($q_update_neraca);
        }

        $laba_rugi = LabaRugi::where([
            'id_ref' => $jurnal_penyesuaian->id_ref,
            'type' => $jurnal_penyesuaian->type,
            'tanggal' => $jurnal_penyesuaian->tanggal,
        ])->first();

        if (!empty($laba_rugi)) {
            
            $total_sum = $request->input('total') - $laba_rugi->total;

            LabaRugi::where('id_laba_rugi', $laba_rugi->id_laba_rugi)->update([
                'total' => $laba_rugi->total + $total_sum
            ]);
        }

        Alert::success('Berhasil', 'Jurnal Penyesuaian Berhasil Diubah');
        return redirect()->route('jurnal-penyesuaian');
    }

    public function hapus($id)
    {
        JurnalPenyesuaian::where('id_jurnal_penyesuaian', $id)->delete();

        Alert::success('Berhasil', 'Jurnal Penyesuaian Berhasil Dihapus');
        return redirect()->route('jurnal-penyesuaian');
    }

    public function export()
    {
        $jurnal_penyesuaian_all = JurnalPenyesuaian::orderBy('created_at', 'asc')->get();

        // Ambil tanggal paling awal & akhir
        $first = $jurnal_penyesuaian_all->first();
        $last = $jurnal_penyesuaian_all->last();

        if (!empty($first) && !empty($last)) 
        {
            if ($first->tanggal == $last->tanggal) {
                $periode = \Carbon\Carbon::parse($first->tanggal)->translatedFormat('j F Y');
            } else {

                if (date('m-Y', strtotime($first->tanggal)) == date('m-Y', strtotime($last->tanggal)) &&
                    date('d', strtotime($first->tanggal)) != date('d', strtotime($last->tanggal))) 
                {
                    $periode = \Carbon\Carbon::parse($first->tanggal)->translatedFormat('j ') . ' - ' . \Carbon\Carbon::parse($last->tanggal)->translatedFormat('j') .' ' .\Carbon\Carbon::parse($first->tanggal)->translatedFormat('F Y');
                } else {
                    $periode = \Carbon\Carbon::parse($first->tanggal)->translatedFormat('j F Y') . ' - ' . \Carbon\Carbon::parse($last->tanggal)->translatedFormat('j F Y');
                }
            }
        } else if(!empty($first) && empty($last)) {
            $periode = \Carbon\Carbon::parse($first->tanggal)->translatedFormat('j F Y');
        } else {
            $periode = \Carbon\Carbon::parse($last->tanggal)->translatedFormat('j F Y');
        }

        $filename = "Jurnal Penyesuaian ({$periode}).pdf";

        $jurnal_penyesuaian = [];
        foreach ($jurnal_penyesuaian_all as $jup) {
            $jurnal_penyesuaian[date('d/m/Y', strtotime($jup->tanggal))][] = $jup;
        }

        $pdf = Pdf::loadView('dashboard.pages.report.jurnal-penyesuaian.export', [
            'jurnal_penyesuaian' => $jurnal_penyesuaian,
            'title' => $filename,
            'periode' => $periode
        ]);
        return $pdf->download($filename);
    }
}
