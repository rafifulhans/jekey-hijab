<?php

namespace App\Http\Controllers\Report;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JurnalUmum;

class JurnalUmumController extends Controller
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
            
            $jurnal_umum_all = JurnalUmum::whereBetween('tanggal', [$date_start, $date_end])->orderBy('tanggal', 'asc')->orderBy('created_at', 'asc')->get();

        } else {
            $jurnal_umum_all = JurnalUmum::orderBy('tanggal', 'asc')->orderBy('created_at', 'asc')->get();
        }

        $jurnal_umum = [];

        foreach ($jurnal_umum_all as $ju) {
            $jurnal_umum[date('Y', strtotime($ju->tanggal))][date('n', strtotime($ju->tanggal))][] = $ju;
            @$jurnal_umum[date('Y', strtotime($ju->tanggal))]['total'][$ju->type] += $ju->total;
        }

        return view('dashboard.pages.report.jurnal-umum.index', [
            'jurnal_umum' => $jurnal_umum,
            'date_filter' => date('m-d-Y', strtotime($date_start ?? 'now')) . ' - ' . date('m-d-Y', strtotime($date_end ?? 'now'))
        ]);
    }

    public function export()
    {
         if (!empty(session()->get('date-filter'))) 
        {
            $date = session()->get('date-filter');
            $jurnal_umum_all = JurnalUmum::whereBetween('tanggal', [$date['start'], $date['end']])->orderByDesc('tanggal')->orderByDesc('created_at')->get();

        } else {
            $jurnal_umum_all = JurnalUmum::orderByDesc('tanggal')->orderByDesc('created_at')->get();
        }

        $jurnal_umum = [];

        foreach ($jurnal_umum_all as $ju) {
            $jurnal_umum[date('Y', strtotime($ju->tanggal))][date('m', strtotime($ju->tanggal))][] = $ju;
        }

        // Ambil tanggal paling awal & akhir
        $first = JurnalUmum::orderBy('tanggal')->first();
        $last = JurnalUmum::orderByDesc('tanggal')->first();

        $start = $first ? date('d-m-Y', strtotime($first->tanggal)) : '-';
        $end = $last ? date('d-m-Y', strtotime($last->tanggal)) : '-';

        $filename = "Jurnal Umum ({$start} - {$end}).pdf";

        $pdf = Pdf::loadView('dashboard.pages.report.jurnal-umum.export', [
            'jurnal_umum' => $jurnal_umum,
            'title' => $filename
        ]);
        return $pdf->download($filename);
    }
}
