<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class HomeController extends Controller
{
    public function index()
    {
        $produkTerbaru = Produk::orderBy('dibuat_pada', 'desc')->take(8)->get();
        $produkPopuler = Produk::where('stok', '>', 0)->take(6)->get();
        
        return view('home', compact('produkTerbaru', 'produkPopuler'));
    }

    public function shop()
    {
        $produk = Produk::where('stok', '>', 0)->paginate(12);
        $merek = Produk::select('merek')->distinct()->whereNotNull('merek')->get();
        
        return view('shop', compact('produk', 'merek'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}