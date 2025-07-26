<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\NeracaSaldo;

class NeracaSaldoController extends Controller
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
            
            $neraca_saldo = NeracaSaldo::whereBetween('created_at', [$date_start, $date_end])->orderBy('id_ref')->get();
        } else {
            $neraca_saldo = NeracaSaldo::orderBy('id_ref')->get();
        }

        return view('dashboard.pages.report.neraca-saldo.index', [
            'neraca_saldo' => $neraca_saldo,
            'date_filter' => date('m-d-Y', strtotime($date_start ?? 'now')) . ' - ' . date('m-d-Y', strtotime($date_end ?? 'now'))
        ]);
    }

    public function export()
    {
        if (!empty(session()->get('date-filter'))) 
        {
            $date = session()->get('date-filter');
            $neraca_saldo = NeracaSaldo::whereBetween('created_at', [$date['start'], $date['end']])->orderBy('id_ref')->get();

        } else {
            $neraca_saldo = NeracaSaldo::orderBy('id_ref')->get();
        }

        $first = $neraca_saldo->first();
        $last = $neraca_saldo->last();

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

        $filename = "Neraca Saldo ({$periode}).pdf";

        $pdf = Pdf::loadView('dashboard.pages.report.neraca-saldo.export', [
            'neraca_saldo' => $neraca_saldo,
            'title' => $filename,
            'periode' => $periode
        ]);
        return $pdf->download($filename);
    }
}
