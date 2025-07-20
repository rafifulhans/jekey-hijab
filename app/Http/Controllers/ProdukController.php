<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.produk.index');
    }

    public function tambah()
    {
        return view('dashboard.pages.produk.form', [
            'page_meta' => [
                'title' => 'Tambah Produk',
                'type'  => 'create',
            ]
        ]);
    }
}
