<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('dibuat_pada', 'desc')->paginate(10);
        return view('admin.produk.index', compact('produk'));
    }
    
    public function create()
    {
        return view('admin.produk.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'merek' => 'required|string|max:100',
            'kategori' => 'required|string|max:100',
            'warna' => 'required|string|max:50',
            'ukuran' => 'required|string|max:100',
            'gambar' => 'nullable|string|max:255'
        ]);
        
        $produk = Produk::create([
            'id_produk' => 'PRD-' . strtoupper(Str::random(8)),
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'merek' => $request->merek,
            'kategori' => $request->kategori,
            'warna' => $request->warna,
            'ukuran' => $request->ukuran,
            'gambar' => $request->gambar,
            'dibuat_pada' => now()
        ]);
        
        return redirect()->route('admin.produk.index')
                        ->with('success', 'Produk berhasil ditambahkan!');
    }
    
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.show', compact('produk'));
    }
    
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.edit', compact('produk'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'merek' => 'required|string|max:100',
            'kategori' => 'required|string|max:100',
            'warna' => 'required|string|max:50',
            'ukuran' => 'required|string|max:100',
            'gambar' => 'nullable|string|max:255'
        ]);
        
        $produk = Produk::findOrFail($id);
        $produk->update($request->all());
        
        return redirect()->route('admin.produk.index')
                        ->with('success', 'Produk berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        
        return redirect()->route('admin.produk.index')
                        ->with('success', 'Produk berhasil dihapus!');
    }
}
