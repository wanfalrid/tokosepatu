<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        return count($cart);
    }

    public function add(Request $request)
    {
        $produk = Produk::findOrFail($request->id_produk);
        $cart = session()->get('cart', []);
        
        if (isset($cart[$produk->id_produk])) {
            $cart[$produk->id_produk]['quantity']++;
        } else {
            $cart[$produk->id_produk] = [
                'id_produk' => $produk->id_produk,
                'nama_produk' => $produk->nama_produk,
                'harga' => $produk->harga,
                'gambar' => $produk->gambar,
                'quantity' => 1
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => count($cart)
        ]);
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->id_produk])) {
            $cart[$request->id_produk]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        return response()->json(['success' => true]);
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->id_produk])) {
            unset($cart[$request->id_produk]);
            session()->put('cart', $cart);
        }
        
        return response()->json([
            'success' => true,
            'cart_count' => count($cart)
        ]);
    }

    public function clear()
    {
        session()->forget('cart');
        return response()->json(['success' => true]);
    }
}
