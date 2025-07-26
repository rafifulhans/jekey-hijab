<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ArusKas;

class ArusKasController extends Controller
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
            
            $arus_kas_all = ArusKas::selectRaw('id_ref, type, nama_akun, SUM(total) as total, SUM(jumlah) as jumlah')
            ->whereBetween('tanggal', [$date_start, $date_end])
            ->groupBy('id_ref', 'type', 'nama_akun')
            ->get();

        } else {
            $arus_kas_all = ArusKas::selectRaw('id_ref, type, nama_akun, SUM(total) as total, SUM(jumlah) as jumlah')
            ->whereBetween('tanggal', [
                Carbon::now()->subMonths(3)->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->groupBy('id_ref', 'type', 'nama_akun') // <- tambahkan 'type' di sini
            ->get();
        }

        $arus_kas = [
            'masuk' => [],
            'keluar' => []
        ];
        foreach ($arus_kas_all as $lr) {

            switch ($lr['type']) {
                case 1: // debit
                    $arus_kas['masuk'][] = $lr;
                    break;

                case 2: // kredit
                    $arus_kas['keluar'][] = $lr;
                    break;
            }
        }

        if (empty($arus_kas['masuk']))
            $sum_masuk = 0;
        else
            $sum_masuk = array_sum(array_column($arus_kas['masuk'], 'total'));

        if (empty($arus_kas['keluar']))
            $sum_keluar = 0;
        else
            $sum_keluar = array_sum(array_column($arus_kas['keluar'], 'total'));

        $total_bersih = $sum_masuk - $sum_keluar;
        $total_pendapatan   = array_sum(array_column($arus_kas['masuk'], 'total'));
        $total_pengeluaran  = array_sum(array_column($arus_kas['keluar'], 'total'));

        return view('dashboard.pages.report.arus-kas.index', [
            'arus_kas' => $arus_kas,
            'total_bersih' => $total_bersih,
            'total_pendapatan' => $total_pendapatan,
            'total_pengeluaran' => $total_pengeluaran,
            'date_filter' => date('m-d-Y', strtotime($date_start ?? '-3 month')) . ' - ' . date('m-d-Y', strtotime($date_end ?? 'now'))
        ]);
    }

    public function export()
    {
        if (!empty(session()->get('date-filter'))) 
        {
            $date = session()->get('date-filter');
            
            $arus_kas_all = ArusKas::selectRaw('id_ref, type, nama_akun, SUM(total) as total, SUM(jumlah) as jumlah')
                ->whereBetween('tanggal', [$date['start'], $date['end']])
                ->groupBy('id_ref', 'type', 'nama_akun') // <- tambahkan 'type' di sini
                ->get();

        } else {

            $arus_kas_all = ArusKas::selectRaw('id_ref, type, nama_akun, SUM(total) as total, SUM(jumlah) as jumlah')
                ->whereBetween('tanggal', [
                    Carbon::now()->subMonths(3)->startOfDay(),
                    Carbon::now()->endOfDay()
                ])
                ->groupBy('id_ref', 'type', 'nama_akun') // <- tambahkan 'type' di sini
                ->get();
        }

        $arus_kas = [
            'masuk' => [],
            'keluar' => []
        ];
        foreach ($arus_kas_all as $lr) {

            switch ($lr['type']) {
                case 1: // debit
                    $arus_kas['masuk'][] = $lr;
                    break;

                case 2: // kredit
                    $arus_kas['keluar'][] = $lr;
                    break;
            }
        }

        if (empty($arus_kas['masuk']))
            $sum_masuk = 0;
        else
            $sum_masuk = array_sum(array_column($arus_kas['masuk'], 'total'));

        if (empty($arus_kas['keluar']))
            $sum_keluar = 0;
        else
            $sum_keluar = array_sum(array_column($arus_kas['keluar'], 'total'));

        $total_bersih = $sum_masuk - $sum_keluar;

        $arks = ArusKas::orderBy('tanggal')->get();

        $first = $arks->first();
        $last = $arks->last();

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

        $filename = "Arus Kas ({$periode}).pdf";

        $pdf = Pdf::loadView('dashboard.pages.report.arus-kas.export', [
            'title' => $filename,
            'arus_kas' => $arus_kas,
            'total_bersih' => $total_bersih,
            'periode' => $periode
        ]);
        return $pdf->download($filename);
    }
}
