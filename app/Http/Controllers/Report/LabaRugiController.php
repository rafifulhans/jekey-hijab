<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\LabaRugi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Number; // Import Number facade
use Barryvdh\DomPDF\Facade\Pdf;


class LabaRugiController extends Controller
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
            
            $laba_rugi_all = LabaRugi::selectRaw('id_ref, type, nama_akun, SUM(total) as total, SUM(jumlah) as jumlah')
            ->whereBetween('tanggal', [$date_start, $date_end])
            ->groupBy('id_ref', 'type', 'nama_akun')
            ->get();

        } else {
            $laba_rugi_all = LabaRugi::selectRaw('id_ref, type, nama_akun, SUM(total) as total, SUM(jumlah) as jumlah')
            ->whereBetween('tanggal', [
                Carbon::now()->subMonths(3)->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->groupBy('id_ref', 'type', 'nama_akun') // <- tambahkan 'type' di sini
            ->get();
        }

        $laba_rugi = [
            'pendapatan' => [],
            'beban' => []
        ];
        foreach ($laba_rugi_all as $lr) {

            switch ($lr['type']) {
                case 1: // debit
                    $laba_rugi['pendapatan'][] = $lr;
                    break;

                case 2: // kredit
                    $laba_rugi['beban'][] = $lr;
                    break;
            }
        }

        if (empty($laba_rugi['pendapatan']))
            $sum_pendapatan = 0;
        else
            $sum_pendapatan = array_sum(array_column($laba_rugi['pendapatan'], 'total'));

        if (empty($laba_rugi['beban']))
            $sum_beban = 0;
        else
            $sum_beban = array_sum(array_column($laba_rugi['beban'], 'total'));

        $total_bersih = $sum_pendapatan - $sum_beban;

        return view('dashboard.pages.report.laba-rugi.index', [
            'laba_rugi' => $laba_rugi,
            'total_bersih' => $total_bersih,
            'date_filter' => date('m-d-Y', strtotime($date_start ?? 'now')) . ' - ' . date('m-d-Y', strtotime($date_end ?? 'now'))
        ]);
    }

    public function export()
    {
        if (!empty(session()->get('date-filter'))) 
        {
            $date = session()->get('date-filter');
            
            
            $laba_rugi_all = LabaRugi::selectRaw('id_ref, type, nama_akun, SUM(total) as total, SUM(jumlah) as jumlah')
                ->whereBetween('tanggal', [$date['start'], $date['end']])
                ->groupBy('id_ref', 'type', 'nama_akun') // <- tambahkan 'type' di sini
                ->get();

        } else {

            $laba_rugi_all = LabaRugi::selectRaw('id_ref, type, nama_akun, SUM(total) as total, SUM(jumlah) as jumlah')
                ->whereBetween('tanggal', [
                    Carbon::now()->subMonths(3)->startOfDay(),
                    Carbon::now()->endOfDay()
                ])
                ->groupBy('id_ref', 'type', 'nama_akun') // <- tambahkan 'type' di sini
                ->get();
        }

        $laba_rugi = [
            'pendapatan' => [],
            'beban' => []
        ];
        foreach ($laba_rugi_all as $lr) {

            switch ($lr['type']) {
                case 1: // debit
                    $laba_rugi['pendapatan'][] = $lr;
                    break;

                case 2: // kredit
                    $laba_rugi['beban'][] = $lr;
                    break;
            }
        }

        if (empty($laba_rugi['pendapatan']))
            $sum_pendapatan = 0;
        else
            $sum_pendapatan = array_sum(array_column($laba_rugi['pendapatan'], 'total'));

        if (empty($laba_rugi['beban']))
            $sum_beban = 0;
        else
            $sum_beban = array_sum(array_column($laba_rugi['beban'], 'total'));

        $total_bersih = $sum_pendapatan - $sum_beban;

        $first = LabaRugi::orderBy('tanggal')->first();
        $last = LabaRugi::orderByDesc('tanggal')->first();

        $start = $first ? date('d-m-Y', strtotime($first->tanggal)) : '-';
        $end = $last ? date('d-m-Y', strtotime($last->tanggal)) : '-';

        $filename = "Laba Rugi ({$start} - {$end}).pdf";

        $pdf = Pdf::loadView('dashboard.pages.report.laba-rugi.export', [
            'title' => $filename,
            'laba_rugi' => $laba_rugi,
            'total_bersih' => $total_bersih
        ]);
        return $pdf->download($filename);
    }
}
