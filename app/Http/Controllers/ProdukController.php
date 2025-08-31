<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use RealRashid\SweetAlert\Facades\Alert;

class ProdukController extends Controller
{
    public function indeks()
    {
        $produks = Produk::orderByDesc('created_at', 'desc')->get();
        return view('dashboard.users.sales.produk.index', [
            'produks' => $produks
        ]);
    }

    public function tambah()
    {
        return view('dashboard.users.sales.produk.form', [
            'produk' => new Produk(),
            'page_meta' => [
                'title' => 'Tambah Produk',
                'type' => 'create',
                'method' => 'POST',
                'action' => route('produk.simpan')
            ]
        ]);
    }

    public function simpan(Request $request)
    {
        $produk = $request->validate([
            'nama' => 'required|string|max:255|unique:produk,nama',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            // File dikirim
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->extension();
            $file->move(public_path('uploads/produk'), $filename);
        }

        unset($produk['gambar']);

        $produk['image'] = $filename ?? null;
        $produk['slug'] = str()->slug($produk['nama']);

        Produk::create($produk);

        Alert::success('Berhasil', 'Produk berhasil ditambahkan');

        return redirect()->route('produk');
    }

    public function edit($id)
    {
        return view('dashboard.users.sales.produk.form', [
            'produk' => Produk::findOrFail($id),
            'page_meta' => [
                'title' => 'Edit Produk',
                'type' => 'edit',
                'method' => 'PUT',
                'action' => route('produk.update', $id)
            ]
        ]);
    }

    // app/Http/Controllers/ProdukController.php

    public function update(Request $request, $id)
    {
        $produk_req = $request->validate([
            'nama' => 'required|string|max:255|unique:produk,nama,' . $id . ',id_produk',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $produk = Produk::where('id_produk', $id)->first();

        if ($produk_req['nama'] == $produk->nama && $produk_req['harga'] == $produk->harga && $produk_req['deskripsi'] == $produk->deskripsi && empty($request->gambar)) {
            Alert::warning('Tidak ada perubahan data');
            return redirect()->back();
        }

        if ($request->hasFile('gambar')) {

            if ($produk->image && file_exists(public_path('uploads/produk/' . $produk->image))) {
                unlink(public_path('uploads/produk/' . $produk->image));
            }

            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/produk'), $filename);

            $produk->image = $filename;
        }

        $produk->nama = $request->input('nama');
        $produk->harga = $request->input('harga');
        $produk->deskripsi = $request->input('deskripsi');

        $produk->save();

        Alert::success('Berhasil', 'Produk berhasil diubah');
        return redirect()->back();
    }

    public function hapus($id) 
    {
        $produk = Produk::where('id_produk', $id)->first();

        if ($produk->image && file_exists(public_path('uploads/produk/' . $produk->image))) {
            unlink(public_path('uploads/produk/' . $produk->image));
        }

        $produk->delete();

        Alert::success('Berhasil', 'Produk berhasil dihapus');
        return redirect()->route('produk');
    }
}
