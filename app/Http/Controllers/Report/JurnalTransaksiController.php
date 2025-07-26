<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Ref;
use App\Models\JurnalTransaksi;
use App\Models\JurnalUmum;
use App\Models\BukuBesar;
use App\Models\NeracaSaldo;
use App\Models\LabaRugi;
use App\Models\ArusKas;

use Barryvdh\DomPDF\Facade\Pdf;

class JurnalTransaksiController extends Controller
{
    public function indeks()
    {
        if (!empty($_POST['date-filter']) || !empty(session()->get('date-filter'))) 
        {
            if (!empty($_POST['date-filter'])) 
            {
                $date = explode(' - ', $_POST['date-filter']);
                $date_start = date('Y-m-d', strtotime($date[0]));
                $date_end = date('Y-m-d', strtotime($date[1]));

                session()->put('date-filter', [
                    'start' => $date_start,
                    'end' => $date_end
                ]);

            } else if (!empty(session()->get('date-filter'))) {
                $date = session()->get('date-filter');
                $date_start = $date['start'];
                $date_end = $date['end'];
            }
            
            $jurnal_transaksi = JurnalTransaksi::whereBetween('tanggal', [$date_start, $date_end])->orderBy('tanggal', 'asc')->orderBy('created_at', 'asc')->get();

        } else {
            $jurnal_transaksi = JurnalTransaksi::orderBy('tanggal', 'asc')->orderBy('created_at', 'asc')->get();
        }

        $jurnal_transaksi->map(function ($jurnal_transaksi) {
            $jurnal_transaksi->kode = Ref::where('id_ref', $jurnal_transaksi->id_ref)->first()->kode;
        });

        return view('dashboard.pages.report.jurnal-transaksi.index', [
            'jurnal_transaksi' => $jurnal_transaksi,
            'date_filter' => date('m-d-Y', strtotime($date_start ?? 'now')) . ' - ' . date('m-d-Y', strtotime($date_end ?? 'now'))
        ]);
    }

    public function tambah()
    {
        $refs = Ref::all();
        return view('dashboard.pages.report.jurnal-transaksi.form', [
            'refs' => $refs,
            'jurnal_transaksi' => new JurnalTransaksi(),
            'page_meta' => [
                'title' => 'Buat Jurnal Transaksi',
                'action' => route('jurnal-transaksi.simpan'),
                'method' => 'POST',
                'type' => 'create'
            ]
        ]);
    }

    public function sync_report($ref)
    {
        $jurnal_umum = JurnalUmum::where([
            'id_ref' => $ref['id_ref'],
            'tanggal' => $ref['tanggal'],
            'type' => $ref['type'],
        ])->first();

        if (!empty($jurnal_umum)) {
            JurnalUmum::where('id_jurnal_umum', $jurnal_umum->id_jurnal_umum)->update([
                'total' => $jurnal_umum->total + $ref['total']
            ]);
        } else {

            JurnalUmum::create($ref);
        }

        $buku_besar = BukuBesar::where([
            'id_ref' => $ref['id_ref'],
            'tanggal' => $ref['tanggal']
        ])->first();

        if (!empty($buku_besar)) {
            switch ($ref['type']) {
                case 1:
                    $update_bukbes = [
                        'debit' => $buku_besar->debit + $ref['total']
                    ];
                    break;
                case 2:
                    $update_bukbes = [
                        'kredit' => $buku_besar->kredit + $ref['total']
                    ];
                    break;
            }

            BukuBesar::where('id_buku_besar', $buku_besar->id_buku_besar)->update($update_bukbes);

        } else {

            $create_bukbes = [
                'id_ref' => $ref['id_ref'],
                'tanggal' => $ref['tanggal'],
                'debit' => 0,
                'kredit' => 0
            ];

            switch ($ref['type']) {
                case 1:
                    $create_bukbes['debit'] = $ref['total'];
                    break;
                case 2:
                    $create_bukbes['kredit'] = $ref['total'];
                    break;
            }

            BukuBesar::create($create_bukbes);
        }

        $neraca_saldo = NeracaSaldo::where([
            'id_ref' => $ref['id_ref']
        ])->first();

        if (!empty($neraca_saldo)) {
            switch ($ref['type']) {
                case 1:
                    $update_neraca_saldo = [
                        'debit' => $neraca_saldo->debit + $ref['total']
                    ];
                    break;
                case 2:
                    $update_neraca_saldo = [
                        'kredit' => $neraca_saldo->kredit + $ref['total']
                    ];
                    break;
            }

            NeracaSaldo::where('id_neraca_saldo', $neraca_saldo->id_neraca_saldo)->update($update_neraca_saldo);

        } else {

            $create_neraca_saldo = [
                'id_ref' => $ref['id_ref'],
                'nama_akun' => $ref['nama_akun'],
                'debit' => 0,
                'kredit' => 0
            ];

            switch ($ref['type']) {
                case 1:
                    $create_neraca_saldo['debit'] = $ref['total'];
                    break;
                case 2:
                    $create_neraca_saldo['kredit'] = $ref['total'];
                    break;
            }

            NeracaSaldo::create($create_neraca_saldo);
        }

        $laba_rugi = LabaRugi::where([
            'id_ref' => $ref['id_ref'],
            'type' => $ref['type'],
            'tanggal' => $ref['tanggal']
        ])->first();

        if (!empty($laba_rugi)) {
            switch ($ref['type']) {
                case 1:
                    $update_laba_rugi = [
                        'total' => $laba_rugi->total + $ref['total']
                    ];
                    break;
                case 2:
                    $update_laba_rugi = [
                        'total' => $laba_rugi->total + $ref['total']
                    ];
                    break;
            }

            $update_laba_rugi['jumlah'] = $laba_rugi->jumlah + 1;

            LabaRugi::where('id_laba_rugi', $laba_rugi->id_laba_rugi)->update($update_laba_rugi);

        } else {

            $create_laba_rugi = [
                'id_ref' => $ref['id_ref'],
                'nama_akun' => $ref['nama_akun'],
                'type' => $ref['type'],
                'jumlah' => 1,
                'total' => 0,
                'tanggal' => $ref['tanggal']
            ];

            $create_laba_rugi['total'] = $ref['total'];

            LabaRugi::create($create_laba_rugi);
        }

        $arus_kas = ArusKas::where([
            'id_ref' => $ref['id_ref'],
            'tanggal' => $ref['tanggal'],
            'type' => $ref['type']
        ])->first();

        if (!empty($arus_kas)) 
        {
            switch ($ref['type']) {
                case 1:
                    $update_arus_kas = [
                        'total' => $arus_kas->total + $ref['total']
                    ];
                    break;
                case 2:
                    $update_arus_kas = [
                        'total' => $arus_kas->total + $ref['total']
                    ];
                    break;
            }

            $update_arus_kas['jumlah'] = $laba_rugi->jumlah + 1;

            ArusKas::where('id_arus_kas', $arus_kas->id_arus)->update($update_arus_kas);
        } else {
            $create_arus_kas = [
                'id_ref' => $ref['id_ref'],
                'nama_akun' => $ref['nama_akun'],
                'type' => $ref['type'],
                'jumlah' => 1,
                'total' => 0,
                'tanggal' => $ref['tanggal']
            ];

            $create_arus_kas['total'] = $ref['total'];

            ArusKas::create($create_arus_kas);
        }
    }

    public function simpan(Request $request)
    {
        $ref = $request->validate([
            'ref' => 'required|integer',
            'tanggal' => 'required|date',
            'total' => 'required|numeric|min:0',
            'type' => 'required|in:1,2'
        ]);

        $ref['id_ref'] = $ref['ref'];
        unset($ref['ref']);

        $ref['nama_akun'] = Ref::where('id_ref', $ref['id_ref'])->first()->nama_akun;

        JurnalTransaksi::create($ref);

        $this->sync_report($ref);

        Alert::success('Berhasil', 'Jurnal Transaksi Berhasil Ditambahkan');

        return redirect()->route('jurnal-transaksi');
    }

    public function edit($id)
    {

        $jurnal_transaksi = JurnalTransaksi::where('id_jurnal_transaksi', $id)->first();

        return view('dashboard.pages.report.jurnal-transaksi.form', [
            'jurnal_transaksi' => $jurnal_transaksi,
            'refs' => Ref::all(),
            'page_meta' => [
                'title' => 'Edit Jurnal Transaksi',
                'action' => route('jurnal-transaksi.update', $jurnal_transaksi->id_jurnal_transaksi),
                'method' => 'PUT',
                'type' => 'edit'
            ]
        ]);
    }

    public function update(Request $request, $id)
    {

        $ref = $request->validate([
            'total' => 'required|numeric|min:0',
        ]);

        $jurnal_transaksi = JurnalTransaksi::where('id_jurnal_transaksi', $id)->first();

        if (empty($jurnal_transaksi)) {
            Alert::error('Gagal', 'Jurnal Transaksi Tidak Ditemukan');
            return redirect()->route('jurnal-transaksi');
        }

        $jurnal_transaksi_updated = JurnalTransaksi::where('id_jurnal_transaksi', $id)->update([
            'total' => $ref['total']
        ]);

        if (!$jurnal_transaksi_updated) {
            Alert::error('Gagal', 'Terjadi Kesalahan');
            return redirect()->route('jurnal-transaksi');
        }

        $this->sync_report([
            'id_ref' => $jurnal_transaksi->id_ref,
            'nama_akun' => $jurnal_transaksi->nama_akun,
            'type' => $jurnal_transaksi->type,
            'tanggal' => $jurnal_transaksi->tanggal,
            'total' => $ref['total'] - $jurnal_transaksi->total
        ]);

        Alert::success('Berhasil', 'Jurnal Transaksi Berhasil Diubah');

        return redirect()->route('jurnal-transaksi');
    }

    public function hapus($id)
    {
        $jurnal_transaksi = JurnalTransaksi::where('id_jurnal_transaksi', $id)->first();
        if (empty($jurnal_transaksi)) {
            Alert::error('Gagal', 'Jurnal Transaksi Tidak Ditemukan');
            return redirect()->route('jurnal-transaksi');
        }

        JurnalTransaksi::where('id_jurnal_transaksi', $id)->delete();

        // Jurnal Umum
        $jurnal_umum = JurnalUmum::where([
            'id_ref' => $jurnal_transaksi->id_ref,
            'tanggal' => $jurnal_transaksi->tanggal,
            'type' => $jurnal_transaksi->type
        ])->first();

        if (!empty($jurnal_umum)) {
            if ($jurnal_umum->total == $jurnal_transaksi->total) {
                JurnalUmum::where('id_jurnal_umum', $jurnal_umum->id_jurnal_umum)->delete();
            } else {
                JurnalUmum::where('id_jurnal_umum', $jurnal_umum->id_jurnal_umum)->update([
                    'total' => $jurnal_umum->total - $jurnal_transaksi->total
                ]);
            }
        }

        // Buku Besar
        $q_bukbes = [
            'id_ref' => $jurnal_transaksi->id_ref,
            'tanggal' => $jurnal_transaksi->tanggal,
        ];

        $buku_besar = BukuBesar::where($q_bukbes)->first();

        if (!empty($buku_besar)) {

            switch ($jurnal_transaksi->type) {
                case 1: // debit
                    if ($jurnal_transaksi->total == $buku_besar->debit && $buku_besar->kredit == 0.00) {
                        BukuBesar::where('id_buku_besar', $buku_besar->id_buku_besar)->delete();
                    } else {
                        $debit = $buku_besar->debit - $jurnal_transaksi->total;
                        BukuBesar::where('id_buku_besar', $buku_besar->id_buku_besar)->update([
                            'debit' => $debit
                        ]);
                    }
                    break;

                case 2: // kredit
                    if ($jurnal_transaksi->total == $buku_besar->kredit && $buku_besar->debit == 0.00) {
                        BukuBesar::where('id_buku_besar', $buku_besar->id_buku_besar)->delete();
                    } else {
                        $kredit = $buku_besar->kredit - $jurnal_transaksi->total;
                        BukuBesar::where('id_buku_besar', $buku_besar->id_buku_besar)->update([
                            'kredit' => $buku_besar->kredit - $jurnal_transaksi->total,
                        ]);
                    }
                    break;
            }
        }

        // Neraca Saldo
        $neraca_saldo = NeracaSaldo::where([
            'id_ref' => $jurnal_transaksi->id_ref
        ])->first();

        if (!empty($neraca_saldo)) {
            switch ($jurnal_transaksi->type) {
                case 1: // debit
                    $debit = $neraca_saldo->debit - $jurnal_transaksi->total;
                    if ($jurnal_transaksi->total == $neraca_saldo->debit && $neraca_saldo->kredit == 0.00) {
                        NeracaSaldo::where('id_neraca_saldo', $neraca_saldo->id_neraca_saldo)->delete();
                    } else {
                        NeracaSaldo::where('id_neraca_saldo', $neraca_saldo->id_neraca_saldo)->update([
                            'debit' => $debit
                        ]);
                    }
                    break;

                case 2: // kredit
                    $kredit = $neraca_saldo->kredit - $jurnal_transaksi->total;
                    if ($jurnal_transaksi->total == $neraca_saldo->kredit && $neraca_saldo->debit == 0.00) {
                        NeracaSaldo::where('id_neraca_saldo', $neraca_saldo->id_neraca_saldo)->delete();
                    } else {
                        NeracaSaldo::where('id_neraca_saldo', $neraca_saldo->id_neraca_saldo)->update([
                            'kredit' => $kredit
                        ]);
                    }
                    break;
            }
        }

        // Laba Rugi
        $laba_rugi = LabaRugi::where([
            'id_ref' => $jurnal_transaksi->id_ref,
            'type' => $jurnal_transaksi->type,
            'tanggal' => $jurnal_transaksi->tanggal
        ])->first();

        if (!empty($laba_rugi)) {

            if ($laba_rugi->total == $jurnal_transaksi->total && $laba_rugi->jumlah == 1) {
                LabaRugi::where('id_laba_rugi', $laba_rugi->id_laba_rugi)->delete();
            } else {
                LabaRugi::where('id_laba_rugi', $laba_rugi->id_laba_rugi)->update([
                    'total' => $laba_rugi->total - $jurnal_transaksi->total,
                    'jumlah' => $laba_rugi->jumlah - 1
                ]);
            }
        }

        // Arus Kas
        $arus_kas = ArusKas::where([
            'id_ref' => $jurnal_transaksi->id_ref,
            'type' => $jurnal_transaksi->type,
            'tanggal' => $jurnal_transaksi->tanggal
        ])->first();

        if (!empty($arus_kas)) {

            if ($arus_kas->total == $jurnal_transaksi->total && $arus_kas->jumlah == 1) {
                ArusKas::where('id_arus_kas', $arus_kas->id_arus_kas)->delete();
            } else {
                ArusKas::where('id_arus_kas', $arus_kas->id_arus_kas)->update([
                    'total' => $arus_kas->total - $jurnal_transaksi->total,
                    'jumlah' => $arus_kas->jumlah - 1
                ]);
            }
        }

        Alert::success('Berhasil', 'Jurnal Transaksi Berhasil Dihapus');

        return redirect()->route('jurnal-transaksi');
    }

    public function export()
    {
        if (!empty(session()->get('date-filter'))) 
        {
            $date = session()->get('date-filter');
            $jurnal_transaksi = JurnalTransaksi::whereBetween('tanggal', [$date['start'], $date['end']])->orderBy('tanggal', 'asc')->orderBy('created_at', 'asc')->get();

        } else {
            $jurnal_transaksi = JurnalTransaksi::orderBy('tanggal', 'asc')->orderBy('created_at', 'asc')->get();
        }

        $jurnal_transaksi->map(function ($jurnal_transaksi) {
            $jurnal_transaksi->kode = Ref::where('id_ref', $jurnal_transaksi->id_ref)->first()->kode;
        });

        $first = $jurnal_transaksi->last();
        $last = $jurnal_transaksi->first();

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

        $filename = "Jurnal Transaksi ({$periode}).pdf";

        $pdf = Pdf::loadView('dashboard.pages.report.jurnal-transaksi.export', [
            'jurnal_transaksi' => $jurnal_transaksi,
            'title' => $filename,
            'periode' => $periode
        ]);
        return $pdf->download($filename);
    }
}
