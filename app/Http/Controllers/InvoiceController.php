<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Invoice;
use App\Models\Produk;
use App\Models\InvoiceBarang;

class InvoiceController extends Controller
{
    public function indeks()
    {
        $invoices = Invoice::orderByDesc('created_at')->get();
        return view('dashboard.users.sales.invoice.index', [
            'invoices' => $invoices
        ]);
    }

    public function tambah()
    {
        $produks = Produk::all();
        $metodes = MetodePembayaran::all();
        return view('dashboard.users.sales.invoice.form', [
            'invoice' => new Invoice(),
            'produks' => $produks,
            'metodes' => $metodes,
            'page_meta' => [
                'title' => 'Tambah Invoice',
                'action' => route('invoice.simpan'),
                'type' => 'create',
                'method' => 'POST'
            ]
        ]);
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_customer' => 'required|string|min:0|max:255',
            'alamat_customer' => 'required|string|min:0|max:255',
            'metode_pembayaran' => 'required|exists:metode_pembayaran,id_metode_pembayaran',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|numeric',

            'qty' => 'required|array',
            'qty.*' => 'required|numeric|min:1',

            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',

        ], [
            'nama_barang.*.required' => 'Kolom nama_barang harus dipilih.',
            'nama_barang.*.numeric' => 'Kolom nama_barang harus berupa angka.',
            'qty.*.required' => 'Kolom qty harus diisi.',
            'qty.*.numeric' => 'Kolom qty harus berupa angka.',
            'harga.*.required' => 'Kolom harga harus diisi.',
            'harga.*.numeric' => 'Kolom harga harus berupa angka.',
        ]);

        $lastInvoice = DB::table('invoice') // ganti dengan nama tabel kamu
            ->orderBy('invoice', 'desc')
            ->pluck('invoice')
            ->first();

        if ($lastInvoice) {
            // Ambil angka setelah "INV-"
            $number = (int) str_replace('INV-', '', $lastInvoice);
            $nextNumber = $number + 1;
        } else {
            $nextNumber = 1;
        }

        $invoiceNumber = 'INV-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $subtotal = 0;
        $idx = 0;

        foreach ($request->nama_barang as $nb)
        {
            $subtotal += $request->harga[$idx] * $request->qty[$idx];
            $idx++;
        }

        $total = $subtotal - $request->diskon;

        $invoice = Invoice::create([
            'invoice' => $invoiceNumber,
            'id_metode_pembayaran' => $request->metode_pembayaran,
            'metode_pembayaran' => MetodePembayaran::with('invoice')->where('id_metode_pembayaran', $request->input('metode_pembayaran'))->first()->nama,
            'tanggal' => $request->tanggal,
            'nama_customer' => $request->nama_customer,
            'alamat_customer' => $request->alamat_customer,
            'total_barang' => count($request->nama_barang),
            'subtotal' => $subtotal,
            'diskon' => $request->diskon ?? 0,
            'total' => $total
        ]);

        $rincian = [];

        foreach ($request->nama_barang as $key => $nb)
        {
            $rincian = [
                'id_invoice' => $invoice->id,
                'nama_barang' => Produk::where('id_produk', $nb)->first()->nama,
                'qty'   => $request->qty[$key],
                'harga' => $request->harga[$key],
                'total' => $request->harga[$key] * $request->qty[$key],
            ];

            InvoiceBarang::create($rincian);
        } 

        Alert::success('Sukes', 'Invoice berhasil dibuat!');

        return redirect()->route('invoice');
    }

    public function detail($id) {
        $invoice = Invoice::where('id_invoice', $id)->firstOrFail();
        $invoice_barang = InvoiceBarang::where('id_invoice', $invoice->id_invoice)->get();

        return view('dashboard.users.sales.invoice.show', [
            'invoice' => $invoice,
            'invoice_barang' => $invoice_barang
        ]);
    }
}
