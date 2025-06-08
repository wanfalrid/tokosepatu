<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalProduk = Produk::count();
        $totalPesanan = Pesanan::count();
        $totalPelanggan = Pelanggan::count();
        $totalPendapatan = Pembayaran::where('status_pembayaran', 'lunas')->sum('jumlah_bayar');
        
        // Recent orders
        $pesananTerbaru = Pesanan::with(['pembayaran', 'detailPesanan'])
                                 ->orderBy('tanggal_pesanan', 'desc')
                                 ->take(5)
                                 ->get();
        
        // Monthly sales chart data
        $salesData = Pesanan::select(
            DB::raw('MONTH(tanggal_pesanan) as month'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(total_harga) as total_revenue')
        )
        ->whereYear('tanggal_pesanan', date('Y'))
        ->groupBy(DB::raw('MONTH(tanggal_pesanan)'))
        ->orderBy('month')
        ->get();
        
        // Top selling products
        $topProduk = Produk::select('produk.*', DB::raw('SUM(detail_pesanan.jumlah) as total_terjual'))
                          ->join('detail_pesanan', 'produk.id_produk', '=', 'detail_pesanan.id_produk')
                          ->groupBy('produk.id_produk')
                          ->orderBy('total_terjual', 'desc')
                          ->take(5)
                          ->get();
        
        // Low stock products
        $stokRendah = Produk::where('stok', '<=', 5)->where('stok', '>', 0)->get();
        
        return view('admin.dashboard', compact(
            'totalProduk', 'totalPesanan', 'totalPelanggan', 'totalPendapatan',
            'pesananTerbaru', 'salesData', 'topProduk', 'stokRendah'
        ));
    }
}
