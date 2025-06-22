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
        // Ensure session is started
        if (!session()->isStarted()) {
            session()->start();
        }
        
        // Regenerate CSRF token to prevent issues
        session()->regenerateToken();
        
        return view('admin.produk.create');
    }    public function store(Request $request)
    {
        // Ensure session is active and check CSRF
        if (!$request->hasValidSignature() && !$request->session()->token() === $request->input('_token')) {
            // Session might be expired, regenerate and try again
            session()->regenerateToken();
        }
        
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
        
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            // Ensure product images directory exists
            $imageDir = public_path('storage/product_images');
            if (!file_exists($imageDir)) {
                mkdir($imageDir, 0755, true);
            }
            
            $file = $request->file('gambar');
            $filename = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($imageDir, $filename);
            $gambarPath = $filename;
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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $produk = Produk::findOrFail($id);
        
        $data = $request->only([
            'nama_produk', 'deskripsi', 'harga', 'stok', 
            'merek', 'kategori', 'warna', 'ukuran'
        ]);
        
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($produk->gambar && file_exists(public_path('storage/product_images/' . $produk->gambar))) {
                unlink(public_path('storage/product_images/' . $produk->gambar));
            }
            
            // Ensure product images directory exists
            $imageDir = public_path('storage/product_images');
            if (!file_exists($imageDir)) {
                mkdir($imageDir, 0755, true);
            }
            
            $file = $request->file('gambar');
            $filename = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($imageDir, $filename);
            $data['gambar'] = $filename;
        }
        
        $produk->update($data);
        
        return redirect()->route('admin.produk.index')
                        ->with('success', 'Produk berhasil diperbarui!');
    }
      public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Delete image if exists
        if ($produk->gambar && file_exists(public_path('storage/product_images/' . $produk->gambar))) {
            unlink(public_path('storage/product_images/' . $produk->gambar));
        }
        
        $produk->delete();
        
        return redirect()->route('admin.produk.index')
                        ->with('success', 'Produk berhasil dihapus!');
    }
}
