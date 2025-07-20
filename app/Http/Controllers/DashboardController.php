<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Number; // Import Number facade
use Auth;
use App\Models\Penjualan;


class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        
        switch ($user->role) {
            case 1: // Leader
                $total_penjualan = Penjualan::where('status_pembayaran', '=', 1)->count(); // 1 = Berhasil
                $total_revenue = Penjualan::where('status_pembayaran', '=', 1)->sum('total');
                $total_revenue = Number::currency($total_revenue, 'IDR', 'id_ID');

                return view('dashboard.users.leader.index', compact('total_penjualan', 'total_revenue'));
            case 2: // Sales 
                return redirect()->route('penjualan');
            case 3: // Finance
                return redirect()->route('jurnal-transaksi');
            default:
                return redirect()->route('dashboard');
        }
    }

    public function ringkasan_laporan(Request $request)
    {  
        $user = Auth::user();
        if ($user->role == 1 || $user->role == 2) 
        {
            // $ringkasan_keuangan = [
            //     ['title' => 'Total Pendapatan', 'value' => 'Rp. 10.000.000'],
            //     ['title' => 'Total Pengeluaran', 'value' => 'Rp. 5.000.000'],
            //     ['title' => 'Laba Bersih', 'value' => 'Rp. 5.000.000']
            //     ['title' => 'Laba Bersih', 'value' => 'Rp. 5.000.000']
            // ];
            return view('dashboard.pages.ringkasan_laporan');
        }
        
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
