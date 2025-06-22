<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('dibuat_pada', 'desc')->paginate(10);
        return view('admin.produk.index', compact('produk'));
    }    public function create()
    {
        return view('admin.produk.create');
    }    public function store(Request $request)
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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Store file using Laravel Storage
            $path = $file->storeAs('product_images', $filename, 'public');
            $gambarPath = $filename; // Store only filename in database
              // Debug log
            Log::info('Image uploaded', [
                'filename' => $filename,
                'path' => $path,
                'exists' => Storage::disk('public')->exists('product_images/' . $filename)
            ]);
        }
        
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
            'gambar' => $gambarPath,
            'dibuat_pada' => now()
        ]);
        
        return redirect()->route('admin.produk.index')
                        ->with('success', 'Produk berhasil ditambahkan!');
    }
      public function show(Produk $produk)
    {
        return view('admin.produk.show', compact('produk'));
    }
    
    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk'));
    }    public function update(Request $request, Produk $produk)
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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $data = $request->only([
            'nama_produk', 'deskripsi', 'harga', 'stok', 
            'merek', 'kategori', 'warna', 'ukuran'
        ]);        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($produk->gambar && Storage::disk('public')->exists('product_images/' . $produk->gambar)) {
                Storage::disk('public')->delete('product_images/' . $produk->gambar);
            }
            
            $file = $request->file('gambar');
            $filename = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Store file using Laravel Storage
            $path = $file->storeAs('product_images', $filename, 'public');
            $data['gambar'] = $filename; // Store only filename in database
            
            // Debug log
            Log::info('Image updated', [
                'filename' => $filename,
                'path' => $path,
                'exists' => Storage::disk('public')->exists('product_images/' . $filename)
            ]);
        }
        
        $produk->update($data);
        
        return redirect()->route('admin.produk.index')
                        ->with('success', 'Produk berhasil diperbarui!');
    }    public function destroy(Produk $produk)
    {
        // Delete image if exists
        if ($produk->gambar && Storage::disk('public')->exists('product_images/' . $produk->gambar)) {
            Storage::disk('public')->delete('product_images/' . $produk->gambar);
        }
        
        $produk->delete();
        
        return redirect()->route('admin.produk.index')
                        ->with('success', 'Produk berhasil dihapus!');
    }
}