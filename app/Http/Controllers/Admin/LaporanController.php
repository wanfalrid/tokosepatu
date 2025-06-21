<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Default date range (last 30 days)
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        // Parse dates for queries
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();
        
        // Sales Report
        $salesData = $this->getSalesReport($start, $end);
        
        // Product Report
        $productData = $this->getProductReport($start, $end);
        
        // Customer Report
        $customerData = $this->getCustomerReport($start, $end);
        
        // Chart data for sales trend
        $chartData = $this->getSalesChartData($start, $end);
        
        return view('admin.laporan.index', compact(
            'salesData', 
            'productData', 
            'customerData', 
            'chartData',
            'startDate',
            'endDate'
        ));
    }    private function getSalesReport($start, $end)
    {
        $totalPesanan = Pesanan::whereBetween('dibuat_pada', [$start, $end])->count();
        $totalPendapatan = Pesanan::whereBetween('dibuat_pada', [$start, $end])
            ->where('payment_status', 'paid')
            ->sum('total_harga');
        $rataRataOrderValue = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;
        
        // Status breakdown
        $statusBreakdown = Pesanan::whereBetween('dibuat_pada', [$start, $end])
            ->groupBy('status_pesanan')
            ->select('status_pesanan', DB::raw('count(*) as total'))
            ->get();
        
        // Add default status if no data
        if ($statusBreakdown->isEmpty()) {
            $statusBreakdown = collect([
                (object)['status_pesanan' => 'menunggu', 'total' => 0],
                (object)['status_pesanan' => 'diproses', 'total' => 0],
                (object)['status_pesanan' => 'dikirim', 'total' => 0],
                (object)['status_pesanan' => 'selesai', 'total' => 0],
            ]);
        }
        
        // Payment status breakdown
        $paymentBreakdown = Pesanan::whereBetween('dibuat_pada', [$start, $end])
            ->groupBy('payment_status')
            ->select('payment_status', DB::raw('count(*) as total'))
            ->get();
        
        return [
            'total_pesanan' => $totalPesanan,
            'total_pendapatan' => $totalPendapatan,
            'rata_rata_order' => $rataRataOrderValue,
            'status_breakdown' => $statusBreakdown,
            'payment_breakdown' => $paymentBreakdown
        ];
    }
    
    private function getProductReport($start, $end)
    {
        // Top selling products
        $topProducts = DB::table('detail_pesanan')
            ->join('pesanan', 'detail_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('produk', 'detail_pesanan.id_produk', '=', 'produk.id_produk')
            ->whereBetween('pesanan.dibuat_pada', [$start, $end])
            ->groupBy('detail_pesanan.id_produk', 'produk.nama_produk')
            ->select(
                'produk.nama_produk',
                DB::raw('SUM(detail_pesanan.jumlah) as total_terjual'),
                DB::raw('SUM(detail_pesanan.subtotal) as total_pendapatan')
            )
            ->orderBy('total_terjual', 'desc')
            ->limit(10)
            ->get();
        
        // Product stock status
        $lowStockProducts = Produk::where('stok', '<', 10)->count();
        $outOfStockProducts = Produk::where('stok', 0)->count();
        $totalProducts = Produk::count();
        
        return [
            'top_products' => $topProducts,
            'low_stock' => $lowStockProducts,
            'out_of_stock' => $outOfStockProducts,
            'total_products' => $totalProducts
        ];
    }
    
    private function getCustomerReport($start, $end)
    {
        $totalPelanggan = Pelanggan::count();
        $pelangganBaru = Pelanggan::whereBetween('dibuat_pada', [$start, $end])->count();
        $pelangganAktif = Pelanggan::where('status_akun', 'aktif')->count();
        
        // Customer status breakdown
        $statusBreakdown = Pelanggan::groupBy('status_akun')
            ->select('status_akun', DB::raw('count(*) as total'))
            ->get();
          // Top customers by order value
        $topCustomers = DB::table('pesanan')
            ->join('pelanggan', 'pesanan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
            ->whereBetween('pesanan.dibuat_pada', [$start, $end])
            ->where('pesanan.payment_status', 'paid')
            ->groupBy('pesanan.id_pelanggan', 'pelanggan.nama')
            ->select(
                'pelanggan.nama',
                DB::raw('COUNT(pesanan.id_pesanan) as total_pesanan'),
                DB::raw('SUM(pesanan.total_harga) as total_belanja')
            )
            ->orderBy('total_belanja', 'desc')
            ->limit(5)
            ->get();
        
        return [
            'total_pelanggan' => $totalPelanggan,
            'pelanggan_baru' => $pelangganBaru,
            'pelanggan_aktif' => $pelangganAktif,
            'status_breakdown' => $statusBreakdown,
            'top_customers' => $topCustomers
        ];
    }
    
    private function getSalesChartData($start, $end)
    {
        $days = [];
        $sales = [];
        
        $period = Carbon::parse($start);
        while ($period->lte($end)) {
            $dayStart = $period->copy()->startOfDay();
            $dayEnd = $period->copy()->endOfDay();
              $dailySales = Pesanan::whereBetween('dibuat_pada', [$dayStart, $dayEnd])
                ->where('payment_status', 'paid')
                ->sum('total_harga');
            
            $days[] = $period->format('Y-m-d');
            $sales[] = $dailySales;
            
            $period->addDay();
        }
        
        return [
            'labels' => $days,
            'data' => $sales
        ];
    }
    
    public function exportSales(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();
        
        $pesanan = Pesanan::with(['pelanggan', 'detailPesanan.produk'])
            ->whereBetween('dibuat_pada', [$start, $end])
            ->orderBy('dibuat_pada', 'desc')
            ->get();
        
        $filename = 'laporan_penjualan_' . $startDate . '_to_' . $endDate . '.csv';
        
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($pesanan) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
              // Header
            fputcsv($file, [
                'ID Pesanan',
                'Tanggal',
                'Pelanggan',
                'Total Harga',
                'Status Pesanan',
                'Status Pembayaran',
                'Metode Pengiriman'
            ]);
            
            // Data
            foreach ($pesanan as $order) {
                fputcsv($file, [
                    $order->id_pesanan,
                    $order->dibuat_pada instanceof \Carbon\Carbon ? 
                        $order->dibuat_pada->format('Y-m-d H:i:s') : 
                        date('Y-m-d H:i:s', strtotime($order->dibuat_pada)),
                    $order->pelanggan ? $order->pelanggan->nama : 'Guest',
                    number_format($order->total_harga, 0, ',', '.'),
                    ucfirst($order->status_pesanan),
                    ucfirst($order->payment_status ?: 'pending'),
                    $order->metode_pengiriman ?: '-'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
