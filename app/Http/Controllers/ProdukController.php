<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        $produkTerkait = Produk::where('merek', $produk->merek)
                              ->where('id_produk', '!=', $id)
                              ->where('stok', '>', 0)
                              ->take(4)
                              ->get();
        
        return view('produk.detail', compact('produk', 'produkTerkait'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $merek = $request->get('merek');
        $hargaMin = $request->get('harga_min');
        $hargaMax = $request->get('harga_max');
        
        $produk = Produk::where('stok', '>', 0);
        
        if ($query) {
            $produk->where('nama_produk', 'like', '%' . $query . '%');
        }
        
        if ($merek) {
            $produk->where('merek', $merek);
        }
        
        if ($hargaMin) {
            $produk->where('harga', '>=', $hargaMin);
        }
        
        if ($hargaMax) {
            $produk->where('harga', '<=', $hargaMax);
        }
        
        $produk = $produk->paginate(12);
        $merekList = Produk::select('merek')->distinct()->whereNotNull('merek')->get();
        
        return view('shop', compact('produk', 'merekList', 'query', 'merek', 'hargaMin', 'hargaMax'));
    }
}
