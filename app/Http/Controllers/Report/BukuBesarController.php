<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuBesar;
use Barryvdh\DomPDF\Facade\Pdf;


use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Ref;

class BukuBesarController extends Controller
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
            
            $buku_besar = BukuBesar::whereBetween('tanggal', [$date_start, $date_end])->orderBy('tanggal', 'asc')->orderBy('created_at', 'asc')->get();
        } else {
            $buku_besar = BukuBesar::orderBy('tanggal', 'asc')->orderBy('created_at', 'asc')->get();
        }

        $buku_besar_grouped = $buku_besar_ungroup = [];

        foreach ($buku_besar as $bukbes) 
        {
            if (!empty($bukbes->group))
            {
                $buku_besar_grouped[strtolower($bukbes->group)][Ref::with('bukuBesar')->where('id_ref', $bukbes->id_ref)->first()->kode]
                [date('Y', strtotime($bukbes->tanggal))]
                [date('n', strtotime($bukbes->tanggal))][] = $bukbes;
            } else {
                $buku_besar_ungroup[] = $bukbes;
            }
        }

        return view('dashboard.pages.report.buku-besar.index', [
            'buku_besar_ungrouped' => $buku_besar_ungroup,
            'buku_besar_grouped' => $buku_besar_grouped,
            'date_filter' => date('m-d-Y', strtotime($date_start ?? 'now')) . ' - ' . date('m-d-Y', strtotime($date_end ?? 'now'))
        ]);
    }

    public function add_group(Request $request)
    {
        $request->validate([
            'group' => 'required|string|min:3|max:255',
            'id_buku_besar' => 'required|numeric|exists:buku_besar,id_buku_besar',
            'keterangan' => 'required|string|min:3|max:255'
        ]);

        BukuBesar::where('id_buku_besar', $request->id_buku_besar)->update([
            'group'=> strtoupper($request->group),
            'keterangan'=> $request->keterangan
        ]);

        Alert::success('Sukses', 'Berhasil ditambahkan ke group (' . $request->group . ')');
        return redirect()->route('buku-besar');
    }

    public function export()
    {
        if (!empty(session()->get('date-filter'))) 
        {
            $date = session()->get('date-filter');
            $buku_besar = BukuBesar::whereBetween('tanggal', [$date['start'], $date['end']])->orderByDesc('tanggal')->orderByDesc('created_at')->get();

        } else {
            $buku_besar = BukuBesar::orderByDesc('tanggal')->orderByDesc('created_at')->get();
        }

        // Ambil tanggal paling awal & akhir
        $first = $buku_besar->first();
        $last = $buku_besar->last();

        $start = $first ? date('d-m-Y', strtotime($first->tanggal)) : '-';
        $end = $last ? date('d-m-Y', strtotime($last->tanggal)) : '-';

        $filename = "Buku Besar ({$start} - {$end}).pdf";

        $buku_besar_grouped = [];
        foreach ($buku_besar as $bukbes) {
            if (!empty($bukbes->group)) {
                $buku_besar_grouped[strtolower($bukbes->group)][Ref::where('id_ref', $bukbes->id_ref)->first()->kode ?? '-']
                [date('Y', strtotime($bukbes->tanggal))]
                [date('m', strtotime($bukbes->tanggal))][] = $bukbes;
            }
        }

        $pdf = Pdf::loadView('dashboard.pages.report.buku-besar.export', [
            'buku_besar' => $buku_besar,
            'buku_besar_grouped' => $buku_besar_grouped,
            'title' => $filename
        ]);
        return $pdf->download($filename);
    }
}
